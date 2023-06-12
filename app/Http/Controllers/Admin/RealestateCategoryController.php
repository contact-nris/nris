<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\RealestateCategory;
use Illuminate\Http\Request;
use Validator;

class RealestateCategoryController extends Controller {
	public function index() {
		$data['lists'] = RealestateCategory::paginate();
		return view('admin.realestate_category.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['category'] = RealestateCategory::findOrNew($id);

		return view('admin.realestate_category.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$category = RealestateCategory::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:realestate_categoires,name',
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

			\Session::flash('success', 'Realestate Category Data Saved Successfully.');
			$json['location'] = route('realestate_category.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$category = RealestateCategory::findOrNew($id);
		$category->remove();

		\Session::flash('success', 'Realestate Category Deleted Successfully.');
		return redirect()->back();
	}
}
