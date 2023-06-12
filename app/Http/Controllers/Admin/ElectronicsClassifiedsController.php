<?php

namespace App\Http\Controllers\Admin;

use App\ElectronicsClassifieds;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ElectronicsClassifiedsController extends Controller {
	public function index(Request $request) {
		$query = ElectronicsClassifieds::selectRaw('
            post_free_electronics.*,
            electronic_categories.name as category_name
        ')
			->leftJoin('electronic_categories', 'electronic_categories.id', 'post_free_electronics.category')
			->orderBy('post_free_electronics.id', 'DESC')
			->where('post_free_electronics.country', country_id());

		if ($request->filter_name) {
			$query->where('post_free_electronics.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.electronics_classifieds.index', $data);
	}

	public function changeType(Request $request) {
		$json = array();

		$electronics = ElectronicsClassifieds::find((int) $request->id);
		if ($electronics) {
			if ($request->name == 'display_status') {
				$electronics->display_status = !$electronics->display_status;
				$current_d_status = $electronics->display_status;

				$json['success'] = $current_d_status;
				$json['success_message'] = $current_d_status ? 'Electronics Classified Activate Successfully.' : 'Electronics Classified Deactivate Successfully.';
				$json['btn_text'] = $current_d_status ? 'Deactivate' : 'Make activate';
			} elseif ($request->name == 'isPayed') {
				$electronics->isPayed = $electronics->isPayed == 'Y' ? 'N' : 'Y';
				$current_payed = $electronics->isPayed == 'Y' ? true : false;

				$json['success'] = $current_payed;
				$json['success_message'] = $current_payed ? 'Electronics Classified made premium Successfully.' : 'Electronics Classified made free Successfully.';
				$json['btn_text'] = $current_payed ? 'Make Free' : 'Make Premium';
			}
			$electronics->save();
		}

		return $json;
	}

	public function viewItem(Request $request) {
		$json = array();

		$data['electronics'] = ElectronicsClassifieds::selectRaw('
            post_free_electronics.*,paypal_payments.*,users.first_name,users.last_name,
            states.name as states_name,
            electronic_categories.name as category_name
        ')
			->leftJoin('states', 'states.code', 'post_free_electronics.states')
			->leftJoin('users', 'users.id', 'post_free_electronics.user_id')
			->leftJoin('paypal_payments', 'paypal_payments.id', 'post_free_electronics.payment_id')
			->leftJoin('electronic_categories', 'electronic_categories.id', 'post_free_electronics.category')
			->where('post_free_electronics.id', (int) $request->id)->get()->first();

		return view('admin.electronics_classifieds.view', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['electronicsclassifieds'] = ElectronicsClassifieds::findOrNew($id);

		return view('admin.babysitting_classified.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = ElectronicsClassifieds::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$electronics = ElectronicsClassifieds::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = ElectronicsClassifieds::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $electronics->name) {
					$electronics->name = $new_title;
					$electronics->url_slug = $this->clean($new_title);
				}} else {
				$electronics->name = $new_title;
				$electronics->url_slug = $this->clean($new_title);
			}

			$electronics->code = $data['code'];
			$electronics->save();

			\Session::flash('success', 'Electronics Classifieds Data Saved Successfully.');
			$json['location'] = route('admin.electronicsclassifieds_classified.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$electronics = ElectronicsClassifieds::findOrNew($id);
		$electronics->remove();

		\Session::flash('success', 'Electronics Classifieds Deleted Successfully.');
		return redirect()->back();
	}
}
