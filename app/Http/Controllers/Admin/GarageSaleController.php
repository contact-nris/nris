<?php

namespace App\Http\Controllers\Admin;

use App\GarageSale;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class GarageSaleController extends Controller {
	public function index(Request $request) {
		$query = GarageSale::selectRaw('
            post_free_garagesale.*,
            garagesale_categoires.name as items_name
        ')
			->leftJoin('garagesale_categoires', 'garagesale_categoires.id', 'post_free_garagesale.items')
			->orderBy('post_free_garagesale.id', 'DESC')
			->where('post_free_garagesale.country', country_id());

		if ($request->filter_name) {
			$query->where('post_free_garagesale.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.garage_sale_classified.index', $data);
	}

	public function changeType(Request $request) {
		$json = array();

		$garage = GarageSale::find((int) $request->id);
		if ($garage) {
			if ($request->name == 'display_status') {
				$garage->display_status = !$garage->display_status;
				$current_d_status = $garage->display_status;

				$json['success'] = $current_d_status;
				$json['success_message'] = $current_d_status ? 'Garage Sale Classified Activate Successfully.' : 'Garage Sale Classified Deactivate Successfully.';
				$json['btn_text'] = $current_d_status ? 'Deactivate' : 'Make activate';
			} elseif ($request->name == 'isPayed') {
				$garage->isPayed = $garage->isPayed == 'Y' ? 'N' : 'Y';
				$current_payed = $garage->isPayed == 'Y' ? true : false;

				$json['success'] = $current_payed;
				$json['success_message'] = $current_payed ? 'Garage Sale Classified made premium Successfully.' : 'Garage Sale Classified made free Successfully.';
				$json['btn_text'] = $current_payed ? 'Make Free' : 'Make Premium';
			}

			$garage->save();
		}

		return $json;
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = GarageSale::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function viewItem(Request $request) {
		$json = array();

		$data['real'] = GarageSale::selectRaw('
            post_free_garagesale.*,paypal_payments.*,users.first_name,users.last_name,
            states.name as states_name,
            cities.name as city_name,
            garagesale_categoires.name as items_name
        ')
			->leftJoin('states', 'states.code', 'post_free_garagesale.states')
			->leftJoin('users', 'users.id', 'post_free_garagesale.user_id')
			->leftJoin('paypal_payments', 'paypal_payments.id', 'post_free_garagesale.payment_id')
			->leftJoin('cities', 'cities.id', 'post_free_garagesale.city')
			->leftJoin('garagesale_categoires', 'garagesale_categoires.id', 'post_free_garagesale.items')
			->where('post_free_garagesale.id', (int) $request->id)->get()->first();

		return view('admin.garage_sale_classified.view', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['room'] = GarageSale::findOrNew($id);

		return view('admin.garage_sale_classified.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$room = GarageSale::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120|unique:post_free_garagesale,title',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = GarageSale::where('url_slug', trim($this->clean($request->title)))->get();
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

			$room->code = $data['code'];
			$room->save();

			\Session::flash('success', 'Garage Sale Classified Data Saved Successfully.');
			$json['location'] = route('admin.garage_sale_classified.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$room = GarageSale::findOrNew($id);
		$room->remove();

		\Session::flash('success', 'Garage Sale Classified Deleted Successfully.');
		return redirect()->back();
	}
}
