<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Sport;
use App\SportType;
use App\State;
use Illuminate\Http\Request;
use Validator;

class FamousSportController extends Controller {
	public function index(Request $request) {
		$query = Sport::selectRaw('sports.*,states.country_id, cities.name as city_name, sports_type.type as sports_type_name')
			->leftJoin('states', 'states.code', 'sports.state_code')
			->leftJoin('cities', 'cities.id', 'sports.city_id')
			->leftJoin('sports_type', 'sports_type.id', 'sports.sport_type')
			->where('states.country_id', country_id());

		if ($request->state_code) {
			$query->where('sports.state_code', $request->state_code);
		}

		if ($request->filter_name) {
			$query->where('sports.name', 'like', '%' . $request->filter_name . '%');
		}
		$query->orderBy('id', 'DESC');
		$data['lists'] = $query->paginate();

		return view('admin.famous.sport.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['states'] = State::all();
		$data['types'] = SportType::all();
		$data['sport'] = Sport::findOrNew($id);

		return view('admin.famous.sport.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Sport::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$sport = Sport::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:sports,name',
			'state_code' => 'required',
			'sport_type' => 'required',
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
			$matchingRecords = Sport::where('url_slug', trim($this->clean($request->name)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->name);
			} else {
				$new_title = $request->name;
			}

			if ($id > 0) {
				if (trim($request->name) != $sport->name) {
					$sport->name = $new_title;
					$sport->url_slug = $this->clean($new_title);
				}} else {
				$sport->name = $new_title;
				$sport->url_slug = $this->clean($new_title);
			}
			$sport->name = $data['name'];
			$sport->url_slug = $this->clean($data['name']);

			$sport->state_code = $request->state_code;
			$sport->city_id = (int) $request->city_id;
			$sport->sport_type = $request->sport_type;
			$sport->contact = $request->contact;
			$sport->address = $request->address;
			$sport->url = $request->url;
			$sport->email_id = $request->email_id;
			$sport->status = $request->status;
			$sport->image = $request->image;
			$sport->other_details = $request->other_details;
			$sport->meta_title = $request->meta_title;
			$sport->meta_description = $request->meta_description;
			$sport->meta_keywords = $request->meta_keywords;
			if ($request->hasFile('image')) {
				$sport->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/sports'), $sport->image);
			}

			$sport->save();
			\App\BusinessHour::sync($request->business_hours_type, $sport->id, $request);

			\Session::flash('success', 'Sport Data Saved Successfully.');
			$json['location'] = route('famous_sports.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$sport = Sport::findOrNew($id);
		$sport->remove();

		\Session::flash('success', 'Sport Deleted Successfully.');
		return redirect()->back();
	}
}
