<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\State;
use App\Temple;
use App\TempleType;
use Illuminate\Http\Request;
use Validator;

class FamousTemplesController extends Controller {
	public function index(Request $request) {
		$query = Temple::selectRaw('temples.*,states.country_id, cities.name as city_name, temples_type.type as temples_type_name')
			->leftJoin('states', 'states.code', 'temples.state_code')
			->leftJoin('cities', 'cities.id', 'temples.city_id')
			->leftJoin('temples_type', 'temples_type.id', 'temples.temple_type')
			->where('states.country_id', country_id());

		if ($request->state_code) {
			$query->where('temples.state_code', $request->state_code);
		}

		if ($request->filter_name) {
			$query->where('temples.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.famous.temples.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['states'] = State::all();
		$data['types'] = TempleType::all();
		$data['temple'] = Temple::findOrNew($id);

		return view('admin.famous.temples.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Temple::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$temple = Temple::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:temples,name',
			'state_code' => 'required',
			'temple_type' => 'required',
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
			$matchingRecords = Temple::where('url_slug', trim($this->clean($request->name)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->name);
			} else {
				$new_title = $request->name;
			}

			if ($id > 0) {
				if (trim($request->name) != $temple->name) {
					$temple->name = $new_title;
					$temple->url_slug = $this->clean($new_title);
				}} else {
				$temple->name = $new_title;
				$temple->url_slug = $this->clean($new_title);
			}
			$temple->state_code = $request->state_code;
			$temple->temple_type = $request->temple_type;
			$temple->contact = $request->contact;
			$temple->address = $request->address;
			$temple->url = $request->url;
			$temple->email_id = $request->email_id;
			$temple->status = $request->status;
			$temple->image = $temple->image ? $temple->image : $request->image;
			$temple->other_details = $request->other_details;

			$temple->meta_title = $request->meta_title;
			$temple->meta_description = $request->meta_description;
			$temple->meta_keywords = $request->meta_keywords;
			if ($request->hasFile('image')) {
				$temple->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/temples'), $temple->image);
			}

			$temple->save();

			\App\BusinessHour::sync($request->business_hours_type, $temple->id, $request);

			\Session::flash('success', 'Temple Data Saved Successfully.');
			$json['location'] = route('famous_temples.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$temple = Temple::findOrNew($id);
		$temple->remove();

		\Session::flash('success', 'Temple Deleted Successfully.');
		return redirect()->back();
	}
}
