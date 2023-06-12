<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomMate extends Model {
	public $table = 'post_free_roommates';
	protected $casts = [];
	protected $appends = ['images'];

	public function remove() {
		$this->delete();
	}

	public function getImagesAttribute() {
		$images = [];
		for ($i = 1; $i <= 10; $i++) {
			$img = $this->{'image' . $i};
			if ($img) {
				// $images[] = assets_url('https://www.nris.com/stuff/upload/roommates/'.$img);
				$images[$img] = $img;
			}
		}

		foreach ($images as $key => &$value) {
			if (file_exists(public_path('upload/roommates/' . $value))) {
				$value = assets_url('upload/roommates/' . $value);
			} else {
				$value = asset('upload/commen_img/roommates.png');
			}
		}
		return $images;
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}
	public function getShortDescAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->message), 120, '...');
	}
	public function getShortTitleAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->title), 50, '...');
	}
}