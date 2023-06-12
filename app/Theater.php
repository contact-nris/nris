<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theater extends Model {
	public $table = 'theaters';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? asset('upload/theaters/' . $this->image) : '';
	}

	public function comments() {
		return $this->hasMany(TheaterComment::class, 'theater_id');
	}

	public static function count_c($filter = array()) {
		$query = self::leftJoin('states', 'states.code', 'theaters.state_code')->where('states.country_id', country_id());

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(theaters.created_at) >= "' . $filter['date_from'] . '" AND DATE(theaters.created_at) <= "' . $filter['date_to'] . '"');
		}
		return $query->count();

		return self::leftJoin('states', 'states.code', 'theaters.state_code')->where('states.country_id', country_id())->count();
	}

	public function getSlugAttribute() {
		return slug($this->name . '-' . $this->id);
	}
}
