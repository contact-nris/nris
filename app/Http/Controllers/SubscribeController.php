<?php

namespace App\Http\Controllers;

use App\SubscribeNewsletter;
use Illuminate\Http\Request;
use Validator;

class SubscribeController extends Controller {
	private $listId = '86436bf22e';

	public function submitForm(Request $request) {
		$data = $request->all();

		$rules = array(
			'email' => 'required|email',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {

			$subscribe = new SubscribeNewsletter;
			$subscribe->email = $request->email;
			$subscribe->save();
			try {
				$mc = new \NZTim\Mailchimp\Mailchimp (env('MC_KEY'));

				$mc->subscribe($this->listId, $request->email, $merge = [], $confirm = true);
				\Session::flash('success', 'Congratulations! You have subscribed successfully to our newsletter.');
				$json['reload'] = true;
			} catch (\Throwable $th) {
				$response = $th->response();

				if (is_array($response)) {
					$json['errors']['email'] = $response['detail'];
				} else {
					$json['errors']['email'] = 'Something went wrong. Please try again later.';
				}
			}
		}
		return $json;
	}
}