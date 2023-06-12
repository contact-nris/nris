<?php

namespace App\Http\Controllers\Admin;

use App\Advertisement;
use App\Http\Controllers\Controller;
use App\State;
use Illuminate\Http\Request;
use Validator;

class FamousAdvertisementController extends Controller {
	public function index(Request $request) {
		$query = Advertisement::selectRaw('advertisements.*,states.country_id, cities.name as city_id')
			->leftJoin('states', 'states.code', 'advertisements.state_code')
			->leftJoin('cities', 'cities.id', 'advertisements.city_id')
			->where('states.country_id', country_id());

		if ($request->state_code) {
			$query->where('advertisements.state_code', $request->state_code);
		}

		if ($request->filter_name) {
			$query->where('advertisements.adv_name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.famous.advertisement.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['states'] = State::all();
		$data['advertisement'] = Advertisement::findOrNew($id);

		return view('admin.famous.advertisement.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Advertisement::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$advertisement = Advertisement::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
			'ad_title' => 'required|min:5|max:120',
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
			$matchingRecords = Advertisement::where('url_slug', trim($this->clean($request->name)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->name);
			} else {
				$new_title = $request->name;
			}

			if ($id > 0) {
				if (trim($request->name) != $advertisement->adv_name) {
					$advertisement->adv_name = $new_title;
					$advertisement->url_slug = $this->clean($new_title);
				}} else {
				$advertisement->adv_name = $new_title;
				$advertisement->url_slug = $this->clean($new_title);
			}
			$advertisement->ad_title = $request->ad_title;
			$advertisement->state_code = $request->state_code;
			$advertisement->city_id = (int) $request->city_id;
			$advertisement->contact = $request->contact;
			$advertisement->address = $request->address;
			$advertisement->ad_position = $request->ad_position;
			$advertisement->ad_position_no = $request->ad_position_no;
			$advertisement->sdate = date("Y-m-d", strtotime($request->sdate));
			$advertisement->edate = date("Y-m-d", strtotime($request->edate));
			$advertisement->amount = $request->amount;
			$advertisement->url = $request->url;
			$advertisement->email_id = $request->email_id;
			$advertisement->status = $request->status;
			$advertisement->image = $request->image;
			$advertisement->other_details = $request->other_details;

			if ($request->hasFile('image')) {
				$advertisement->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/myadimg'), $advertisement->image);
			}

			$advertisement->save();

			\App\BusinessHour::sync($request->business_hours_type, $advertisement->id, $request);

			\Session::flash('success', 'Advertisements Data Saved Successfully.');
			$json['location'] = route('famous_advertisements.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$advertisement = Advertisement::findOrNew($id);
		$advertisement->remove();

		\Session::flash('success', 'Advertisements Deleted Successfully.');
		return redirect()->back();
	}
}
