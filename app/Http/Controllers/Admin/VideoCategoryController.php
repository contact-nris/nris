<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\VideoCategory;
use Illuminate\Http\Request;
use Validator;

class VideoCategoryController extends Controller {
	public function index() {
		$data['lists'] = VideoCategory::paginate();
		return view('admin.video.category.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['category'] = VideoCategory::findOrNew($id);

		return view('admin.video.category.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$category = VideoCategory::findOrNew($id);
		$rules = array(
			'category_name' => 'required|min:2|max:120|unique:videos_categoires,category_name',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$category->category_name = $data['category_name'];
			$category->image_name = $request->image;

			if ($request->hasFile('image')) {
				$category->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/video'), $category->image);
			}

			$category->save();

			\Session::flash('success', 'Category Data Saved Successfully.');
			$json['location'] = route('video_category.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$category = VideoCategory::findOrNew($id);
		$category->remove();

		\Session::flash('success', 'Category Deleted Successfully.');
		return redirect()->back();
	}
}
