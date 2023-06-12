<?php

namespace App\Http\Controllers\Admin;

use App\BabySittingCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class BabySittingCategoryController extends Controller {
	public function index(Request $request) {
		$query = BabySittingCategory::selectRaw('baby_sitting_categories.*');
		if ($request->filter_name) {
			$query->where('baby_sitting_categories.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.baby_sitting_category.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['baby_sitting_category'] = BabySittingCategory::findOrNew($id);

		return view('admin.baby_sitting_category.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$baby_sitting_category = BabySittingCategory::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120}|unique:baby_sitting_categories,name',
			'color' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$baby_sitting_category->name = $data['name'];
			$baby_sitting_category->color = $data['color'];
			$baby_sitting_category->save();

			\Session::flash('success', 'Baby Sitting Data Saved Successfully.');
			$json['location'] = route('baby_sitting_category.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$baby_sitting_category = BabySittingCategory::findOrNew($id);
		$baby_sitting_category->remove();

		\Session::flash('success', 'Baby Sitting Deleted Successfully.');
		return redirect()->back();
	}
}
