<?php

namespace App\Http\Controllers;

use App\MovieExternalRating;
use App\RatingSource;
use Illuminate\Http\Request;

class MovieReviewController extends Controller {
	public function index(Request $request) {

		$query = MovieExternalRating::selectRaw('*')->where(array('status' => 'Active'));

		if ($request->filter_name) {
			$query->where('movie_name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->orderby('created_at', 'DESC')->paginate(15);

		$data['rating_source'] = RatingSource::all()->keyBy('id');
		// 'meta_title' => $data['lists']->meta_title,
		//           'meta_description' => $data['lists']->meta_description,
		//           'meta_keywords' => $data['lists']->meta_keywords,
		$data['meta_tags'] = array(

			'title' => 'MovieExternalRating',
			'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our MovieExternalRating and stay updated with the latest posts.',
			'twitter_title' => 'MovieExternalRating',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.moviereview.list', $data);
	}
}
