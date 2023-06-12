<?php

namespace App\Http\Controllers;

class ContactUsController extends Controller {

	public function index() {
		$data = [];
		return view('front.contactus', $data);
	}

}
