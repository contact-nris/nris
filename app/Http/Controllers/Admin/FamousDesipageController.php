<?php

namespace App\Http\Controllers\Admin;

use App\Desipage;
use App\Desipage_type;
use App\Http\Controllers\Controller;
use App\State;
use Illuminate\Http\Request;
use Validator;

class FamousDesipageController extends Controller {
	public function index(Request $request) {
		$query = Desipage::selectRaw('desi_pages.*,states.country_id, cities.name as city_id,desi_pages_cat.name as type')
			->leftJoin('states', 'states.code', 'desi_pages.state_code')
			->leftJoin('cities', 'cities.id', 'desi_pages.city_id')
			->leftJoin('desi_pages_cat', 'desi_pages_cat.id', 'desi_pages.category_name')
			->where('states.country_id', country_id());

		if ($request->state_code) {
			$query->where('desi_pages.state_code', $request->state_code);
		}

		if ($request->filter_name) {
			$query->where('desi_pages.title', 'like', '%' . $request->filter_name . '%');
		}
		$query->orderBy('id', 'DESC');
		$data['lists'] = $query->paginate();

		return view('admin.famous.desipage.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['states'] = State::all();
		$data['types'] = Desipage_type::all();
		$data['desipage'] = Desipage::findOrNew($id);

		return view('admin.famous.desipage.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Desipage::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$desipage = Desipage::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
			'state_code' => 'required',
			'desipage_type' => 'required',
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
			$matchingRecords = Desipage::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $desipage->title) {
					$desipage->title = $new_title;
					$desipage->url_slug = $this->clean($new_title);
				}} else {
				$desipage->title = $new_title;
				$desipage->url_slug = $this->clean($new_title);
			}
			$desipage->state_code = $request->state_code;
			$desipage->city_id = (int) $request->city_id;
			$desipage->category_name = $request->desipage_type;
			$desipage->contact = $request->contact;
			$desipage->address = $request->address;
			$desipage->url = $request->url;
			$desipage->email = $request->email_id;
			$desipage->status = $request->status;
			$desipage->image = $request->image;
			$desipage->other_details = $request->other_details;

			$desipage->meta_title = $request->meta_title;
			$desipage->meta_description = $request->meta_description;
			$desipage->meta_keywords = $request->meta_keywords;

			if ($request->hasFile('image')) {
				$desipage->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/mypartner'), $desipage->image);
			}

			$desipage->save();

			\App\BusinessHour::sync($request->business_hours_type, $desipage->id, $request);
			\Session::flash('success', 'Desidate Data Saved Successfully.');
			$json['location'] = route('famous_desipage.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$desipage = Desipage_type::findOrNew($id);
		$desipage->remove();

		\Session::flash('success', 'Desidate Deleted Successfully.');
		return redirect()->back();
	}
}
