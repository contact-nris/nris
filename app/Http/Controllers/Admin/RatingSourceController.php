<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\RatingSource;
use Illuminate\Http\Request;
use Validator;

class RatingSourceController extends Controller {
	public function index() {
		$data['lists'] = RatingSource::paginate();
		return view('admin.movierating.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['rating'] = RatingSource::findOrNew($id);

		return view('admin.movierating.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$rating = RatingSource::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$rating->source_name = $data['name'];
			$rating->status = (int) $request->status;
			$rating->save();

			\Session::flash('success', 'Rating Source Data Saved Successfully.');
			$json['location'] = route('ratingsource.form');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$rating = RatingSource::findOrNew($id);
		$rating->remove();

		\Session::flash('success', 'Rating Source Deleted Successfully.');
		return redirect()->back();
	}
}
