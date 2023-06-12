<?php

namespace App\Http\Controllers\Admin;

use App\AutoMake;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AutoMakeController extends Controller {
	public function index(Request $request) {
		$query = AutoMake::selectRaw('auto_makes.*');

		if ($request->filter_name) {
			$query->where('auto_makes.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.automake.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['automake'] = AutoMake::findOrNew($id);

		return view('admin.automake.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$automake = AutoMake::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
			'color' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$automake->name = $data['name'];
			$automake->color = $data['color'];
			$automake->save();

			\Session::flash('success', 'Auto Make Data Saved Successfully.');
			$json['location'] = route('automake.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$automake = AutoMake::findOrNew($id);
		$automake->remove();

		\Session::flash('success', 'Auto Make Deleted Successfully.');
		return redirect()->back();
	}
}
