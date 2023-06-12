<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\State;
use App\Theater;
use App\TheaterType;
use Illuminate\Http\Request;
use Validator;

class FamousTheaterController extends Controller {
	public function index(Request $request) {
		$query = Theater::selectRaw('theaters.*,states.country_id, cities.name as city_id, theaters_type.type as theaters_type_name')
			->leftJoin('states', 'states.code', 'theaters.state_code')
			->leftJoin('cities', 'cities.id', 'theaters.city_id')
			->leftJoin('theaters_type', 'theaters_type.id', 'theaters.theater_type')
			->where('states.country_id', country_id());

		if ($request->state_code) {
			$query->where('theaters.state_code', $request->state_code);
		}

		if ($request->filter_name) {
			$query->where('theaters.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.famous.theater.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['states'] = State::all();
		$data['types'] = TheaterType::all();
		$data['theater'] = Theater::findOrNew($id);

		return view('admin.famous.theater.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Theater::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$theater = Theater::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:theaters,name',
			'state_code' => 'required',
			'theater_type' => 'required',
			'address' => 'required',
			'contact' => 'required',
			'status' => 'required',
		);

		if ($request->email_id) {
			$rules['email_id'] = 'email';
		}

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = Theater::where('url_slug', trim($this->clean($request->name)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->name);
			} else {
				$new_title = $request->name;
			}

			if ($id > 0) {
				if (trim($request->name) != $theater->name) {
					$theater->name = $new_title;
					$theater->url_slug = $this->clean($new_title);
				}} else {
				$theater->name = $new_title;
				$theater->url_slug = $this->clean($new_title);
			}
			$theater->state_code = $request->state_code;
			$theater->city_id = (int) $request->city_id;
			$theater->theater_type = $request->theater_type;
			$theater->contact = $request->contact;
			$theater->address = $request->address;
			$theater->url = $request->url;
			$theater->email_id = $request->email_id;
			$theater->status = $request->status;
			$theater->image = $theater->image ? $theater->image : $request->image;
			$theater->other_details = $request->other_details;
			$theater->meta_title = $request->meta_title;
			$theater->meta_description = $request->meta_description;
			$theater->meta_keywords = $request->meta_keywords;
			if ($request->hasFile('image')) {
				$theater->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/theaters'), $theater->image);
			}

			$theater->save();
			\App\BusinessHour::sync($request->business_hours_type, $theater->id, $request);
			\Session::flash('success', 'theater Data Saved Successfully.');
			$json['location'] = route('famous_theaters.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$theater = Theater::findOrNew($id);
		$theater->remove();

		\Session::flash('success', 'theater Deleted Successfully.');
		return redirect()->back();
	}
}
