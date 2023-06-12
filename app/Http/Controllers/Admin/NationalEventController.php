<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\NationalEvent;
use Illuminate\Http\Request;
use Validator;

class NationalEventController extends Controller {
	public function index(Request $request) {
		$query = NationalEvent::selectRaw('national_events.*,events_category.name as category_name')
			->leftJoin('events_category', 'events_category.id', 'national_events.category')
			->where('national_events.country', country_id());

		$data['lists'] = $query->orderBy('id', 'DESC')->paginate();
		return view('admin.national_events.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['event'] = NationalEvent::findOrNew($id);
		return view('admin.national_events.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = NationalEvent::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$event = NationalEvent::findOrNew($id);
		$rules = array(
			'title' => 'required|max:120',
			'address' => 'required',
			'details' => 'required',
			'status' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = NationalEvent::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $event->title) {
					$event->title = $new_title;
					$event->url_slug = $this->clean($new_title);
				}} else {
				$event->title = $new_title;
				$event->url_slug = $this->clean($new_title);
			}

			$event->category = (int) $request->category;
			$event->details = $request->details;
			$event->address = $request->address;
			$event->url = $request->url;
			$event->sdate = date("Y-m-d", strtotime($request->sdate));
			$event->edate = date("Y-m-d", strtotime($request->edate));
			$event->status = (int) $request->status;
			$event->meta_title = $request->meta_title;
			$event->meta_description = $request->meta_description;
			$event->meta_keywords = $request->meta_keywords;

			if ($request->hasFile('image')) {
				$event->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/national_events'), $event->image);
			}

			if ((int) $event->id == 0) {
				$event->country = country_id();
			}

			$event->save();

			\Session::flash('success', 'National Event Data Saved Successfully.');
			$json['location'] = route('national_events.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$event = NationalEvent::findOrNew($id);
		$event->remove();

		\Session::flash('success', 'National Event Deleted Successfully.');
		return redirect()->back();
	}
}
