<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PubType extends Model {
	public $table = 'pubs_type';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
