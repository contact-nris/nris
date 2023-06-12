<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class AdminUserController extends Controller {
	public function index() {
		$data['lists'] = Admin::paginate();
		return view('admin.admin.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['admin'] = Admin::findOrNew($id);

		return view('admin.admin.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$admin = Admin::findOrNew($id);

		$rules = array(
			'name' => 'required|max:120',
			'email' => 'required|email|unique:admins',
			'role' => 'required',
			'username' => 'required|unique:admins,username',
		);

		if ((int) $admin->id == 0 || $request->password) {
			$rules['password'] = 'required|min:6';
		}
		if ((int) $admin->id > 0) {
			$rules['email'] = 'required|email|unique:admins,email,' . $admin->id;
			$rules['username'] = 'required|unique:admins,username,' . $admin->id;
		}

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$admin->name = $request->name;
			$admin->username = $request->username;
			$admin->email = $request->email;
			$admin->role = $request->role;
			$admin->contact_no = $request->contact_no;

			if ($request->password) {
				$admin->password = Hash::make($request->password);
			}
			$admin->save();

			\Session::flash('success', 'Admin Data Saved Successfully.');
			$json['location'] = route('admin.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$admin = Admin::findOrNew($id);
		$admin->delete();

		\Session::flash('success', 'Admin Deleted Successfully.');
		return redirect()->back();
	}
}
