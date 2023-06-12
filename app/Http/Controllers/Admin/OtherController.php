<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Other;
use Illuminate\Http\Request;
use Validator;

class OtherController extends Controller {
	public function index(Request $request) {
		$query = Other::selectRaw('
            post_free_other.*,
            cities.name as city_name,
            states.name as states_name
        ')
			->leftJoin('states', 'states.code', 'post_free_other.states')
			->leftJoin('cities', 'cities.id', 'post_free_other.city')
			->orderBy('post_free_other.id', 'DESC')
			->where('post_free_other.country', country_id());

		if ($request->filter_name) {
			$query->where('post_free_other.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.other_classified.index', $data);
	}

	public function changeType(Request $request) {
		$json = array();

		$other = Other::find((int) $request->id);
		if ($other) {
			if ($request->name == 'display_status') {
				$other->display_status = !$other->display_status;
				$current_d_status = $other->display_status;

				$json['success'] = $current_d_status;
				$json['success_message'] = $current_d_status ? 'Other Classified Activate Successfully.' : 'Other Classified Deactivate Successfully.';
				$json['btn_text'] = $current_d_status ? 'Deactivate' : 'Make activate';
			} elseif ($request->name == 'isPayed') {
				$other->isPayed = $other->isPayed == 'Y' ? 'N' : 'Y';
				$current_payed = $other->isPayed == 'Y' ? true : false;

				$json['success'] = $current_payed;
				$json['success_message'] = $current_payed ? 'Other Classified made premium Successfully.' : 'Other Classified made free Successfully.';
				$json['btn_text'] = $current_payed ? 'Make Free' : 'Make Premium';
			}
			$other->save();
		}

		return $json;
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

   public function viewItem(Request $request) {
		$json = array();

		$data['other'] = Other::selectRaw('
            post_free_other.*,paypal_payments.*,users.first_name,users.last_name,
            cities.name as city_name,
            states.name as states_name
        ')
			->leftJoin('states', 'states.code', 'post_free_other.states')
			->leftJoin('cities', 'cities.id', 'post_free_other.city')
			->leftJoin('users', 'users.id', 'post_free_other.user_id')
			->leftJoin('paypal_payments', 'paypal_payments.id', 'post_free_other.payment_id')
			->where('post_free_other.id', (int) $request->id)->get()->first();
		return view('admin.other_classified.view', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['other'] = Other::findOrNew($id);

		return view('admin.other_classified.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Other::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$other = Other::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120|unique:post_free_other,title',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			// $matchingRecords = Other::where('url_slug', trim($this->clean($request->title)))->get();
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
			$other->name = $data['name'];
			$other->url_slug = $this->clean($data['name']);

			$other->code = $data['code'];
			$other->save();

			\Session::flash('success', 'Other Classifieds Data Saved Successfully.');
			$json['location'] = route('admin.other_classified.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$other = Other::findOrNew($id);
		$other->remove();

		\Session::flash('success', 'Other Classifieds Deleted Successfully.');
		return redirect()->back();
	}
}
