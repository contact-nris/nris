<?php

namespace App\Http\Controllers;

use App\Video;
use App\VideoCategory;
use App\VideoLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Validator;

// use App\BlogComment;

class VideosController extends Controller {

	public $meta_tags = array(
		'title' => ' %s Videos',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Videos and stay updated with the latest posts.',
		'twitter_title' => 'Video',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);

	public function index(Request $request, $languages, $category = '') {

		$data = array();

		$query = Video::selectRaw('videos.*,videos_categoires.category_name as category_name,videos_languages.name as language_name, videos_languages.slug as lang_slug
        ')
		// (SELECT COUNT(*) FROM videos_like WHERE videos_like.video_id = videos.id AND videos_like.status = 1) as like_count,
		// (SELECT COUNT(*) FROM videos_like WHERE videos_like.video_id = videos.id AND videos_like.status = 0) as dislike_count
			->leftJoin('videos_categoires', 'videos_categoires.id', 'videos.category')
			->leftJoin('videos_languages', 'videos_languages.id', 'videos.language')
		// ->leftJoin('videos_like', 'videos_like.video_id', 'videos.id')
			->with('video_like', 'video_dislike')
			->where(array('videos.status' => 1))
			->orderBy('videos.id', 'desc');

		if ($languages) {
			$query->where('videos_languages.slug', $languages);
		}

		if ($category) {
			$query->where('videos_categoires.category_name', $category);
		}

		if ($request->filter_name) {
			$query->where('videos.title', 'like', '%' . $request->filter_name . '%');
		}

		//clone $query
		$c_key = "movie_of_day_" . date("Y-m-d") . "_" . ($languages ? $languages : "");
		$id = Cache::get($c_key);

		$query_clone = clone $query;
		if ((int) $id > 0) {
			$data['header_thumb'] = $query_clone->where('videos.id', $id)->first();
		}

		if (!isset($data['header_thumb']) || !$data['header_thumb']) {
			$data['header_thumb'] = $query_clone->inRandomOrder()->first();
		}

		if ($data['header_thumb']) {
			Cache::put($c_key, $data['header_thumb']->id, 1440);
		}

		$data['lists'] = $query->paginate(16);
		$data['lang_slug'] = $languages;

		if (auth()->user()) {
			foreach ($data['lists'] as $key => $val) {
				$val->like_status = VideoLike::selectRaw('status')->where(array('video_id' => $val->id, 'user_id' => auth()->user()->id))->orWhereNull('status')->value('status');
				if ($data['header_thumb'] && $data['header_thumb']->id == $val->id) {
					$data['header_thumb']->like_status = $val->like_status;
				}
			}
		}

		$data['categories'] = VideoCategory::all();
		$data['header_img'] = '';
		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $languages);
		$data['meta_tags']['keywords'] = str_replace('%s', $languages, $data['meta_tags']['keywords']);

		return view('front.video.list', $data);
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

	public function view(Request $request, $slug) {

		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$data['news_video'] = Video::where('id', $id)->firstOrFail();

		// print_r($data['news_video']);
		// exit;
		$data['more_videos'] = Video::where('id', '!=', $id)->orderBy("id", "Desc")->limit(8)->get();

		$data['meta_tags'] = array(
			'meta_title' => $data['news_video']->meta_title,
			'meta_description' => $data['news_video']->meta_description,
			'meta_keywords' => $data['news_video']->meta_keywords,
			'title' => $data['news_video']->title,
			'description' => $data['news_video']['content'],
			'twitter_title' => $data['news_video']['title'],
			'image_' => $data['news_video']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);
		if (empty($data['news_video'])) {
			return redirect('home');
		}
		// echo "<pre>";

		// print_R($data);
		// exit;

		return view('front.video.view', $data);
	}

	public function submitForm(Request $request) {
		$data = $request->all();
		// echo '<pre>';print_r($data);echo '</pre>';die;
		// $BlogComment = BlogComment::findOrNew($id);
		$rules = array(
			'comment' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			// $matchingRecords = NationalEvent::where('url_slug', trim($this->clean($request->title)))->get();
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
			// $BlogComment->comment = $request->comment;
			// $BlogComment->blog_id = $request->blog_id;
			// $BlogComment->user_id = Auth::user()->id;

			// $BlogComment->save();

			\Session::flash('success', 'Comment Saved Successfully.');
			$json['location'] = route('front.blog');
		}

		return $json;
	}
}
