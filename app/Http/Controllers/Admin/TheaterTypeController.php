<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\TheaterType;
use Illuminate\Http\Request;
use Validator;

class TheaterTypeController extends Controller {
	public function index(Request $request) {
		$query = TheaterType::selectRaw('theaters_type.*');
		if ($request->filter_name) {
			$query->where('theaters_type.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.theaters_type.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['theaters_type'] = TheaterType::findOrNew($id);

		return view('admin.theaters_type.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$theaters_type = TheaterType::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:theaters_type,name',
			'color' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$theaters_type->name = $data['name'];
			$theaters_type->color = $data['color'];
			$theaters_type->save();

			\Session::flash('success', 'Theaters Type Data Saved Successfully.');
			$json['location'] = route('theaters_type.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$theaters_type = TheaterType::findOrNew($id);
		$theaters_type->remove();

		\Session::flash('success', 'Theaters Type Deleted Successfully.');
		return redirect()->back();
	}
}
