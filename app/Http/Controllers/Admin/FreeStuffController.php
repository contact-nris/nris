<?php

namespace App\Http\Controllers\Admin;

use App\FreeStuff;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class FreeStuffController extends Controller {
	public function index(Request $request) {
		$query = FreeStuff::selectRaw('
            post_free_stuff.*
        ')
			->orderBy('post_free_stuff.id', 'DESC')
			->where('post_free_stuff.country', country_id());

		if ($request->filter_name) {
			$query->where('post_free_stuff.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.free_stuff_classified.index', $data);
	}

	public function changeType(Request $request) {
		$json = array();

		$stuff = FreeStuff::find((int) $request->id);
		if ($stuff) {
			if ($request->name == 'display_status') {
				$stuff->display_status = !$stuff->display_status;
				$current_d_status = $stuff->display_status;

				$json['success'] = $current_d_status;
				$json['success_message'] = $current_d_status ? 'Free Stuff Classified Activate Successfully.' : 'Free Stuff Classified Deactivate Successfully.';
				$json['btn_text'] = $current_d_status ? 'Deactivate' : 'Make activate';
			} elseif ($request->name == 'isPayed') {
				$stuff->isPayed = $stuff->isPayed == 'Y' ? 'N' : 'Y';
				$current_payed = $stuff->isPayed == 'Y' ? true : false;

				$json['success'] = $current_payed;
				$json['success_message'] = $current_payed ? 'Free Stuff Classified made premium Successfully.' : 'Free Stuff Classified made free Successfully.';
				$json['btn_text'] = $current_payed ? 'Make Free' : 'Make Premium';
			}
			$stuff->save();
		}

		return $json;
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = FreeStuff::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function viewItem(Request $request) {
		$json = array();

		$data['stuff'] = FreeStuff::selectRaw('
            post_free_stuff.*,paypal_payments.*,users.first_name,users.last_name,
            cities.name as city_name,
            states.name as states_name
        ')
			->leftJoin('states', 'states.code', 'post_free_stuff.state')
			->leftJoin('users', 'users.id', 'post_free_stuff.user_id')
			->leftJoin('paypal_payments', 'paypal_payments.id', 'post_free_stuff.payment_id')
			->leftJoin('cities', 'cities.id', 'post_free_stuff.city')
			->where('post_free_stuff.id', (int) $request->id)->get()->first();

		return view('admin.free_stuff_classified.view', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['stuff'] = FreeStuff::findOrNew($id);

		return view('admin.free_stuff_classified.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$stuff = FreeStuff::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120|unique:post_free_stuff,title',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = FreeStuff::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $stuff->title) {
					$stuff->title = $new_title;
					$stuff->url_slug = $this->clean($new_title);
				}} else {
				$stuff->title = $new_title;
				$stuff->url_slug = $this->clean($new_title);
			}

			$stuff->code = $data['code'];
			$stuff->save();

			\Session::flash('success', 'Free Stuff Classified Data Saved Successfully.');
			$json['location'] = route('admin.free_stuff_classified.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$stuff = FreeStuff::findOrNew($id);
		$stuff->remove();

		\Session::flash('success', 'Free Stuff Classified Deleted Successfully.');
		return redirect()->back();
	}
}
