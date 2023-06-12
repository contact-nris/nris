<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\RoomMateCategory;
use Illuminate\Http\Request;
use Validator;

class RoomMateCategoryController extends Controller {
	public function index() {
		$data['lists'] = RoomMateCategory::paginate();
		return view('admin.room_mate_category.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['category'] = RoomMateCategory::findOrNew($id);

		return view('admin.room_mate_category.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$category = RoomMateCategory::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:room_mate_categoires,name',
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

			\Session::flash('success', 'Room Mates Category Data Saved Successfully.');
			$json['location'] = route('room_mate_category.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$category = RoomMateCategory::findOrNew($id);
		$category->remove();

		\Session::flash('success', 'Room Mates Category Deleted Successfully.');
		return redirect()->back();
	}
}
