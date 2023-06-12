<?php

namespace App\Http\Controllers\Admin;

use App\ForumThread;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ForumThreadController extends Controller {
	public function index() {
		$data['lists'] = ForumThread::selectRaw('forums_thread.*')
			->paginate();

		return view('admin.forum.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['forum'] = ForumThread::findOrNew($id);

		return view('admin.forum.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$forum = ForumThread::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120',
			'description' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$forum->title = $request->title;
			$forum->description = $request->description;
			$forum->status = (int) $request->status;

			$forum->meta_title = $request->meta_title;
			$forum->meta_description = $request->meta_description;
			$forum->meta_keywords = $request->meta_keywords;

			$forum->save();

			\Session::flash('success', 'Forum Thread Data Saved Successfully.');
			$json['location'] = route('forum.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$forum = ForumThread::findOrNew($id);
		$forum->remove();

		\Session::flash('success', 'Forum Thread Deleted Successfully.');
		return redirect()->back();
	}
}
