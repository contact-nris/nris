<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempleType extends Model {
	public $table = 'temples_type';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
