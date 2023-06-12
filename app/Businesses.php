<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Businesses extends Model {
	public $table = 'participating_businesses';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public static function count_c($filter = array()) {
		$query = self::selectRaw('count(id) as total');

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(created_at) >= "' . $filter['date_from'] . '" AND DATE(created_at) <= "' . $filter['date_to'] . '"');
		}

		return $query->first()->total;
	}
}
