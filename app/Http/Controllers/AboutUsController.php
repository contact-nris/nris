<?php

namespace App\Http\Controllers;

class AboutUsController extends Controller {

	public function index() {
		$data = array();

		return view('front.aboutus', $data);
	}

}
