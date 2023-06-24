<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Exception;
use Socialite;

class FacebookController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function redirectToFB() {
		return Socialite::driver('facebook')->redirect();
	}

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function handleCallback() {
		echo "HETRE";
		echo "<br>";
		echo "gfhbvhntggdfr1325467897";
		die();

		try {

			$user = Socialite::driver('facebook')->user();

			$finduser = User::where('facebook_id', $user->id)->first();

			if ($finduser) {

				Auth::login($finduser);

				return redirect('/home');

			} else {
				$newUser = new User();
				$newUser->facebook_id = $user->id;
				$newUser->email = $user->email;
				$newUser->first_name = $user->user['given_name'] ?: $user->name;
				$newUser->last_name = $user->user['family_name'] ?: $user->name;
				$newUser->dob = '0000-00-00';
				$newUser->password = Hash::make('123456dummy');
				$newUser->save();

				Auth::login($newUser);

				return redirect('/home');
			}

		} catch (Exception $e) {
			dd($e->getMessage());
		}
	}
}