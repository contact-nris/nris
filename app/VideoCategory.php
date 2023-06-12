<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model {
	public $table = 'videos_categoires';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	// small_image_name
	public function getSmallImageAttribute() {
		return $this->image_name ? assets_url('https://www.nris.com/stuff/images//video-category/' . $this->image_name) : '';
		return $this->image_name ? assets_url('upload/video/' . $this->image_name) : '';
	}
}
