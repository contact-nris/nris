<?php

namespace App\Http\Controllers\Admin;

use App\Citymovie;
use App\Http\Controllers\Controller;
use App\State;
use Illuminate\Http\Request;
use Validator;

class FamousCitymovieController extends Controller {
	public function index(Request $request) {
		$query = Citymovie::selectRaw('city_movies.*,states.country_id, cities.name as city_id')
			->leftJoin('states', 'states.code', 'city_movies.state_code')
			->leftJoin('cities', 'cities.id', 'city_movies.city_id')
			->where('states.country_id', country_id());

		if ($request->state_code) {
			$query->where('city_movies.state_code', $request->state_code);
		}

		if ($request->filter_name) {
			$query->where('city_movies.name', 'like', '%' . $request->filter_name . '%');
		}
		$query->orderBy('id', 'DESC');

		$data['lists'] = $query->paginate();

		return view('admin.famous.citymovie.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['states'] = State::all();
		$data['citymovie'] = Citymovie::findOrNew($id);

		return view('admin.famous.citymovie.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Citymovie::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$citymovie = Citymovie::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
			'state_code' => 'required',
			'address' => 'required',
			'url' => 'required',
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
			$matchingRecords = Citymovie::where('url_slug', trim($this->clean($request->name)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->name);
			} else {
				$new_title = $request->name;
			}

			if ($id > 0) {
				if (trim($request->name) != $citymovie->name) {
					$citymovie->name = $new_title;
					$citymovie->url_slug = $this->clean($new_title);
				}} else {
				$citymovie->name = $new_title;
				$citymovie->url_slug = $this->clean($new_title);
			}
			$citymovie->state_code = $request->state_code;
			$citymovie->description = $request->description;
			$citymovie->city_id = (int) $request->city_id;
			$citymovie->address = $request->address;
			$citymovie->sdate = date("Y-m-d", strtotime($request->sdate));
			$citymovie->edate = date("Y-m-d", strtotime($request->edate));
			//$citymovie->url = $request->url;

			if (strlen($request->url) > 0) {
				$citymovie->url = $data['url'];
			}
			$citymovie->status = $request->status;
			$citymovie->image = $request->image;
			$citymovie->additional_info = $request->other_details;

			$citymovie->meta_title = $request->meta_title;
			$citymovie->meta_description = $request->meta_description;
			$citymovie->meta_keywords = $request->meta_keywords;

			if ($request->hasFile('image')) {
				$citymovie->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/city_movies'), $citymovie->image);
			}

			$citymovie->save();
			\App\BusinessHour::sync($request->business_hours_type, $citymovie->id, $request);
			\Session::flash('success', 'Citymovies Data Saved Successfully.');
			$json['location'] = route('famous_citymovie.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$citymovie = Citymovie::findOrNew($id);
		$citymovie->remove();

		\Session::flash('success', 'Citymovies Deleted Successfully.');
		return redirect()->back();
	}
}
