<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model {
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
