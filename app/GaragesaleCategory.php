<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GaragesaleCategory extends Model {
	public $table = 'garagesale_categoires';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
