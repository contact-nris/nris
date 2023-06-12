<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\NewsVideo;
use Illuminate\Http\Request;
use Validator;

class NewsVideoController extends Controller {
	public function index() {
		// NewsVideo::paginate();
		$data['lists'] = NewsVideo::orderBy('id', 'desc')->paginate();

		return view('admin.newsvideo.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['news'] = NewsVideo::findOrNew($id);

		return view('admin.newsvideo.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = NewsVideo::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$news = NewsVideo::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
			'link' => 'required',
			'content' => 'required|min:2',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = NewsVideo::where('url_slug', trim($this->clean($request->name)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->name);
			} else {
				$new_title = $request->name;
			}

			if ($id > 0) {
				if (trim($request->name) != $news->title) {
					$news->title = $new_title;
					$news->url_slug = $this->clean($new_title);
				}} else {
				$news->title = $new_title;
				$news->url_slug = $this->clean($new_title);
			}
			$news->video_link = $request->link;
			$news->content = $request->content;
			$news->meta_title = $request->meta_title;
			$news->meta_description = $request->meta_description;
			$news->meta_keywords = $request->meta_keywords;

			$news->save();

			\Session::flash('success', 'News Videos Data Saved Successfully.');
			$json['location'] = route('newsvideo.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$news = NewsVideo::findOrNew($id);
		$news->remove();

		\Session::flash('success', 'News Videos Deleted Successfully.');
		return redirect()->back();
	}
}
