<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NRICard extends Model {
	public $table = 'nris_card';
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

	// image
	public function getImageUrlAttribute() {
		return $this->image ? asset('upload/nricard/' . $this->image) : '';
	}
}
