<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyPartnerCategory extends Model {
	protected $casts = [];
	protected $appends = [];

	// table
	protected $table = 'mypartner_categories';

	public function remove() {
		$this->delete();
	}
}
