<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batchescategory extends Model {
	public $table = 'batches_categories';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
