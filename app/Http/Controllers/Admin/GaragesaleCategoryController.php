<?php

namespace App\Http\Controllers\Admin;

use App\GaragesaleCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class GaragesaleCategoryController extends Controller {
	public function index() {
		$data['lists'] = GaragesaleCategory::paginate();
		return view('admin.garagesale_category.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['category'] = GaragesaleCategory::findOrNew($id);

		return view('admin.garagesale_category.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$category = GaragesaleCategory::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:garagesale_categoires,name',
			'color' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$category->name = $data['name'];
			$category->color = $data['color'];
			$category->save();

			\Session::flash('success', 'Garagesale Category Data Saved Successfully.');
			$json['location'] = route('garagesale_category.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$category = GaragesaleCategory::findOrNew($id);
		$category->remove();

		\Session::flash('success', 'Garagesale Category Deleted Successfully.');
		return redirect()->back();
	}
}
