<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationTeachingClassified extends Model {
	public $table = 'post_free_education';
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
				// $images[] = assets_url('upload/education/'.$img);
				$images[$img] = $img;
			}
		}

		foreach ($images as $key => &$value) {
			if (file_exists(public_path('upload/education/' . $value))) {
				$value = assets_url('upload/education/' . $value);
			} else {
				$value = asset('upload/commen_img/education.png');
			}
		}

		// foreach ($images as $key => &$value) {
		//     $value = assets_url('upload/education/' . $value);
		//     // } else {
		//     //     $value = 'https://www.nris.com/stuff/upload/auto/' . $value;
		//     // }
		// }

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
		return \Illuminate\Support\Str::limit(strip_tags($this->message), 80, '...');
	}

	public function getShortTitleAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->title), 50, '...');
	}
}
