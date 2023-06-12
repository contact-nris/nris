<?php

namespace App\Http\Controllers;

class DisclaimerController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$data = array();
		$data['meta_tags'] = array(
			'title' => 'Disclaimer',
			'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Disclaimer and stay updated with the latest posts.',
			'twitter_title' => 'Disclaimer',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);
		return view('front.disclaimer', $data);
	}

}
