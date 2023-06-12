<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class CountryController extends Controller {
	public function index() {
		$data['lists'] = Country::paginate();
		return view('admin.country.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['country'] = Country::findOrNew($id);

		return view('admin.country.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$country = Country::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
			'code' => 'required|min:2|max:10',
			'color' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$country->name = $data['name'];
			$country->color = $data['color'];
			$country->code = $data['code'];

			$country->c_meta_title = $request->meta_title;
			$country->c_meta_description = $request->meta_description;
			$country->c_meta_keywords = $request->meta_keywords;

			if ($request->hasFile('image')) {
				$country->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/country'), $country->image);
			}
			$country->save();

			\Session::flash('success', 'Country Data Saved Successfully.');
			$json['location'] = route('country.index');
		}

		return $json;
	}

	public function deleteItem(Request $request) {
		$data = $request->all();
		if (Hash::check($data['use_password'], Auth::user()->password)) {
			$state = Country::findOrNew($data['del_val']);
			$state->remove();

			\Session::flash('success', 'Country Deleted Successfully.');
			return redirect()->back();
		} else {
			\Session::flash('error', 'Enter Worng Password.');
			return redirect()->back();
		}
	}
}
