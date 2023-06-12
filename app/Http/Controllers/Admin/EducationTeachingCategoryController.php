<?php

namespace App\Http\Controllers\Admin;

use App\EducationTeachingCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class EducationTeachingCategoryController extends Controller {
	public function index(Request $request) {
		$query = EducationTeachingCategory::selectRaw('education_teaching_categories.*');
		if ($request->filter_name) {
			$query->where('education_teaching_categories.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.education_teaching_category.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['education_teaching_category'] = EducationTeachingCategory::findOrNew($id);

		return view('admin.education_teaching_category.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$education_teaching_category = EducationTeachingCategory::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:education_teaching_categories,name',
			'color' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$education_teaching_category->name = $data['name'];
			$education_teaching_category->color = $data['color'];
			$education_teaching_category->save();

			\Session::flash('success', 'Education & Teaching Data Saved Successfully.');
			$json['location'] = route('education_teaching_category.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$education_teaching_category = EducationTeachingCategory::findOrNew($id);
		$education_teaching_category->remove();

		\Session::flash('success', 'Education & Teaching Deleted Successfully.');
		return redirect()->back();
	}
}
