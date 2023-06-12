<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BabySittingClassified extends Model {
	public $table = 'post_free_baby_sitting';
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
				// $images[] = $temporary ?: assets_url('https://www.nris.com/stuff/upload/baby_sitting/'.$img);
				$images[$img] = $img;
			}
		}
		foreach ($images as $key => &$value) {
			if (file_exists(public_path('upload/babysitting/' . $value))) {
				$value = assets_url('upload/babysitting/' . $value);
			} else {
				$value = asset('upload/commen_img/baby_sitting.png');
			}
		}
		// foreach ($images as $key => &$value) {
		//     if (file_exists(public_path('upload/babysitting/' . $value))) {
		//         $value = assets_url('upload/babysitting/' . $value);
		//     } else {
		//         $value = 'https://www.nris.com/stuff/upload/baby_sitting/' . $value;
		//     }
		// }

		return $images;
	}

	public static function count_c($filter = array()) {
		$query = self::leftJoin('states', 'states.code', 'post_free_baby_sitting.state')->where('states.country_id', country_id());

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(post_free_baby_sitting.created_at) >= "' . $filter['date_from'] . '" AND DATE(post_free_baby_sitting.created_at) <= "' . $filter['date_to'] . '"');
		}
		return $query->count();

		return self::leftJoin('states', 'states.code', 'post_free_baby_sitting.state')->where('states.country_id', country_id())->count();
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
