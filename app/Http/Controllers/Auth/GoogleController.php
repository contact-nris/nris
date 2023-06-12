<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Exception;
use Hash;
use Socialite;

class GoogleController extends Controller {
	public function redirectToGoogle() {
		return Socialite::driver('google')->redirect();
	}

	public function handleGoogleCallback() {
		try {
			$user = Socialite::driver('google')->user();
			$finduser = User::where('google_id', $user->id)->first();
			if ($finduser) {
				Auth::login($finduser);
				return redirect('/');
			} else {
				$newUser = new User();
				$newUser->google_id = $user->id;
				$newUser->email = $user->email;
				$newUser->first_name = $user->user['given_name'] ?: $user->name;
				$newUser->last_name = $user->user['family_name'] ?: $user->name;
				$newUser->dob = '0000-00-00';
				$newUser->password = Hash::make('123456dummy');
				$newUser->save();

				Auth::login($newUser);

				return redirect('/');
			}
		} catch (Exception $e) {
			dd($e->getMessage());
		}
	}
}
