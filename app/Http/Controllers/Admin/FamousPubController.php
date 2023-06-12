<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pub;
use App\PubType;
use App\State;
use Illuminate\Http\Request;
use Validator;

class FamousPubController extends Controller {
	public function index(Request $request) {
		$query = Pub::selectRaw('pubs.*,states.country_id, cities.name as city_id, pubs_type.type as pubs_type_name')
			->leftJoin('states', 'states.code', 'pubs.state_code')
			->leftJoin('cities', 'cities.id', 'pubs.city_id')
			->leftJoin('pubs_type', 'pubs_type.id', 'pubs.pub_type')
			->where('states.country_id', country_id());

		if ($request->state_code) {
			$query->where('pubs.state_code', $request->state_code);
		}

		if ($request->filter_name) {
			$query->where('pubs.pub_name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.famous.pub.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['states'] = State::all();
		$data['types'] = PubType::all();
		$data['pub'] = Pub::findOrNew($id);

		return view('admin.famous.pub.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Pub::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$pub = Pub::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
			'state_code' => 'required',
			'pub_type' => 'required',
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
			$matchingRecords = Pub::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->name) != $pub->pub_name) {
					$pub->pub_name = $new_title;
					$pub->url_slug = $this->clean($new_title);
				}} else {
				$pub->pub_name = $new_title;
				$pub->url_slug = $this->clean($new_title);
			}
			$pub->state_code = $request->state_code;
			$pub->city_id = (int) $request->city_id;
			$pub->pub_type = $request->pub_type;
			$pub->contact = $request->contact;
			$pub->address = $request->address;
			$pub->url = $request->url;
			$pub->email_id = $request->email_id;
			$pub->status = $request->status;
			$pub->image = $pub->image ? $pub->image : $request->image;
			$pub->other_details = $request->other_details;
			$pub->meta_title = $request->meta_title;
			$pub->meta_description = $request->meta_description;
			$pub->meta_keywords = $request->meta_keywords;

			if ($request->hasFile('image')) {
				$pub->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/pubs'), $pub->image);
			}

			$pub->save();
			\App\BusinessHour::sync($request->business_hours_type, $pub->id, $request);

			\Session::flash('success', 'pub Data Saved Successfully.');
			$json['location'] = route('famous_pubs.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$pub = Pub::findOrNew($id);
		$pub->remove();

		\Session::flash('success', 'pub Deleted Successfully.');
		return redirect()->back();
	}
}
