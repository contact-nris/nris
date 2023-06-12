<?php

namespace App\Http\Controllers\Admin;

use App\Businesses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class BusinessesController extends Controller {
	public function index() {
		$data['lists'] = Businesses::selectRaw('participating_businesses.*,
            cities.name as city_name,
            states.name as state_name,
            participating_businesses_category.cat_name as category_name')
			->leftJoin('cities', 'cities.id', 'participating_businesses.city')
			->leftJoin('states', 'states.code', 'participating_businesses.state_code')
			->leftJoin('participating_businesses_category', 'participating_businesses_category.id', 'participating_businesses.category_id')
			->orderBy('id', 'desc')
			->paginate();

		return view('admin.businesses.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['busi'] = Businesses::findOrNew($id);
		return view('admin.businesses.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Businesses::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$busi = Businesses::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
			'state_code' => 'required',
			'city_id' => 'required',
			'category_id' => 'required',
			'address' => 'required',
			'description' => 'required|min:2|max:120',
			'email_id' => 'required',
			'status' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = Businesses::where('url_slug', trim($this->clean($request->name)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->name);
			} else {
				$new_title = $request->name;
			}

			if ($id > 0) {
				if (trim($request->name) != $busi->name) {
					$busi->name = $new_title;
					$busi->url_slug = $this->clean($new_title);
				}} else {
				$busi->name = $new_title;
				$busi->url_slug = $this->clean($new_title);
			}
			$busi->state_code = $request->state_code;
			$busi->description = $request->description;
			$busi->category_id = $request->category_id;
			$busi->city = $request->city_id;
			$busi->url = $request->url;
			$busi->address = $request->address;
			$busi->email = $request->email_id;
			$busi->offers = $request->offers;
			$busi->phone = $request->contact;
			$busi->image = $request->image;
			$busi->status = (int) $request->status;

			if ($request->hasFile('image')) {
				$busi->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/participating_businesses'), $busi->image);
			}

			$busi->save();

			\Session::flash('success', 'Businesses Data Saved Successfully.');
			$json['location'] = route('businesses.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$busi = Businesses::findOrNew($id);
		$busi->remove();

		\Session::flash('success', 'Businesses Deleted Successfully.');
		return redirect()->back();
	}
}
