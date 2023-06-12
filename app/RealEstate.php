<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealEstate extends Model {
	public $table = 'post_free_real_estate';
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
				// $images[$img] = assets_url('upload/realestate/'.$img);
				$images[$img] = $img;
			}
		}

		foreach ($images as $key => &$value) {
			if (file_exists(public_path('upload/realestate/' . $value))) {
				$value = assets_url('upload/realestate/' . $value);
			} else {
				$value = asset('upload/commen_img/real-estate.png');
			}
		}
		// foreach ($images as $key => &$value) {
		//     if(file_exists(public_path('upload/realestate/'.$value))){
		//         $value = assets_url('upload/realestate/'.$value);
		//     }else{
		//         $value = 'https://www.nris.com/stuff/upload/realestate/'.$value;
		//     }
		// }

		return $images;
	}

	public function getSlugAttribute() {
		return slug($this->title);
	}

	public function getShortDescAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->message), 80, '...');
	}

	public function getShortTitleAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->title), 50, '...');
	}

}
