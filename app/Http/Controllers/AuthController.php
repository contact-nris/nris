<?php

namespace App\Http\Controllers;

use App\State;
use App\User;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Validator;

class AuthController extends Controller {

	public function mailverification(Request $request, $id) {
		$data['mailverify'] = User::where('unique_id', $id)->first();

		if ($data['mailverify']) {
			if ($data['mailverify']->is_verify == 0) {

				User::where('unique_id', $id)
					->update([
						'is_verify' => 1,
						'unique_id' => '',
					]);

				\Session::flash('success', 'Account verify successfully!');
			} else {
				\Session::flash('success', 'Account alredy verify!');
			}
		} else {
			\Session::flash('success', 'Invalid verification URL');
		}
		return response()->redirectTo('/');
	}

	public function getState(Request $request) {
		$data['states'] = State::where("country_id", $request->country_id)
			->get();
		return response()->json($data);
	}
	public function register(Request $request) {
		$data = $request->all();
		$verify_id = uniqname();

		$rules = array(
			'email' => 'required|email|unique:users',
			//'email' => 'required|email',
			'first_name' => 'required',
			'last_name' => 'required',
			'dob' => 'required',
			'agree' => 'required',
			'password' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$user = new User();
			$user->email = $request->email;
			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			$user->dob = $request->dob;
			$user->password = Hash::make($request->password);
			$user->country = $request->country;
			$user->state = $request->state;
			$user->unique_id = $verify_id;
			$user->save();

			$mail_data = array(
				'link' => url("verifyemail/" . $verify_id),
				'email' => $request->email,
				'type' => 'Verification',
				'name' => $request->first_name . $request->last_name,
				'sub_type' => 'Register Email Addres',
			);
			sendCommentAlert($mail_data);
			\Session::flash('success', 'An email has been sent with a link to activate your account. please confirm email to login');
			$json['reload'] = true;
		}
		return $json;
	}

	public function login(Request $request) {
		$data = $request->all();

		$rules = array(
			'email' => 'required|email',
			'password' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {

			$userdata = array(
				'email' => $request->email,
				'password' => $request->password,
			);

			$data['login'] = User::where('email', $request->email)->first();
			if ($data['login'] && Hash::check($request->password, $data['login']->password)) {
				if (!$data['login']->is_verify == 0) {
					if (Auth::attempt($userdata, ($request->remember ? true : false))) {
						\Session::flash('success', 'Login Successfully.');
						//$json['reload'] = true;
						$json['success'] = true;
					}
				} else {
					$json['errors']['email'] = 'Your Email is not verified! Please verify your email successfully.';

				}
			} else {
				$json['errors']['email'] = 'Invalid email address or password.';
			}
		}

//print_r($json);

		return $json;
	}

	public function logout(Request $request) {
		Auth::logout();
		return redirect()->back();
	}

	public function forgotPassword(Request $request) {
		$data = $request->all();

		$rules = array(
			'email' => 'required|email|exists:users',
		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
			return $json;
		}

		$status = Password::sendResetLink(
			$request->only('email')
		);

		$mail_data = array(
			'link' => url("verifyemail/" . $verify_id),
			'email' => $request->email,
			'type' => 'Verification',
			'name' => $request->first_name . $request->last_name,
			'sub_type' => 'Forgot Password',
		);
		sendCommentAlert($mail_data);

		if ($status === Password::RESET_LINK_SENT) {
			\Session::flash('success', 'A reset link has been sent to your email address.');
			$json['reload'] = true;
		} else {
			$json['errors']['email'] = $status;
		}

		return $json;
	}

	public function resetPassword(Request $request) {
		$data = $request->all();

		$rules = array(
			'token' => 'required',
			'email' => 'required|email|exists:users',
			'password' => 'required|confirmed',
		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
			return $json;
		}

		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function ($user, $password) {
				$user->forceFill([
					'password' => Hash::make($password),
				]);

				$user->save();

				event(new PasswordReset($user));
			}
		);

		if ($status === Password::PASSWORD_RESET) {
			\Session::flash('success', 'Password reset successfully.');
			$json['location'] = route('home');
		} else {
			\Session::flash('error', 'Token Expired or Invalid Token.');
			$json['reload'] = true;
		}

		return $json;
	}

}