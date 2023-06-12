<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\State;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class StateController extends Controller {
	public function index(Request $request) {
		$query = State::selectRaw('states.*, countries.name as country_name')->leftJoin('countries', 'countries.id', 'states.country_id');

		$query->where('states.country_id', country_id());

		if ($request->filter_name) {
			$query->where('states.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->orderby('id', 'desc')->paginate();

		// print_R( $data['lists']);
		// exit;

		return view('admin.state.index', $data);
	}

	public function getByCountry(Request $request) {
		$data['lists'] = State::where('country_id', (int) $request->country_id)->get();
		return $data;
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		// $data['country'] = Country::all();
		$data['state'] = State::findOrNew($id);

// print_R( $data['state']);
		return view('admin.state.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$state = State::findOrNew($id);
		$rules = array(
			'name' => 'required|min:3|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$state->name = $data['name'];

			$state->domain = $data['state_domain'];
			$state->code = $data['state_code'];
			$state->country_id = country_id();
			$state->description = $data['description'];
			$state->s_meta_title = $request->meta_title;
			$state->s_meta_description = $request->meta_description;
			$state->s_meta_keywords = $request->meta_keywords;

			if ($request->hasFile('logo')) {
				$state->logo = uniqname() . '.' . $request->file('logo')->guessExtension();
				$request->file('logo')->move(public_path('upload/state'), $state->logo);
			}

			if ($request->hasFile('header_image')) {
				$state->header_image = uniqname() . '.' . $request->file('header_image')->guessExtension();
				$request->file('header_image')->move(public_path('upload/state'), $state->header_image);
			}

			if ($request->hasFile('header_image2')) {
				$state->header_image2 = uniqname() . '.' . $request->file('header_image2')->guessExtension();
				$request->file('header_image2')->move(public_path('upload/state'), $state->header_image2);
			}

			if ($request->hasFile('header_image3')) {
				$state->header_image3 = uniqname() . '.' . $request->file('header_image3')->guessExtension();
				$request->file('header_image3')->move(public_path('upload/state'), $state->header_image3);
			}

			$state->save();

			\Session::flash('success', 'State Data Saved Successfully.');
			$json['location'] = route('state.index');
		}

		return $json;
	}

	public function deleteItem(Request $request) {
		$data = $request->all();
		if (Hash::check($data['use_password'], Auth::user()->password)) {
			$state = State::findOrNew($data['del_val']);
			$state->remove();

			\Session::flash('success', 'State Deleted Successfully.');
			return redirect()->back();

		} else {

			\Session::flash('error', 'Enter Worng Password.');
			return redirect()->back();

		}

	}
}
