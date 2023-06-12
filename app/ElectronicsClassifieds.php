<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectronicsClassifieds extends Model {
	public $table = 'post_free_electronics';
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
				// $images[] = assets_url('https://www.nris.com/stuff/upload/electronics/'.$img);
				$images[$img] = $img;
			}
		}

		foreach ($images as $key => &$value) {
			if (file_exists(public_path('upload/electronics/' . $value))) {
				$value = assets_url('upload/electronics/' . $value);
			} else {
				$value = asset('upload/commen_img/electronics.png');
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
}
