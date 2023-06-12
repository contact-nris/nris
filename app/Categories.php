<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model {
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

}
