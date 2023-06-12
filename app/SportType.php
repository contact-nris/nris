<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SportType extends Model {
	public $table = 'sports_type';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
