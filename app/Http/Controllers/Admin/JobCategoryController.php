<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\JobCategory;
use Illuminate\Http\Request;
use Validator;

class JobCategoryController extends Controller {
	public function index(Request $request) {
		$query = JobCategory::selectRaw('job_categories.*');
		if ($request->filter_name) {
			$query->where('job_categories.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.job_category.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['job_category'] = JobCategory::findOrNew($id);

		return view('admin.job_category.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$job_category = JobCategory::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:job_categories,name',
			'color' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$job_category->name = $data['name'];

			$job_category->color = $data['color'];
			$job_category->save();

			\Session::flash('success', 'Job Category Data Saved Successfully.');
			$json['location'] = route('job_category.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$job_category = JobCategory::findOrNew($id);
		$job_category->remove();

		\Session::flash('success', 'Job Category Deleted Successfully.');
		return redirect()->back();
	}
}
