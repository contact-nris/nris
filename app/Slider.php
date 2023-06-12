<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model {
	protected $casts = [
		'slides' => 'array',
	];
	protected $appends = [
		'images',
	];

	public function remove() {
		$this->delete();
	}

	public function getImagesAttribute() {
		$images = [];

		if (is_array($this->slides)) {
			foreach ($this->slides as $key => $slide) {

				if ($slide) {
					$images[] = assets_url('upload/sliders/' . $slide);
				}
			}
		}

		return $images;
	}
}
