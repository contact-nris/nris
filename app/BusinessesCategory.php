<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessesCategory extends Model {
	public $table = 'participating_businesses_category';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
