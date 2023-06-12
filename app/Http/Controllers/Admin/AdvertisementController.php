<?php

namespace App\Http\Controllers\Admin;

use App\AdvertisementWithUs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AdvertisementController extends Controller {
	public function index(Request $request) {
		$query = AdvertisementWithUs::selectRaw('
            advertise_with_us.*
        ')
			->orderBy('advertise_with_us.id', 'DESC');

		if ($request->filter_name) {
			$query->where(function ($q) use ($request) {
				$q->where('advertise_with_us.fname', 'like', '%' . $request->filter_name . '%');
				$q->orWhere('advertise_with_us.lname', 'like', '%' . $request->filter_name . '%');
				$q->orWhere('advertise_with_us.email', 'like', '%' . $request->filter_name . '%');
				$q->orWhere('advertise_with_us.website', 'like', '%' . $request->filter_name . '%');
				$q->orWhere('advertise_with_us.business', 'like', '%' . $request->filter_name . '%');
				$q->orWhere('advertise_with_us.message', 'like', '%' . $request->filter_name . '%');
			});
		}

		$data['lists'] = $query->paginate();

		return view('admin.advertisement_with_us_classified.index', $data);
	}

	public function changeType(Request $request) {
		$json = array();

		$ad = AdvertisementWithUs::find((int) $request->id);
		if ($ad) {
			$ad->isPayed = $ad->isPayed == 'Y' ? 'N' : 'Y';
			$ad->save();

			$json['isPayed'] = $ad->isPayed;
			$json['success_message'] = $ad->isPayed == 'N' ? 'Advertisement Classifieds made free Successfully.' : 'Advertisement Classifieds made premium Successfully.';
		}

		return $json;
	}

	public function viewItem(Request $request) {
		$json = array();

		$data['ad'] = AdvertisementWithUs::selectRaw('
            advertise_with_us.*
        ')
			->where('advertise_with_us.id', (int) $request->id)->get()->first();

		return view('admin.advertisement_with_us_classified.view', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['room'] = AdvertisementWithUs::findOrNew($id);

		return view('admin.advertisement_with_us_classified.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$ad = AdvertisementWithUs::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120|unique:advertise_with_us,title',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$ad->name = $data['name'];
			$ad->url_slug = $this->clean($data['name']);

			$ad->code = $data['code'];
			$ad->save();

			\Session::flash('success', 'Advertisement Classifieds Data Saved Successfully.');
			$json['location'] = route('admin.advertisement_with_us_classified.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$ad = AdvertisementWithUs::findOrNew($id);
		$ad->remove();

		\Session::flash('success', 'Advertisement Classifieds Deleted Successfully.');
		return redirect()->back();
	}
}
