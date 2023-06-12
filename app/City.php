<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model {
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public static function CityWithState() {
		$query = self::selectRaw('
                cities.id,
                cities.name,
                states.name as states_name
            ')
			->leftJoin('states', 'states.code', 'cities.state_code');

		return $query->get();
	}
}
