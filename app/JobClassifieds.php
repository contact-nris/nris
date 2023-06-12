<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobClassifieds extends Model {
	public $table = 'post_free_job';
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
				// $images[] = assets_url('https://www.nris.com/stuff/images/icons/'.$img);
			}
		}

		foreach ($images as $key => &$value) {
			if (file_exists(public_path('upload/job/' . $value))) {
				$value = assets_url('upload/job/' . $value);
			} else {
				$value = asset('upload/commen_img/jobs.png');
			}
		}

		return $images;
	}

	public static function count_c($filter = array()) {
		$query = self::leftJoin('states', 'states.code', 'post_free_job.states')->where('states.country_id', country_id());

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(post_free_job.created_at) >= "' . $filter['date_from'] . '" AND DATE(post_free_job.created_at) <= "' . $filter['date_to'] . '"');
		}
		return $query->count();

		return self::leftJoin('states', 'states.code', 'post_free_job.states')->where('states.country_id', country_id())->count();
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
