<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MovieExternalRating;
use App\RatingSource;
use Illuminate\Http\Request;
use Validator;

class MovieExternalRatingController extends Controller {
	public function index() {
		$data['lists'] = MovieExternalRating::orderBy('id', 'desc')->paginate();
		return view('admin.movies_external_rating.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['rating'] = MovieExternalRating::findOrNew($id);
		$data['rating']['rating_data'] = is_array($data['rating']->rating_data) ? $data['rating']->rating_data : array();

		$data['sources'] = RatingSource::all();

		return view('admin.movies_external_rating.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();

		$rating = MovieExternalRating::findOrNew($id);
		$rules = array(
			'movie_name' => 'required|min:2|max:120',
			'status' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$rating->movie_name = $data['movie_name'];
			$rating->status = $request->status;
			$rating->rating_data = $request->rating_data;
			$rating->save();

			\Session::flash('success', 'Movie External Rating Data Saved Successfully.');
			$json['location'] = route('movies_external_rating.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$rating = MovieExternalRating::findOrNew($id);
		$rating->remove();

		\Session::flash('success', 'Movie External Rating Deleted Successfully.');
		return redirect()->back();
	}
}
