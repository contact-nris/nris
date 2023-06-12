<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MyPartnerCategory;
use Illuminate\Http\Request;
use Validator;

class MyPartnerCategoryController extends Controller {
	public function index(Request $request) {
		$query = MyPartnerCategory::selectRaw('mypartner_categories.*');
		if ($request->filter_name) {
			$query->where('mypartner_categories.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.my_partner.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['my_partner'] = MyPartnerCategory::findOrNew($id);

		return view('admin.my_partner.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$my_partner = MyPartnerCategory::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:mypartner_categories,name,' . $id,
			'color' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$my_partner->name = $data['name'];
			$my_partner->color = $data['color'];
			$my_partner->slug = slug($data['name']);
			$my_partner->save();

			\Session::flash('success', 'My Partner Category Data Saved Successfully.');
			$json['location'] = route('mypartner_category.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$my_partner = MyPartnerCategory::findOrNew($id);
		$my_partner->remove();

		\Session::flash('success', 'My Partner Category Deleted Successfully.');
		return redirect()->back();
	}
}
