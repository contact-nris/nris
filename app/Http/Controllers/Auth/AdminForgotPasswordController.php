<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AdminForgotPasswordController extends Controller {
	/*
	    |--------------------------------------------------------------------------
	    | Password Reset Controller
	    |--------------------------------------------------------------------------
	    |
	    | This controller is responsible for handling password reset emails and
	    | includes a trait which assists in sending these notifications from
	    | your application to your users. Feel free to explore this trait.
	    |
*/

	use SendsPasswordResetEmails;
	protected function broker() {
		return Password::broker('admins');
	}
	public function showLinkRequestForm() {
		return view('admin.auth.passwords.email');
	}

	public function sendResetLinkEmail(Request $request) {
		$this->validate($request, ['email' => 'required|email']);

		// We will send the password reset link to this user. Once we have attempted
		// to send the link, we will examine the response then see the message we
		// need to show to the user. Finally, we'll send out a proper response.
		$response = $this->broker()->sendResetLink(
			$request->only('email')
		);

		switch ($response) {
		case Password::RESET_LINK_SENT:
			return redirect('/admin')->with('success', 'Password reset link has been sent to your email address.');
		case Password::INVALID_USER:
		default:
			return redirect()->back()->withErrors(['email' => 'We can\'t find a user with that e-mail address.']);
		}
	}

}
