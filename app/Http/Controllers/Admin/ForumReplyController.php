<?php

namespace App\Http\Controllers\Admin;

use App\ForumReply;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ForumReplyController extends Controller {
	public function index() {
		$data['lists'] = ForumReply::selectRaw('forums_reply.*, CONCAT(users.first_name," ",users.last_name) as username, forums_thread.title as forums_thread_title')
			->leftJoin('users', 'users.id', 'forums_reply.user_id')
			->leftJoin('forums_thread', 'forums_thread.id', 'forums_reply.forum_thread_id')
			->orderBy('forums_reply.id', 'DESC')
			->paginate();
		return view('admin.forum.reply.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['reply'] = ForumReply::findOrNew($id);

		return view('admin.forum.reply.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$reply = ForumReply::findOrNew($id);
		$rules = array(
			'comment' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$reply->comment = $data['comment'];
			$reply->save();

			\Session::flash('success', 'Forum Reply Data Saved Successfully.');
			$json['location'] = route('forum_reply.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$reply = ForumReply::findOrNew($id);
		$reply->remove();

		\Session::flash('success', 'Forum Reply Deleted Successfully.');
		return redirect()->back();
	}
}
