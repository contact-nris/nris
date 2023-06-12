<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\RealEstate;
use Illuminate\Http\Request;
use Validator;

class RealEstateController extends Controller {
	public function index(Request $request) {
		$query = RealEstate::selectRaw('
            post_free_real_estate.*,
            realestate_categoires.name as category_name
        ')
			->leftJoin('realestate_categoires', 'realestate_categoires.id', 'post_free_real_estate.category_id')
			->orderBy('post_free_real_estate.id', 'DESC')
			->where('post_free_real_estate.country', country_id());

		if ($request->filter_name) {
			$query->where('post_free_real_estate.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.real_estate_classifieds.index', $data);
	}

	public function changeType(Request $request) {
		$json = array();

		$real = RealEstate::find((int) $request->id);
		if ($real) {
			if ($request->name == 'display_status') {
				$real->display_status = !$real->display_status;
				$current_d_status = $real->display_status;

				$json['success'] = $current_d_status;
				$json['success_message'] = $current_d_status ? 'Real Estate Classifieds Activate Successfully.' : 'Real Estate Classifieds Deactivate Successfully.';
				$json['btn_text'] = $current_d_status ? 'Deactivate' : 'Make activate';
			} elseif ($request->name == 'isPayed') {
				$real->isPayed = $real->isPayed == 'Y' ? 'N' : 'Y';
				$current_payed = $real->isPayed == 'Y' ? true : false;

				$json['success'] = $current_payed;
				$json['success_message'] = $current_payed ? 'Real Estate Classifieds made premium Successfully.' : 'Real Estate Classifieds made free Successfully.';
				$json['btn_text'] = $current_payed ? 'Make Free' : 'Make Premium';
			}

			$real->save();
		}

		return $json;
	}

	public function viewItem(Request $request) {
		$json = array();

		$data['real'] = RealEstate::selectRaw('
            post_free_real_estate.*,paypal_payments.*,users.first_name,users.last_name,
            states.name as states_name,
            realestate_categoires.name as category_name
        ')
			->leftJoin('states', 'states.code', 'post_free_real_estate.states')
			->leftJoin('users', 'users.id', 'post_free_real_estate.user_id')
			->leftJoin('paypal_payments', 'paypal_payments.id', 'post_free_real_estate.payment_id')
			->leftJoin('realestate_categoires', 'realestate_categoires.id', 'post_free_real_estate.category_id')
			->where('post_free_real_estate.id', (int) $request->id)->get()->first();

		return view('admin.real_estate_classifieds.view', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['realclassifieds'] = RealEstate::findOrNew($id);

		return view('admin.babysitting_classified.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = RealEstate::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$real = RealEstate::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120|unique:post_free_real_estate,title',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			// $matchingRecords = RealEstate::where('url_slug', trim($this->clean($request->title)))->get();
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
			$real->name = $data['name'];
			$real->url_slug = $this->clean($data['name']);

			$real->code = $data['code'];
			$real->save();

			\Session::flash('success', 'Real Estate Classifieds Data Saved Successfully.');
			$json['location'] = route('admin.realestate_classifieds.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$real = RealEstate::findOrNew($id);
		$real->remove();

		\Session::flash('success', 'Real Estate Classifieds Deleted Successfully.');
		return redirect()->back();
	}
}
