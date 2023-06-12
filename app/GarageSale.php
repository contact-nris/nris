<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GarageSale extends Model {
	public $table = 'post_free_garagesale';
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
				// $images[] = assets_url('https://www.nris.com/stuff/upload/garagesale/'.$img);
				$images[$img] = $img;
			}
		}

		foreach ($images as $key => &$value) {
			if (file_exists(public_path('upload/garagesale/' . $value))) {
				$value = assets_url('upload/garagesale/' . $value);
			} else {
				$value = asset('upload/commen_img/gradge-sale.png') . $value;
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
}
