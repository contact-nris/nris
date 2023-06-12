<?php

namespace App\Http\Controllers\Admin;

use App\AutoClassified;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AutoClassifiedController extends Controller {
	public function index(Request $request) {
		$query = AutoClassified::selectRaw('
                auto_classifieds.*,
                states.name as states_name,
                auto_makes.name as auto_makes_name,
                auto_models.model_name as model_name
        ')
			->leftJoin('states', 'states.code', 'auto_classifieds.states')
			->leftJoin('auto_makes', 'auto_makes.id', 'auto_classifieds.make')
			->leftJoin('auto_models', 'auto_models.id', 'auto_classifieds.model')
			->orderBy('auto_classifieds.id', 'DESC')
			->where('auto_classifieds.country', country_id());

		if ($request->filter_name) {
			$query->where('auto_classifieds.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.auto_classified.index', $data);
	}

	public function changeType(Request $request) {
		$json = array();

		$auto_classifieds = AutoClassified::find((int) $request->id);

		if ($auto_classifieds) {
			if ($request->name == 'display_status') {
				$auto_classifieds->display_status = !$auto_classifieds->display_status;
				$current_d_status = $auto_classifieds->display_status;

				$json['success'] = $current_d_status;
				$json['success_message'] = $current_d_status ? 'Auto Classified Activate Successfully.' : 'Auto Classified Deactivate Successfully.';
				$json['btn_text'] = $current_d_status ? 'Deactivate' : 'Make activate';
			} elseif ($request->name == 'isPayed') {
				$auto_classifieds->isPayed = $auto_classifieds->isPayed == 'Y' ? 'N' : 'Y';
				$current_payed = $auto_classifieds->isPayed == 'Y' ? true : false;

				$json['success'] = $current_payed;
				$json['success_message'] = $current_payed ? 'Auto Classified made premium Successfully.' : 'Auto Classified made free Successfully.';
				$json['btn_text'] = $current_payed ? 'Make Free' : 'Make Premium';
			}
			$auto_classifieds->save();
		}

		return $json;
	}

	public function viewItem(Request $request) {
		$json = array();

		$data['auto_classifieds'] = AutoClassified::selectRaw('
            auto_classifieds.*,paypal_payments.*,users.first_name,users.last_name,
            states.name as states_name,
            auto_makes.name as auto_makes_name,
            auto_models.model_name as model_name
        ')
			->leftJoin('states', 'states.code', 'auto_classifieds.states')
			->leftJoin('auto_makes', 'auto_makes.id', 'auto_classifieds.make')
			->leftJoin('auto_models', 'auto_models.id', 'auto_classifieds.model')
			->leftJoin('users', 'users.id', 'auto_classifieds.user_id')
			->leftJoin('paypal_payments', 'paypal_payments.id', 'auto_classifieds.payment_id')
			->where('auto_classifieds.id', (int) $request->id)->get()->first();

		return view('admin.auto_classified.view', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['auto_classified'] = AutoClassified::findOrNew($id);

		return view('admin.auto_classified.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = AutoClassified::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$auto_classified = AutoClassified::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = AutoClassified::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $auto_classified->name) {
					$auto_classified->name = $new_title;
					$auto_classified->url_slug = $this->clean($new_title);
				}} else {
				$auto_classified->name = $new_title;
				$auto_classified->url_slug = $this->clean($new_title);
			}
			// $auto_classified->name = $data['name'];
			$auto_classified->url_slug = $this->clean($data['name']);

			$auto_classified->code = $data['code'];
			$auto_classified->save();

			\Session::flash('success', 'Auto Classified Data Saved Successfully.');
			$json['location'] = route('auto_classified.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$auto_classified = AutoClassified::findOrNew($id);
		$auto_classified->remove();

		\Session::flash('success', 'Auto Classified Deleted Successfully.');
		return redirect()->back();
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}

	public function getShortDescAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->message), 80, '...');
	}
}
