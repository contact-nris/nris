<?php

namespace App\Http\Controllers;

class TermsConditionController extends Controller {

	public function index() {
		$data = array();
		$data['meta_tags'] = array(
			// 'meta_title' => $data['blog']->meta_title,
			// 'meta_description' => $data['blog']->meta_description,
			// 'meta_keywords' => $data['blog']->meta_keywords,
			'title' => 'TermsCondition',
			'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our TermsCondition and stay updated with the latest posts.',
			'twitter_title' => 'TermsCondition',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.termscondition', $data);
	}

}
