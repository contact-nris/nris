<?php

namespace App\Http\Controllers;

use App\NewsVideo;
use Illuminate\Http\Request;

class NewsVideoController extends Controller {

	public function view(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$data['news_video'] = NewsVideo::selectRaw('news_videos.*')
			->where('id', $id)->firstOrFail();

		$data['more_videos'] = NewsVideo::where('id', '!=', $id)->orderBy("id", "Desc")->limit(8)->get();

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
		$data = array_merge($data,$data['meta_tags']);
		if (empty($data['news_video'])) {
			return redirect('home');
		}

		return view('front.newsvideo.view', $data);
	}

}
