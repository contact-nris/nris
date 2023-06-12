<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\RoomMate;
use Illuminate\Http\Request;
use Validator;

class RoomMateController extends Controller {
	public function index(Request $request) {
		$query = RoomMate::selectRaw('
            post_free_roommates.*,
            room_mate_categoires.name as category_name
        ')
			->leftJoin('room_mate_categoires', 'room_mate_categoires.id', 'post_free_roommates.category')
			->orderBy('post_free_roommates.id', 'DESC')
			->where('post_free_roommates.country', country_id());

		if ($request->filter_name) {
			$query->where('post_free_roommates.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.room_mate_classified.index', $data);
	}

	public function changeType(Request $request) {
		$json = array();

		$room = RoomMate::find((int) $request->id);
		if ($room) {
			if ($request->name == 'display_status') {
				$room->display_status = !$room->display_status;
				$current_d_status = $room->display_status;

				$json['success'] = $current_d_status;
				$json['success_message'] = $current_d_status ? 'Room Mate Classified Activate Successfully.' : 'Room Mate Classified Deactivate Successfully.';
				$json['btn_text'] = $current_d_status ? 'Deactivate' : 'Make activate';
			} elseif ($request->name == 'isPayed') {
				$room->isPayed = $room->isPayed == 'Y' ? 'N' : 'Y';
				$current_payed = $room->isPayed == 'Y' ? true : false;

				$json['success'] = $current_payed;
				$json['success_message'] = $current_payed ? 'Room Mate Classified made premium Successfully.' : 'Room Mate Classified made free Successfully.';
				$json['btn_text'] = $current_payed ? 'Make Free' : 'Make Premium';
			}
			$room->save();
		}

		return $json;
	}

	public function viewItem(Request $request) {
		$json = array();

		$data['real'] = RoomMate::selectRaw('
            post_free_roommates.*,paypal_payments.*,users.first_name,users.last_name,
            states.name as states_name,
            cities.name as city_name,
            room_mate_categoires.name as category_name
        ')
			->leftJoin('states', 'states.code', 'post_free_roommates.states')
			->leftJoin('users', 'users.id', 'post_free_roommates.user_id')
			->leftJoin('paypal_payments', 'paypal_payments.id', 'post_free_roommates.payment_id')
			->leftJoin('cities', 'cities.id', 'post_free_roommates.city')
			->leftJoin('room_mate_categoires', 'room_mate_categoires.id', 'post_free_roommates.category')
			->where('post_free_roommates.id', (int) $request->id)->get()->first();

		return view('admin.room_mate_classified.view', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['room'] = RoomMate::findOrNew($id);

		return view('admin.room_mate_classified.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = RoomMate::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$room = RoomMate::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120|unique:post_free_roommates,title',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			// $matchingRecords = RoomMate::where('url_slug', trim($this->clean($request->title)))->get();
			// $matchingCount = $matchingRecords->count();
			// if ($matchingCount > 0) {
			// 	$new_title = $this->get_uniq_slug($request->title);
			// } else {
			// 	$new_title = $request->title;
			// }

			// if ($id > 0) {
			// 	if (trim($request->title) != $event->title) {
			// 		$event->title = $new_title;
			// 		$event->url_slug = $this->clean($new_title);
			// 	}} else {
			// 	$event->title = $new_title;
			// 	$event->url_slug = $this->clean($new_title);
			// }
			$room->name = $data['name'];
			$room->url_slug = $this->clean($data['name']);

			$room->code = $data['code'];
			$room->save();

			\Session::flash('success', 'Room Mate Classifieds Data Saved Successfully.');
			$json['location'] = route('admin.room_mate_classified.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$room = RoomMate::findOrNew($id);
		$room->remove();

		\Session::flash('success', 'Room Mate Classifieds Deleted Successfully.');
		return redirect()->back();
	}
}
