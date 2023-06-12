<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model {
	public $table = 'sports';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? url('https://www.nris.com/upload/sports/' . $this->image) : '';
	}

	public static function count_c($filter = array()) {
		$query = self::leftJoin('states', 'states.code', 'sports.state_code')->where('states.country_id', country_id());

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(sports.created_at) >= "' . $filter['date_from'] . '" AND DATE(sports.created_at) <= "' . $filter['date_to'] . '"');
		}
		return $query->count();

		return self::leftJoin('states', 'states.code', 'sports.state_code')->where('states.country_id', country_id())->count();
	}

	public function getSlugAttribute() {

		return slug($this->name . '-' . $this->id);

	}
}
