<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller {
	public function index(Request $request) {
		$query = User::selectRaw('users.*');

		if ($request->filter_name) {
			$query->whereRaw('(CONCAT(first_name, " ", last_name) like "%' . $request->filter_name . '%") ');
		}

		if ($request->filter_email) {
			$query->where('email', 'like', '%' . $request->filter_email . '%');
		}

		if ($request->mailinit == 'true') {
			$data['total_user'] = $query->count();
			$data['html'] = view('admin.user.mail', $data)->render();

			return $data;
		}

		if ($request->mailsubmit == 'true') {
			$data['total_user'] = $query->get();
			$emails = array('jaydeepakbari@gmail.com');
			\App\Mails::send(array(
				'to' => $emails,
				'subject' => $request->subject,
				'content' => $request->content,
			));

			$data['success_message'] = 'Mail sent Successfully';

			return $data;
		}

		$data['lists'] = $query->paginate();
		return view('admin.user.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['user'] = User::findOrNew($id);

		return view('admin.user.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$user = User::findOrNew($id);

		$rules = array(
			'first_name' => 'required|max:120',
			'last_name' => 'required|max:120',
			'email' => 'required|email|unique:users',
			'dob' => 'required',
			'state' => 'required',
			'city' => 'required',
		);

		if ((int) $user->id == 0 || $request->password) {
			$rules['password'] = 'required|min:6';
		}
		if ((int) $user->id > 0) {
			$rules['email'] = 'required|email|unique:users,email,' . $user->id;
		}

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			$user->email = $request->email;
			$user->dob = $request->dob;
			$user->mobile = $request->mobile;
			$user->address = $request->address;
			$user->state = $request->state;
			$user->city = $request->city;

			if ($request->password) {
				$user->password = Hash::make($request->password);
			}
			$user->save();

			\Session::flash('success', 'User Data Saved Successfully.');
			$json['location'] = route('user.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$user = User::findOrNew($id);
		$user->delete();

		\Session::flash('success', 'User Deleted Successfully.');
		return redirect()->back();
	}

	public function userDetailsAutocomplete(Request $request) {
		$query = User::selectRaw('users.*,states.country_id');
		$query->leftJoin('states', 'states.code', '=', 'users.state');
		$query->whereRaw('(CONCAT(first_name, " ", last_name) like "%' . $request->term . '%") ')->limit(10);

		$data = $query->get();
		$json = array();
		foreach ($data as $value) {
			$json[] = array(
				'id' => $value->id,
				'label' => $value->first_name . ' ' . $value->last_name,
				'value' => $value->first_name,
				'fname' => $value->first_name,
				'lname' => $value->last_name,
				'email' => $value->email,
				'mobile' => $value->mobile,
				'dob' => $value->dob,
				'address' => $value->address,
				'country' => $value->country_id,
				'city' => $value->city,
			);
		}

		return response()->json($json);
	}
}