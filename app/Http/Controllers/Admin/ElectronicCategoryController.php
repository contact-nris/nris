<?php

namespace App\Http\Controllers\Admin;

use App\ElectronicCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ElectronicCategoryController extends Controller {
	public function index() {
		$data['lists'] = ElectronicCategory::paginate();
		return view('admin.electronic_category.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['category'] = ElectronicCategory::findOrNew($id);

		return view('admin.electronic_category.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$category = ElectronicCategory::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:electronic_categories,name',
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

			\Session::flash('success', 'Electronic Category Data Saved Successfully.');
			$json['location'] = route('electronic_category.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$category = ElectronicCategory::findOrNew($id);
		$category->remove();

		\Session::flash('success', 'Electronic Category Deleted Successfully.');
		return redirect()->back();
	}
}
