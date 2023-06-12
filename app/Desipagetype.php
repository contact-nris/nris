<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Desipagetype extends Model {
	public $table = 'desi_pages_cat';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
