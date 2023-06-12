<?php

namespace App\Http\Controllers;

use App\ads_bid;
use Auth;
use Illuminate\Http\Request;
use Validator;

class AdsBidController extends Controller {

	public function getdata(Request $request, $slug) {

		return view('front.auto.view', $data);
	}

	public function from_bid_ads(Request $request) {
		$data = $request->all();
		$rules = array(
			'comment' => 'required',
			'amount' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$autocomment = new ads_bid();
			$autocomment->comment = $data['comment'];
			$autocomment->amount = $data['amount'];
			$autocomment->model_id = $data['model_id'];
			$autocomment->model_name = $data['model_name'];
			$autocomment->user_id = Auth::user() ? Auth::user()->id : "";
			$autocomment->save();

			\Session::flash('success', $data['model_name'] . ' Bid Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}

}