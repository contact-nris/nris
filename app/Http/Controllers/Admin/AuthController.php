<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Redirect;
use Validator;

class AuthController extends Controller {
	public function index(Request $request) {
		$data = array();

		return view('admin.auth.login', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$rules = array(
			'email' => 'required|email',
			'password' => 'required',
		);

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return Redirect::route('admin.login')->withErrors($validator)->withInput($request->except('password'));
		} else {

			$userdata = array(
				'email' => $request->email,
				'password' => $request->password,
			);

			if (Auth::guard('admin')->attempt($userdata)) {
				return Redirect::route('dashboard');
			} else {
				return Redirect::route('admin.login')->withErrors(['email' => 'Invalid password'])->withInput($request->except('password'));
			}
		}
	}

	public function logout() {
		Auth::guard('admin')->logout();
		return redirect('/admin');
	}

}