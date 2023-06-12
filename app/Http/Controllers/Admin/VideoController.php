<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Video;
use Illuminate\Http\Request;
use Validator;

class VideoController extends Controller {
	public function index() {
		$data['lists'] = Video::selectRaw('videos.*,videos_categoires.category_name as category_name,videos_languages.name as language_name')
			->leftJoin('videos_categoires', 'videos_categoires.id', 'videos.category')
			->leftJoin('videos_languages', 'videos_languages.id', 'videos.language')
			->paginate();
		return view('admin.video.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['video'] = Video::findOrNew($id);

		return view('admin.video.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Video::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$video = Video::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120',
			'language' => 'required',
			'category' => 'required',
			'link' => 'required',
			'status' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = Video::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $video->title) {
					$video->title = $new_title;
					$video->url_slug = $this->clean($new_title);
				}} else {
				$video->title = $new_title;
				$video->url_slug = $this->clean($new_title);
			}
			$video->language = (int) $request->language;
			$video->category = (int) $request->category;
			$video->link = $request->link;
			$video->status = (int) $request->status;

			// $temp = strstr($video->link,"v=");

			// print_r($temp)
			// if(strstr($temp,"&")){
			//     $pieces = explode("&", $temp);
			//     $pieces = explode("=", $pieces[0]);
			// } else {
			//     $pieces = explode("=", $temp);
			// }

			// $video->video_id = isset($pieces[0]) ? $pieces[0] : '';

			preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video->link, $matches);
			$video->video_id = $matches[1];

			$video->save();

			\Session::flash('success', 'video Data Saved Successfully.');
			$json['location'] = route('video.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$video = Video::findOrNew($id);
		$video->remove();

		\Session::flash('success', 'video Deleted Successfully.');
		return redirect()->back();
	}
}
