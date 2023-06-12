<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheaterType extends Model {
	public $table = 'theaters_type';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
