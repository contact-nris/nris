<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Http\Controllers\Controller;
use App\State;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;

class CityController extends Controller {
	public function index() {

		//$data = session()->all();
		// print_R($data);
//echo Session::get('country_id');

		$data['lists'] = City::selectRaw('cities.*,states.name as states_name')->leftJoin('states', 'states.code', 'cities.state_code')->where('states.country_id', Session::get('country_id'))->orderBy('id', 'desc')->paginate();
		if (isset($_GET['test'])) {
			echo '<pre>';
			print_r($data['lists']);
			echo '</pre>';
		};
		return view('admin.city.index', $data);
	}

	public function getByState(Request $request) {
		$data['lists'] = City::where('state_code', $request->state_code)->orderby('name', 'asc')->get();
		return $data;
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();

		$data = Session::all();

		$data['states'] = State::where('country_id', $data['country_id'])->get();
		$data['city'] = City::findOrNew($id);

		return view('admin.city.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$state = City::findOrNew($id);
		$rules = array(
			'name' => 'required|min:3|max:120',
			'state_code' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$state->name = $data['name'];
			$state->state_code = $data['state_code'];
			$state->save();

			\Session::flash('success', 'State Data Saved Successfully.');
			$json['location'] = route('city.index');
		}

		return $json;
	}

	public function deleteItem(Request $request) {
		$data = $request->all();

		if (Hash::check($data['use_password'], Auth::user()->password)) {
			$state = City::findOrNew($data['del_val']);
			$state->remove();

			\Session::flash('success', 'City Deleted Successfully.');
			return redirect()->back();
		} else {
			\Session::flash('error', 'Enter Worng Password.');
			return redirect()->back();
		}
	}
}
