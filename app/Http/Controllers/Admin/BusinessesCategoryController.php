<?php

namespace App\Http\Controllers\Admin;

use App\BusinessesCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class BusinessesCategoryController extends Controller {
	public function index() {
		$data['lists'] = BusinessesCategory::orderBy('id', 'desc')->paginate();
		return view('admin.businesses.category.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['category'] = BusinessesCategory::findOrNew($id);

		return view('admin.businesses.category.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$category = BusinessesCategory::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:participating_businesses_category,name',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$category->cat_name = $data['name'];
			$category->save();

			\Session::flash('success', 'Category Data Saved Successfully.');
			$json['location'] = route('businessess_category.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$category = BusinessesCategory::findOrNew($id);
		$category->remove();

		\Session::flash('success', 'Category Deleted Successfully.');
		return redirect()->back();
	}
}
