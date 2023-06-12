<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\EventCategory;
use App\Http\Controllers\Controller;
use App\State;
use Illuminate\Http\Request;
use Validator;

class FamousEventController extends Controller {
	public function index(Request $request) {
		$query = Event::selectRaw('events.*,states.country_id, cities.name as city_id, events_category.name as event_name')
			->leftJoin('states', 'states.code', 'events.state_code')
			->leftJoin('cities', 'cities.id', 'events.city_id')
			->leftJoin('events_category', 'events_category.id', 'events.category')
			->where('states.country_id', country_id());

		if ($request->state_code) {
			$query->where('events.state_code', $request->state_code);
		}

		if ($request->filter_name) {
			$query->where('events.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.famous.event.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['states'] = State::all();
		$data['types'] = EventCategory::all();
		$data['event'] = Event::findOrNew($id);

		return view('admin.famous.event.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Event::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$event = Event::findOrNew($id);
		$rules = array(
			'title' => 'required|min:5|max:120',
			'state_code' => 'required',
			'address' => 'required',
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
			$matchingRecords = Event::where('url_slug', trim($this->clean($request->title)))->get();
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
			$event->state_code = $request->state_code;
			$event->city_id = (int) $request->city_id;
			$event->address = $request->address;
			$event->category = $request->event_category;
			$event->sdate = date("Y-m-d", strtotime($request->sdate));
			$event->edate = date("Y-m-d", strtotime($request->edate));
			$event->url = $request->url;
			$event->email_id = $request->email_id;
			$event->status = $request->status;
			$event->image = $event->image ? $event->image : $request->image;
			$event->other_details = $request->other_details;
			$event->meta_title = $request->meta_title;
			$event->meta_description = $request->meta_description;
			$event->meta_keywords = $request->meta_keywords;
			if ($request->hasFile('image')) {
				$event->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/events'), $event->image);
			}

			$event->save();
			\App\BusinessHour::sync($request->business_hours_type, $event->id, $request);
			\Session::flash('success', 'events Data Saved Successfully.');
			$json['location'] = route('famous_event.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$event = Event::findOrNew($id);
		$event->remove();

		\Session::flash('success', 'events Deleted Successfully.');
		return redirect()->back();
	}
}
