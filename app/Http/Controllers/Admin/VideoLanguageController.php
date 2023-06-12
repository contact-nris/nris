<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\VideoLanguage;
use Illuminate\Http\Request;
use Validator;

class VideoLanguageController extends Controller {
	public function index() {
		$data['lists'] = VideoLanguage::paginate();
		return view('admin.video.language.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['language'] = VideoLanguage::findOrNew($id);

		return view('admin.video.language.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$language = VideoLanguage::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:videos_languages,name',
			'slug' => 'required|min:2|max:120|unique:videos_languages,name',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$language->name = $data['name'];

			$language->slug = $data['slug'];
			$language->save();

			\Session::flash('success', 'Language Data Saved Successfully.');
			$json['location'] = route('video_language.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$language = VideoLanguage::findOrNew($id);
		$language->remove();

		\Session::flash('success', 'Language Deleted Successfully.');
		return redirect()->back();
	}
}
