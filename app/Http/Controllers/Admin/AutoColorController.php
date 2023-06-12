<?php

namespace App\Http\Controllers\Admin;

use App\AutoColor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AutoColorController extends Controller {
	public function index(Request $request) {
		$query = AutoColor::selectRaw('auto_colors.*');
		if ($request->filter_name) {
			$query->where('auto_colors.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.autocolor.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['autocolor'] = AutoColor::findOrNew($id);

		return view('admin.autocolor.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$autocolor = AutoColor::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:autocolor,name',
			'code' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$autocolor->name = $data['name'];
			$autocolor->code = $data['code'];
			$autocolor->save();

			\Session::flash('success', 'Auto Color Data Saved Successfully.');
			$json['location'] = route('autocolor.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$autocolor = AutoColor::findOrNew($id);
		$autocolor->remove();

		\Session::flash('success', 'Auto Color Deleted Successfully.');
		return redirect()->back();
	}
}
