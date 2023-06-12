<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model {
	public $table = 'videos';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public function video_like() {
		return $this->hasMany(VideoLike::class, 'video_id')->where('status', '1');
	}
	public function video_dislike() {
		return $this->hasMany(VideoLike::class, 'video_id')->where('status', '0');
	}

	// public function getImageUrlAttribute(){
	//     return 'https://www.nris.com/sumd2014/upload/blog/19685_Casino%20-%20Blackjack-players_e0b0fbf5-840f-404d-bba5-bee0203c8c43.jpg';
	//     return $this->image ? assets_url('upload/blog/' . $this->image) : '';
	// }

	public function getYoutubeThumbAttribute() {
		return 'https://img.youtube.com/vi/' . $this->video_id . '/0.jpg';
	}

	public function getVideoUrlAttribute() {
		return 'https://www.youtube.com/embed/' . $this->video_id . '?autoplay=1';
	}
}
