<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\NRITalkReply;
use Illuminate\Http\Request;
use Validator;

class NRITalkReplyController extends Controller {
	public function index() {
		$data['lists'] = NRITalkReply::selectRaw('nris_talk_reply.*, CONCAT(users.first_name," ",users.last_name) as username')
			->leftJoin('users', 'users.id', 'nris_talk_reply.user_id')
			->paginate();

		return view('admin.nritalk.nrireply.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['nrireply'] = NRITalkReply::selectRaw('nris_talk_reply.*, nris_talk.title')
			->leftJoin('nris_talk', 'nris_talk.user_id', 'nris_talk_reply.user_id')
			->findOrNew($id);

		return view('admin.nritalk.nrireply.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$nrireply = NRITalkReply::findOrNew($id);
		$rules = array(
			'comment' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$nrireply->comment = $data['comment'];
			$nrireply->save();

			\Session::flash('success', 'NRI Talks Data Saved Successfully.');
			$json['location'] = route('nrireply.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$nrireply = NRITalkReply::findOrNew($id);
		$nrireply->remove();

		\Session::flash('success', 'NRI Talks Deleted Successfully.');
		return redirect()->back();
	}
}
