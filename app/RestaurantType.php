<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantType extends Model {

	public $table = 'restaurants_type';
	protected $casts = [];

	public function remove() {
		$this->delete();
	}
}
