<?php

namespace App\Http\Controllers;
use App\Country;
use Illuminate\Http\Request;

class CommonController extends Controller {

	public function setCountry(Request $request) {
		$json = array();
		$country = Country::where('code', $request->country)->first();

		if ($country) {
			\Session::put('country', $country);
			\Session::put('country_code', $country->code);
			\Session::put('country_set_id', base64_encode($country->id));
		}

		$json['reload'] = true;
		return $json;
	}

}
