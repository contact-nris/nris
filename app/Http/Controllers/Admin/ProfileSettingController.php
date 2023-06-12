<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class ProfileSettingController extends Controller {
	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['profile'] = Auth::user();

		return view('admin.profile.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$profile = Auth::user();

		$rules = array(
			'name' => 'required|max:120',
			'email' => 'required|email|unique:admins',
			'username' => 'required|unique:admins,username',
		);

		if ((int) $profile->id == 0 || $request->password) {
			$rules['password'] = 'required|min:6';
		}
		if ((int) $profile->id > 0) {
			$rules['email'] = 'required|email|unique:admins,email,' . $profile->id;
			$rules['username'] = 'required|unique:admins,username,' . $profile->id;
		}

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$profile->name = $request->name;
			$profile->username = $request->username;
			$profile->email = $request->email;
			$profile->contact_no = $request->contact_no;

			if ($request->password) {
				$profile->password = Hash::make($request->password);
			}
			$profile->save();

			\Session::flash('success', 'Profile Saved Successfully.');
			$json['location'] = route('admin.index');
		}

		return $json;
	}
}
