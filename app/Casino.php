<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Casino extends Model {
	public $table = 'casinos';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? asset('upload/casinos/' . $this->image) : '';
	}

	public function getSlugAttribute() {
		return slug($this->name);
	}

	public static function count_c($filter = array()) {
		$query = self::leftJoin('states', 'states.code', 'casinos.state_code')->where('states.country_id', country_id());

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(casinos.created_at) >= "' . $filter['date_from'] . '" AND DATE(casinos.created_at) <= "' . $filter['date_to'] . '"');
		}
		return $query->count();

		return self::leftJoin('states', 'states.code', 'casinos.state_code')->where('states.country_id', country_id())->count();
	}

	//for home page
	public static function CasinoData($limit = 10, $req_state = "",$id) {
		$query = self::selectRaw('casinos.name as title, casinos.id, casinos.image, cities.name as city_name, states.name as state_name,meta_title')
			->leftJoin(
				'states',
				'states.code',
				'casinos.state_code'
			)
			->leftJoin(
				'cities',
				'cities.id',
				'casinos.city_id'
			)
			->orderBy(
				'casinos.total_views',
				'DESC'
			);
		if ($req_state) {

			if (isset($req_state['code'])) {
				$query->whereRaw("FIND_IN_SET('" . $req_state['code'] . "', casinos.state_code)");
			} else {
				$query->whereRaw("FIND_IN_SET('" . $req_state . "', casinos.state_code)");
			}
			//$query->whereRaw("FIND_IN_SET('" . $req_state['code'] . "', casinos.state_code)");
		} else {
			$a = get_states_id($id);
			$query->whereIn('casinos.state_code', explode(",", $a[0]));
		}
		return $query->limit($limit)->get();
	}

	public function getSlugWithPathAttribute() {
		return url(route('casinos.view', slug($this->title)));

	}
}