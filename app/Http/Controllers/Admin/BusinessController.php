<?php

namespace App\Http\Controllers\Admin;

use App\Business;
use App\BusinessType;
use App\Http\Controllers\Controller;
use App\State;
use Illuminate\Http\Request;
use Validator;

class FamousBusinessController extends Controller {
	public function index(Request $request) {
		$query = Business::selectRaw('business.*,states.country_id, cities.name as city_id, business_type.type as business_type_name')
			->leftJoin('states', 'states.code', 'business.state_code')
			->leftJoin('cities', 'cities.id', 'business.city_id')
			->leftJoin('business_type', 'business_type.id', 'business.business_type')
			->where('states.country_id', country_id());

		if ($request->state_code) {
			$query->where('business.state_code', $request->state_code);
		}

		if ($request->filter_name) {
			$query->where('business.business_name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.business.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['states'] = State::all();
		$data['types'] = BusinessType::all();
		$data['business'] = Business::findOrNew($id);

		return view('admin.business.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Business::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$business = Business::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
			'state_code' => 'required',
			'business_type' => 'required',
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
			$matchingRecords = Business::where('url_slug', trim($this->clean($request->name)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->name);
			} else {
				$new_title = $request->name;
			}
			if ($id > 0) {
				if (trim($request->name) != $business->business_name) {
					$business->business_name = $new_title;
					$business->url_slug = $this->clean($new_title);
				}} else {
				$business->business_name = $new_title;
				$business->url_slug = $this->clean($new_title);
			}
			$business->state_code = $request->state_code;
			$business->city_id = (int) $request->city_id;
			$business->business_type = $request->business_type;
			$business->contact = $request->contact;
			$business->address = $request->address;
			$business->url = $request->url;
			$business->email_id = $request->email_id;
			$business->status = $request->status;
			$business->image = $business->image ? $business->image : $request->image;
			$business->other_details = $request->other_details;

			$business->meta_title = $request->meta_title;
			$business->meta_description = $request->meta_description;
			$business->meta_keywords = $request->meta_keywords;

			if ($request->hasFile('image')) {
				$business->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/business'), $business->image);
			}

			$business->save();
			\App\BusinessHour::sync($request->business_hours_type, $business->id, $request);

			\Session::flash('success', 'business Data Saved Successfully.');
			$json['location'] = route('business.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$business = Business::findOrNew($id);
		$business->remove();

		\Session::flash('success', 'business Deleted Successfully.');
		return redirect()->back();
	}
}
