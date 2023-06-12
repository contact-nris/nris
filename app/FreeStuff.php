<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreeStuff extends Model {
	public $table = 'post_free_stuff';
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
				// $images[] = assets_url('https://www.nris.com/stuff/upload/free_stuff/'.$img);
				$images[$img] = $img;
			}
		}

		foreach ($images as $key => &$value) {
			if (file_exists(public_path('upload/free_stuff/' . $value))) {
				$value = assets_url('upload/free_stuff/' . $value);
			} else {
				$value = asset('upload/commen_img/free-stuff.jpg');
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

	public function getShortTitleAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->title), 50, '...');
	}
	public function getShortDescAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->message), 120, '...');
	}
}
