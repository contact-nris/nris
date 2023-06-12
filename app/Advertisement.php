<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model {
	public $table = 'advertisements';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? assets_url('upload/myadimg/' . $this->image) : '';
	}
}
