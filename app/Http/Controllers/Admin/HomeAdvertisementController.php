<?php

namespace App\Http\Controllers\Admin;

use App\Categories;
use App\HomeAdvertisement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Validator;

class HomeAdvertisementController extends Controller {
	public function index(Request $request) {
		$query = HomeAdvertisement::selectRaw('home_advertisements.*')->where('country_id', Session::get('country_id'));

		$data['lists'] = $query->orderBy('id', 'DESC')->paginate();
		return view('admin.home_advertisement.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['advertisement'] = HomeAdvertisement::findOrNew($id);
		$data['categories'] = Categories::selectRaw('categories.*')->orderBy('id', 'ASC')->get();

		return view('admin.home_advertisement.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$advertisement = HomeAdvertisement::findOrNew($id);
		$rules = array(
			'adv_name' => 'required|min:2|max:120',
			// 'address' => 'required',
			// 'contact' => 'required',
			'sdate' => 'required',
			'edate' => 'required',
			'status' => 'required',
			'country_id' => 'required',
			'categories_id' => 'required',

		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$advertisement->adv_name = $request->adv_name;
			$advertisement->contact = $request->contact;
			$advertisement->address = $request->address;
			$advertisement->amount = (double) $request->amount;
			$advertisement->ad_position_no = (int) $request->ad_position_no;
			$advertisement->ad_position = $request->ad_position;
			$advertisement->country_id = (int) $request->country_id;
			$advertisement->state_id = (int) $request->state_id;
			$advertisement->url = $request->url;
			$advertisement->sdate = $request->sdate ? date("Y-m-d", strtotime($request->sdate)) : null;
			$advertisement->edate = $request->edate ? date("Y-m-d", strtotime($request->edate)) : null;
			$advertisement->status = (int) $request->status;
			$advertisement->categories_id = (int) $request->categories_id;

			if ($request->hasFile('image')) {
				$advertisement->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/us_ads'), $advertisement->image);
			}

			$advertisement->save();

			\Session::flash('success', 'Home Advertisement Data Saved Successfully.');
			$json['location'] = route('home_advertisement.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$advertisement = HomeAdvertisement::findOrNew($id);
		$advertisement->remove();

		\Session::flash('success', 'Home Advertisement Deleted Successfully.');
		return redirect()->back();
	}
}
