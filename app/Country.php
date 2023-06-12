<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public function state_count() {
		return State::where('country_id', $this->id)->count();
	}
	public function state_city() {
		return City::leftJoin('states', 'cities.state_code', 'states.code')->where('states.country_id', $this->id)->count();
	}

	public function getImageUrlAttribute() {
		return $this->image ? assets_url('upload/country/' . $this->image) : '';
	}
}
