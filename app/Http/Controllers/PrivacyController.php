<?php

namespace App\Http\Controllers;

class PrivacyController extends Controller {

	public function index() {
		$data = array();
		$data['meta_tags'] = array(
			'title' => 'Privacy Policy',
			'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our TermsCondition and stay updated with the latest posts.',
			'twitter_title' => 'Privacy Policy',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.privacy', $data);
	}

}
