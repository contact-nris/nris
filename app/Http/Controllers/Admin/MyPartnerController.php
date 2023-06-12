<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MyPartner;
use Illuminate\Http\Request;
use Validator;

class MyPartnerController extends Controller {
	public function index(Request $request) {
		$query = MyPartner::selectRaw('
            post_free_mypartner.*,
            mypartner_categories.name as category_name
        ')
			->leftJoin('mypartner_categories', 'mypartner_categories.id', 'post_free_mypartner.category')
			->orderBy('post_free_mypartner.id', 'DESC')
			->where('post_free_mypartner.country', country_id());

		if ($request->filter_name) {
			$query->where('post_free_mypartner.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.mypartner_classified.index', $data);
	}

	public function changeType(Request $request) {
		$json = array();

		$room = MyPartner::find((int) $request->id);
		if ($room) {
			if ($request->name == 'display_status') {
				$room->display_status = !$room->display_status;
				$current_d_status = $room->display_status;

				$json['success'] = $current_d_status;
				$json['success_message'] = $current_d_status ? 'My Partner Classified Activate Successfully.' : 'My Partner Classified Deactivate Successfully.';
				$json['btn_text'] = $current_d_status ? 'Deactivate' : 'Make activate';
			} elseif ($request->name == 'isPayed') {
				$room->isPayed = $room->isPayed == 'Y' ? 'N' : 'Y';
				$current_payed = $room->isPayed == 'Y' ? true : false;

				$json['success'] = $current_payed;
				$json['success_message'] = $current_payed ? 'My Partner Classified made premium Successfully.' : 'My Partner Classified made free Successfully.';
				$json['btn_text'] = $current_payed ? 'Make Free' : 'Make Premium';
			}
			$room->save();
		}

		return $json;
	}

	public function viewItem(Request $request) {
		$json = array();

		$data['real'] = MyPartner::selectRaw('
            post_free_mypartner.*,paypal_payments.*,users.first_name,users.last_name,
            states.name as states_name,
            cities.name as city_name,
            mypartner_categories.name as category_name
        ')
			->leftJoin('users', 'users.id', 'post_free_mypartner.user_id')
			->leftJoin('paypal_payments', 'paypal_payments.id', 'post_free_mypartner.payment_id')
			->leftJoin('states', 'states.code', 'post_free_mypartner.states')
			->leftJoin('cities', 'cities.id', 'post_free_mypartner.city')
			->leftJoin('mypartner_categories', 'mypartner_categories.id', 'post_free_mypartner.category')
			->where('post_free_mypartner.id', (int) $request->id)->get()->first();

		return view('admin.mypartner_classified.view', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['room'] = MyPartner::findOrNew($id);

		return view('admin.mypartner_classified.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = MyPartner::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$room = MyPartner::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120|unique:post_free_mypartner,title',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = MyPartner::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $room->title) {
					$room->title = $new_title;
					$room->url_slug = $this->clean($new_title);
				}} else {
				$room->title = $new_title;
				$room->url_slug = $this->clean($new_title);
			}
			$room->name = $data['name'];
			$room->url_slug = $this->clean($data['name']);

			$room->code = $data['code'];
			$room->save();

			\Session::flash('success', 'My Partner Classifieds Data Saved Successfully.');
			$json['location'] = route('admin.mypartner_classified.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$room = MyPartner::findOrNew($id);
		$room->delete();

		\Session::flash('success', 'My Partner Classifieds Deleted Successfully.');
		return redirect()->back();
	}
}
