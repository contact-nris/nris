<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealestateCategory extends Model {
	public $table = 'realestate_categoires';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
