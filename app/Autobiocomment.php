<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autobiocomment extends Model {
	public $table = 'auto_classifieds_bid';
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
				$images[] = assets_url('upload/education/' . $img);
			}
		}

		return $images;
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			if (strlen($this->title) > 0) {
				return slug($this->title . '-' . $this->id);
			} else {
				return slug($this->title . '-' . $this->id);
			}
		} else {
			return slug($this->title . '-' . $this->id);
		}

	}

	public function getShortDescAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->message), 80, '...');
	}
}
