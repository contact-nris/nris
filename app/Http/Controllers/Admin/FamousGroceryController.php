<?php

namespace App\Http\Controllers\Admin;

use App\Grocery;
use App\Http\Controllers\Controller;
use App\State;
use Illuminate\Http\Request;
use Validator;

class FamousGroceryController extends Controller {
	public function index(Request $request) {
		$query = Grocery::selectRaw('groceries.*,states.country_id, cities.name as city_name')
			->leftJoin('states', 'states.code', 'groceries.state_code')
			->leftJoin('cities', 'cities.id', 'groceries.city_id')
			->where('states.country_id', country_id());

		if ($request->state_code) {
			$query->where('groceries.state_code', $request->state_code);
		}

		if ($request->filter_name) {
			$query->where('groceries.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.famous.grocery.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['states'] = State::all();
		$data['grocery'] = Grocery::findOrNew($id);

		// echo "<pre>";
		// print_R($data['grocery']);
		// echo "</pre>";
		return view('admin.famous.grocery.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Grocery::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$grocery = Grocery::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120|unique:groceries,name',
			'state_code' => 'required',
			'address' => 'required',
			'contact' => 'required',
			'status' => 'required',
		);

		if ($request->email_id) {
			$rules['email_id'] = 'email';
		}

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = Grocery::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $grocery->name) {
					$grocery->name = $new_title;
					$grocery->url_slug = $this->clean($new_title);
				}} else {
				$grocery->name = $new_title;
				$grocery->url_slug = $this->clean($new_title);
			}
			$grocery->state_code = $request->state_code;
			$grocery->contact = $request->contact;
			$grocery->address = $request->address;
			$grocery->url = $request->url;
			$grocery->email_id = $request->email_id;
			$grocery->status = $request->status;
			$grocery->image = $grocery->image ? $grocery->image : $request->image;
			$grocery->other_details = $request->other_details;
			$grocery->meta_title = $request->meta_title;
			$grocery->meta_description = $request->meta_description;
			$grocery->meta_keywords = $request->meta_keywords;
			if ($request->hasFile('image')) {
				$grocery->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/groceries'), $grocery->image);
			}
			if (strlen($grocery->city_id) > 0) {
				$grocery->city_id = $request->city_id;
			}

			$grocery->save();
			\App\BusinessHour::sync($request->business_hours_type, $grocery->id, $request);

			\Session::flash('success', 'Grocery Data Saved Successfully.');
			$json['location'] = route('famous_grocery.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$temple = Grocery::findOrNew($id);
		$temple->remove();

		\Session::flash('success', 'Grocery Deleted Successfully.');
		return redirect()->back();
	}
}
