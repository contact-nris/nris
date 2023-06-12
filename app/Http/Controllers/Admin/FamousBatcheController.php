<?php

namespace App\Http\Controllers\Admin;

use App\BatchCategory;
use App\Batche;
use App\Http\Controllers\Controller;
use App\State;
use Illuminate\Http\Request;
use Validator;

class FamousBatcheController extends Controller {
	public function index(Request $request) {
		$query = Batche::selectRaw('batches.*,states.country_id, batches_categories.name as batches_categories')
			->leftJoin('states', 'states.code', 'batches.state_code')
			->leftJoin('batches_categories', 'batches_categories.id', 'batches.category')
			->where('states.country_id', country_id());

		if ($request->state_code) {
			$query->where('batches.state_code', $request->state_code);
		}

		if ($request->filter_name) {
			$query->where('batches.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.famous.batche.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['states'] = State::all();
		$data['types'] = BatchCategory::all();
		$data['batche'] = Batche::findOrNew($id);

		return view('admin.famous.batche.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Batche::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$batche = Batche::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
			// 'state_code' => 'required',
			'batche_type' => 'required',
			'details' => 'required',
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
			$matchingRecords = Batche::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $batche->title) {
					$batche->title = $new_title;
					$batche->url_slug = $this->clean($new_title);
				}} else {
				$batche->title = $new_title;
				$batche->url_slug = $this->clean($new_title);
			}
			$batche->url_slug = $this->clean($data['name']);

			// $batche->state_code = $request->state_code;
			$batche->category = $request->batche_type;
			$batche->details = $request->details;
			$batche->expdate = date("Y-m-d", strtotime($request->sdate));
			$batche->email_id = $request->email_id;
			$batche->status = $request->status;
			$batche->image = $batche->image ? $batche->image : $request->image;
			$batche->other_details = $request->other_details;

			$batche->meta_title = $request->meta_title;
			$batche->meta_description = $request->meta_description;
			$batche->meta_keywords = $request->meta_keywords;

			if ($request->hasFile('image')) {
				$batche->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/batches'), $batche->image);
			}

			$batche->save();
			\App\BusinessHour::sync($request->business_hours_type, $batche->id, $request);
			\Session::flash('success', 'Batche Data Saved Successfully.');
			$json['location'] = route('famous_batche.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$batche = Batche::findOrNew($id);
		$batche->remove();

		\Session::flash('success', 'Batche Deleted Successfully.');
		return redirect()->back();
	}
}
