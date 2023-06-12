<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\NRITalk;
use Illuminate\Http\Request;
use Validator;

class NRITalkController extends Controller {
	public function index() {
		$data['lists'] = NRITalk::selectRaw('nris_talk.*, CONCAT(users.first_name," ",users.last_name) as username')
			->leftJoin('users', 'users.id', 'nris_talk.user_id')
			->orderBy('nris_talk.id', 'desc')
			->paginate();

		return view('admin.nritalk.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['nritalk'] = NRITalk::findOrNew($id);

		return view('admin.nritalk.form', $data);
	}

	public function changeType(Request $request) {
		$json = array();

		$talk = NRITalk::find((int) $request->id);
		if ($talk) {
			if ($request->name == 'status') {
				$talk->status = !$talk->status;
				$talk->save();

				$current_status = $talk->status;
				$json['success'] = $current_status;
				$json['success_message'] = $current_status ? 'Talk Status Active Successfully.' : 'Talk Status InActive Successfully.';
				$json['btn_text'] = $current_status ? 'Active' : 'InActive';
			}
		}

		return $json;
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = NRITalk::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$nritalk = NRITalk::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = NRITalk::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $nritalk->title) {
					$nritalk->title = $new_title;
					$nritalk->url_slug = $this->clean($new_title);
				}} else {
				$nritalk->title = $new_title;
				$nritalk->url_slug = $this->clean($new_title);
			}
			$nritalk->description = $data['description'];
			$nritalk->meta_title = $request->meta_title;
			$nritalk->meta_description = $request->meta_description;
			$nritalk->meta_keywords = $request->meta_keywords;
			$nritalk->save();

			\Session::flash('success', 'NRI Talks Data Saved Successfully.');
			$json['location'] = route('nritalk.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$nritalk = NRITalk::findOrNew($id);
		$nritalk->remove();

		\Session::flash('success', 'NRI Talks Deleted Successfully.');
		return redirect()->back();
	}
}
