<?php

namespace App\Http\Controllers\Admin;

use App\EducationTeachingClassified;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class EducationTeachingClassifiedsController extends Controller {
	public function index(Request $request) {
		$query = EducationTeachingClassified::selectRaw('
                post_free_education.*,
                education_teaching_categories.name as education_teaching_name
            ')
			->leftJoin('education_teaching_categories', 'education_teaching_categories.id', 'post_free_education.category')
			->orderBy('post_free_education.id', 'DESC')
			->where('post_free_education.country', country_id());
		if ($request->filter_name) {
			$query->where('post_free_education.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.educationteaching_classified.index', $data);
	}

	public function changeType(Request $request) {
		$json = array();

		$educationTeaching = EducationTeachingClassified::find((int) $request->id);

		if ($educationTeaching) {
			if ($request->name == 'display_status') {
				$educationTeaching->display_status = !$educationTeaching->display_status;
				$current_d_status = $educationTeaching->display_status;

				$json['success'] = $current_d_status;
				$json['success_message'] = $current_d_status ? 'Education and Teaching Classified Activate Successfully.' : 'Education and Teaching Classified Deactivate Successfully.';
				$json['btn_text'] = $current_d_status ? 'Deactivate' : 'Make activate';
			} elseif ($request->name == 'isPayed') {
				$educationTeaching->isPayed = $educationTeaching->isPayed == 'Y' ? 'N' : 'Y';
				$current_payed = $educationTeaching->isPayed == 'Y' ? true : false;

				$json['success'] = $current_payed;
				$json['success_message'] = $current_payed ? 'Education and Teaching Classified made premium Successfully.' : 'Education and Teaching Classified made free Successfully.';
				$json['btn_text'] = $current_payed ? 'Make Free' : 'Make Premium';
			}

			$educationTeaching->save();
		}

		return $json;
	}

	public function viewItem(Request $request) {
		$json = array();

		$data['educationTeaching'] = EducationTeachingClassified::selectRaw('
            post_free_education.*,paypal_payments.*,users.first_name,users.last_name,
            states.name as states_name,
            education_teaching_categories.name as education_teaching_name
            ')
			->leftJoin('states', 'states.code', 'post_free_education.states')
			->leftJoin('users', 'users.id', 'post_free_education.user_id')
			->leftJoin('paypal_payments', 'paypal_payments.id', 'post_free_education.payment_id')
			->leftJoin('education_teaching_categories', 'education_teaching_categories.id', 'post_free_education.category')
			->where('post_free_education.id', (int) $request->id)->get()->first();

		return view('admin.educationteaching_classified.view', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['educationTeaching'] = EducationTeachingClassified::findOrNew($id);

		return view('admin.babysitting_classified.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$educationTeaching = EducationTeachingClassified::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120|unique:education_teaching_categories,title',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$educationTeaching->name = $data['name'];
			$educationTeaching->url_slug = $this->clean($data['name']);

			$educationTeaching->code = $data['code'];
			$educationTeaching->save();

			\Session::flash('success', 'Baby Sitting Classified Data Saved Successfully.');
			$json['location'] = route('admin.educationteaching_classified.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$educationTeaching = EducationTeachingClassified::findOrNew($id);
		$educationTeaching->remove();

		\Session::flash('success', 'Baby Sitting Classified Deleted Successfully.');
		return redirect()->back();
	}
}
