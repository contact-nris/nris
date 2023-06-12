<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\JobClassifieds;
use Illuminate\Http\Request;
use Validator;

class JobsClassifiedsController extends Controller {
	public function index(Request $request) {
		$query = JobClassifieds::selectRaw('
            post_free_job.*,
            job_categories.name as category_name
        ')
			->leftJoin('job_categories', 'job_categories.id', 'post_free_job.category')
			->orderBy('post_free_job.id', 'DESC')
			->where('post_free_job.country', country_id());

		if ($request->filter_name) {
			$query->where('post_free_job.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.job_classifieds.index', $data);
	}

	public function changeType(Request $request) {
		$json = array();

		$job = JobClassifieds::find((int) $request->id);
		if ($job) {
			if ($request->name == 'display_status') {
				$job->display_status = !$job->display_status;
				$current_d_status = $job->display_status;

				$json['success'] = $current_d_status;
				$json['success_message'] = $current_d_status ? 'Job Classified Activate Successfully.' : 'Job Classified Deactivate Successfully.';
				$json['btn_text'] = $current_d_status ? 'Deactivate' : 'Make activate';
			} elseif ($request->name == 'isPayed') {
				$job->isPayed = $job->isPayed == 'Y' ? 'N' : 'Y';
				$current_payed = $job->isPayed == 'Y' ? true : false;

				$json['success'] = $current_payed;
				$json['success_message'] = $current_payed ? 'Job Classified made premium Successfully.' : 'Job Classified made free Successfully.';
				$json['btn_text'] = $current_payed ? 'Make Free' : 'Make Premium';
			}
			$job->save();

		}

		return $json;
	}

	public function viewItem(Request $request) {
		$json = array();

		$data['electronics'] = JobClassifieds::selectRaw('
            post_free_job.*,paypal_payments.*,users.first_name,users.last_name,
            states.name as states_name,
            job_categories.name as category_name
        ')
			->leftJoin('states', 'states.code', 'post_free_job.states')
			->leftJoin('users', 'users.id', 'post_free_job.user_id')
			->leftJoin('paypal_payments', 'paypal_payments.id', 'post_free_job.payment_id')
			->leftJoin('job_categories', 'job_categories.id', 'post_free_job.category')
			->where('post_free_job.id', (int) $request->id)->get()->first();

		return view('admin.job_classifieds.view', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['electronicsclassifieds'] = JobClassifieds::findOrNew($id);

		return view('admin.babysitting_classified.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = JobClassifieds::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$electronics = JobClassifieds::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120|unique:post_free_job,title',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = JobClassifieds::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $electronics->title) {
					$electronics->title = $new_title;
					$electronics->url_slug = $this->clean($new_title);
				}} else {
				$electronics->title = $new_title;
				$electronics->url_slug = $this->clean($new_title);
			}
			$electronics->code = $data['code'];
			$electronics->save();

			\Session::flash('success', 'Job Classifieds Data Saved Successfully.');
			$json['location'] = route('admin.electronicsclassifieds_classified.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$electronics = JobClassifieds::findOrNew($id);
		$electronics->remove();

		\Session::flash('success', 'Job Classifieds Deleted Successfully.');
		return redirect()->back();
	}
}
