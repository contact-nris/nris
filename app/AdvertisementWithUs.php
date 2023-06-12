<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertisementWithUs extends Model {
	public $table = 'advertise_with_us';
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
				$images[] = assets_url('upload/img/' . $img);
			}
		}

		return $images;
	}
}
