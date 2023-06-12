<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model {
	public $table = 'events_category';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
