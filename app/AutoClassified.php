<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutoClassified extends Model {
	public $table = 'auto_classifieds';
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
				// $images[] = assets_url('https://www.nris.com/stuff/upload/auto/'.$img);
				$images[$img] = $img;
			}
		}

		foreach ($images as $key => &$value) {
			if (file_exists(public_path('upload/auto/' . $value))) {
				$value = assets_url('upload/auto/' . $value);
			} else {
				$value = asset('upload/commen_img/others.png');
			}
		}

		return $images;
	}

	public static function count_c($filter = array()) {
		$query = self::leftJoin('states', 'states.code', 'auto_classifieds.states')->where('states.country_id', country_id());

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(auto_classifieds.created_at) >= "' . $filter['date_from'] . '" AND DATE(auto_classifieds.created_at) <= "' . $filter['date_to'] . '"');
		}
		return $query->count();

		return self::leftJoin('states', 'states.code', 'auto_classifieds.states')->where('states.country_id', country_id())->count();
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
