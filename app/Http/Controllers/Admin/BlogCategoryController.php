<?php

namespace App\Http\Controllers\Admin;

use App\BlogCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class BlogCategoryController extends Controller {
	public function index() {
		$data['lists'] = BlogCategory::paginate();
		return view('admin.blog.category.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['category'] = BlogCategory::findOrNew($id);

		return view('admin.blog.category.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$category = BlogCategory::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$category->name = $data['name'];
			$category->save();

			\Session::flash('success', 'Category Data Saved Successfully.');
			$json['location'] = route('blog_category.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$category = BlogCategory::findOrNew($id);
		$category->remove();

		\Session::flash('success', 'Category Deleted Successfully.');
		return redirect()->back();
	}
}
