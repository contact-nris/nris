<?php

namespace App\Http\Controllers\Admin;

use App\BabySittingClassified;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class BabysittingClassifiedsController extends Controller {
	public function index(Request $request) {
		$query = BabySittingClassified::selectRaw('
            post_free_baby_sitting.*,
            states.name as states_name,
            baby_sitting_categories.name as baby_sitting_name
            ')
			->leftJoin('states', 'states.code', 'post_free_baby_sitting.state')
			->leftJoin('baby_sitting_categories', 'baby_sitting_categories.id', 'post_free_baby_sitting.category')
			->orderBy('post_free_baby_sitting.id', 'DESC')

			->where('post_free_baby_sitting.country', country_id());
		if ($request->filter_name) {
			$query->where('post_free_baby_sitting.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.babysitting_classified.index', $data);
	}

	public function changeType(Request $request) {
		$json = array();

		$babysitting = BabySittingClassified::find((int) $request->id);
		if ($babysitting) {
			if ($request->name == 'display_status') {
				$babysitting->display_status = !$babysitting->display_status;
				$current_d_status = $babysitting->display_status;

				$json['success'] = $current_d_status;
				$json['success_message'] = $current_d_status ? 'Baby Sitting Classified Activate Successfully.' : 'Baby Sitting Classified Deactivate Successfully.';
				$json['btn_text'] = $current_d_status ? 'Deactivate' : 'Make activate';
			} elseif ($request->name == 'isPayed') {
				$babysitting->isPayed = $babysitting->isPayed == 'Y' ? 'N' : 'Y';
				$current_payed = $babysitting->isPayed == 'Y' ? true : false;

				$json['success'] = $current_payed;
				$json['success_message'] = $current_payed ? 'Baby Sitting Classified made premium Successfully.' : 'Baby Sitting Classified made free Successfully.';
				$json['btn_text'] = $current_payed ? 'Make Free' : 'Make Premium';
			}

			$babysitting->save();
		}

		return $json;
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = BabySittingClassified::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function viewItem(Request $request) {
		$json = array();

		$data['babysitting'] =
		$query = BabySittingClassified::selectRaw('
            post_free_baby_sitting.*,paypal_payments.*,users.first_name,users.last_name,
            states.name as states_name,
            baby_sitting_categories.name as baby_sitting_name
            ')
			->leftJoin('states', 'states.code', 'post_free_baby_sitting.state')
			->leftJoin('users', 'users.id', 'post_free_baby_sitting.user_id')
			->leftJoin('paypal_payments', 'paypal_payments.id', 'post_free_baby_sitting.payment_id')
			->leftJoin('baby_sitting_categories', 'baby_sitting_categories.id', 'post_free_baby_sitting.category')
			->where('post_free_baby_sitting.id', (int) $request->id)->get()->first();

		return view('admin.babysitting_classified.view', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['babysitting'] = BabySittingClassified::findOrNew($id);

		return view('admin.babysitting_classified.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$babysitting = BabySittingClassified::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = BabySittingClassified::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $babysitting->name) {
					$babysitting->name = $new_title;
					$babysitting->url_slug = $this->clean($new_title);
				}} else {
				$babysitting->name = $new_title;
				$babysitting->url_slug = $this->clean($new_title);
			}

			$babysitting->url_slug = $this->clean($data['name']);

			$babysitting->code = $data['code'];
			$babysitting->save();

			\Session::flash('success', 'Baby Sitting Classified Data Saved Successfully.');
			$json['location'] = route('admin.babysitting_classified.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$babysitting = BabySittingClassified::findOrNew($id);
		$babysitting->remove();

		\Session::flash('success', 'Baby Sitting Classified Deleted Successfully.');
		return redirect()->back();
	}
}