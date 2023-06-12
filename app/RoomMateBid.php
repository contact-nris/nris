<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomMateBid extends Model {
	public $table = 'roommates_bid';
	protected $casts = [];
	public function remove() {
		$this->delete();
	}

	public function getImagesAttribute() {
		$images = [];
		for ($i = 1; $i <= 10; $i++) {
			$img = $this->{'image' . $i};
			if ($img) {
				// $images[] = assets_url('https://www.nris.com/stuff/upload/roommates/'.$img);
				$images[] = $img;
			}
		}
		foreach ($images as $key => &$value) {
			$value = 'https://www.nris.com/stuff/upload/roommates/' . $value;
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
}