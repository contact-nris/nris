<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyPartner extends Model {
	public $table = 'post_free_mypartner';
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
				$images[$img] = $img;
			}
		}

		foreach ($images as $key => &$value) {
			$value = assets_url('upload/mypartner/' . $value);
		}
		// foreach ($images as $key => &$value) {
		//     if (file_exists(public_path('upload/mypartner/' . $value))) {
		//         $value = assets_url('upload/mypartner/' . $value);
		//     } else {
		//         $value = 'https://www.nris.com/stuff/upload/mypartner/' . $value;
		//     }
		// }
		return $images;
	}

	public function getImageUrlAttribute() {
		return assets_url('https://www.nris.com/stuff/upload/mypartner/' . $this->image1);
	}

	public function getSlugAttribute() {
		return slug($this->title);
	}

	public function getShortTitleAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->title), 50, '...');
	}
	public function getShortDescAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->message), 120, '...');
	}
}