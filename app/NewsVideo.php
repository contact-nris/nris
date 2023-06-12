<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsVideo extends Model {
	public $table = 'news_videos';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public static function count_c($filter = array()) {
		$query = self::selectRaw('count(id) as total');

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(created_at) >= "' . $filter['date_from'] . '" AND DATE(created_at) <= "' . $filter['date_to'] . '"');
		}

		return $query->first()->total;
	}

	public static function NewsVideoData($limit = 10) {
		return self::selectRaw('news_videos.*')
			->orderBy('news_videos.created_at', 'desc')
			->limit($limit)
			->get();
	}

	public function getImageUrlAttribute() {
		return $this->image ? assets_url('upload/news_videos/' . $this->image) : '';
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}

	public function getYoutubeThumbAttribute($value) {
		// get thumb url from youtube url
		$url = parse_url($this->video_link);
		if(isset($url['query'])){
		$query = $url['query'];
		parse_str($query, $params);
		return 'http://img.youtube.com/vi/' . $params['v'] . '/0.jpg';
		}else{
		    return 'http://img.youtube.com/vi/abc/0.jpg';
		}
	}

	public function getEmbadedVideoLinkAttribute() {
		$url = parse_url($this->video_link);
			if(isset($url['query'])){
		$query = $url['query'];
		parse_str($query, $params);
		return 'https://www.youtube.com/embed/' . $params['v'] . '?rel=0&amp;showinfo=0';
			}else{
			return 'https://www.youtube.com/embed/0?rel=0&amp;showinfo=0';	    
			}
	}

}
