<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingSource extends Model {
	public $table = 'movies_external_source';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
