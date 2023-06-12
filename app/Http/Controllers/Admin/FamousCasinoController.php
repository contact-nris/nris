<?php

namespace App\Http\Controllers\Admin;

use App\Casino;
use App\Http\Controllers\Controller;
use App\State;
use Illuminate\Http\Request;
use Validator;

class FamousCasinoController extends Controller {
	public function index(Request $request) {
		$query = Casino::selectRaw('casinos.*,states.country_id, cities.name as city_id')
			->leftJoin('states', 'states.code', 'casinos.state_code')
			->leftJoin('cities', 'cities.id', 'casinos.city_id')
			->where('states.country_id', country_id());

		if ($request->state_code) {
			$query->where('casinos.state_code', $request->state_code);
		}

		if ($request->filter_name) {
			$query->where('casinos.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.famous.casino.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['states'] = State::all();
		$data['casino'] = Casino::findOrNew($id);

		return view('admin.famous.casino.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Casino::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$casino = Casino::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
			'state_code' => 'required',
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
			$matchingRecords = Casino::where('url_slug', trim($this->clean($request->name)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->name);
			} else {
				$new_title = $request->name;
			}

			if ($id > 0) {
				if (trim($request->name) != $casino->name) {
					$casino->name = $new_title;
					$casino->url_slug = $this->clean($new_title);
				}} else {
				$casino->name = $new_title;
				$casino->url_slug = $this->clean($new_title);
			}
			$casino->state_code = $request->state_code;
			$casino->city_id = (int) $request->city_id;
			$casino->contact = $request->contact;
			$casino->address = $request->address;
			$casino->url = $request->url;
			$casino->email_id = $request->email_id;
			$casino->status = $request->status;
			$casino->image = $casino->image ? $casino->image : $request->image;
			$casino->other_details = $request->other_details;

			$casino->meta_title = $request->meta_title;
			$casino->meta_description = $request->meta_description;
			$casino->meta_keywords = $request->meta_keywords;

			if ($request->hasFile('image')) {
				$casino->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/casinos'), $casino->image);
			}

			$casino->save();
			\App\BusinessHour::sync($request->business_hours_type, $casino->id, $request);

			\Session::flash('success', 'casino Data Saved Successfully.');
			$json['location'] = route('famous_casinos.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$casino = Casino::findOrNew($id);
		$casino->remove();

		\Session::flash('success', 'casino Deleted Successfully.');
		return redirect()->back();
	}
}
