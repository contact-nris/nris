<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temple extends Model {
	public $table = 'temples';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function comments() {
		return $this->hasMany(TemplesComment::class, 'temple_id');
	}

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? asset('upload/temples/' . $this->image) : '';
	}

	public static function count_c($filter = array()) {
		$query = self::leftJoin('states', 'states.code', 'temples.state_code')->where('states.country_id', country_id());

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(temples.created_at) >= "' . $filter['date_from'] . '" AND DATE(temples.created_at) <= "' . $filter['date_to'] . '"');
		}
		return $query->count();
	}

	public function getSlugAttribute() {

		return slug($this->name);

	}

	//for home page
	public static function TempleData($limit = 10, $req_state = "",$id) {
		$query = self::selectRaw('temples.name as title, temples.id, temples.image, cities.name as city_name, states.name as state_name,meta_title')
			->leftJoin('states', 'states.code', 'temples.state_code')
			->leftJoin('cities', 'cities.id', 'temples.city_id')
			->leftJoin('temples_type', 'temples_type.id', 'temples.temple_type')
			->orderBy(
				'temples.total_views',
				'desc'
			);
		if ($req_state) {

			if (isset($req_state['code'])) {
				$query->whereRaw("FIND_IN_SET('" . $req_state['code'] . "', temples.state_code)");
			} else {
				$query->whereRaw("FIND_IN_SET('" . $req_state . "', temples.state_code)");
			}
		} else {
			$a = get_states_id($id);
			$query->whereIn('temples.state_code', explode(",", $a[0]));
		}
		return $query->limit($limit)->get();
	}

	public function getSlugWithPathAttribute() {

		return url(route('front.temples.view', slug($this->title)));

	}

	public function getShortTitleAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->name), 28, '...');
	}
}
