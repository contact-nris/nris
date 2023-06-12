<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citymovie extends Model {
	public $table = 'city_movies';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? assets_url('upload/city_movies/' . $this->image) : assets_url('upload/city_movies/default _img.png');
	}

	public function getSlugAttribute() {

		return slug($this->name . '-' . $this->id);

	}
}
