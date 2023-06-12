<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pub extends Model {
	public $table = 'pubs';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function comments() {
		return $this->hasMany(PubComment::class, 'pub_id');
	}

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? asset('upload/pubs/' . $this->image) : '';
	}

	public static function count_c($filter = array()) {
		$query = self::leftJoin('states', 'states.code', 'pubs.state_code')->where('states.country_id', country_id());

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(pubs.created_at) >= "' . $filter['date_from'] . '" AND DATE(pubs.created_at) <= "' . $filter['date_to'] . '"');
		}
		return $query->count();

		return self::leftJoin('states', 'states.code', 'pubs.state_code')->where('states.country_id', country_id())->count();
	}

	public function getSlugAttribute() {
		return slug($this->pub_name);
	}

	//for home page
	public static function PubData($limit = 10, $req_state = "",$id) {
		$query = self::selectRaw('pubs.pub_name as title,pubs.id,pubs.image,cities.name as city_name,states.name as state_name, meta_title')
			->leftJoin(
				'states',
				'states.code',
				'pubs.state_code'
			)
			->leftJoin(
				'cities',
				'cities.id',
				'pubs.city_id'
			)
			->leftJoin(
				'pubs_type',
				'pubs_type.id',
				'pubs.pub_type'
			)
			->orderBy(
				'pubs.total_views',
				'desc'
			);
		if ($req_state) {
			// $query->whereRaw("FIND_IN_SET('" . $req_state['code'] . "', pubs.state_code)");

			if (isset($req_state['code'])) {
				if (isset($req_state['code'])) {
					$query->whereRaw("FIND_IN_SET('" . $req_state['code'] . "', pubs.state_code)");
				} else {
					$query->whereRaw("FIND_IN_SET('" . $req_state . "', pubs.state_code)");
				}

			} else {
				$query->whereRaw("FIND_IN_SET('" . $req_state . "', pubs.state_code)");
			}

		} else {
			$a = get_states_id($id);
			$query->whereIn('pubs.state_code', explode(",", $a[0]));
		}

		return $query->limit($limit)->get();
	}

	public function getSlugWithPathAttribute() {

		return url(route('front.pubs.view', slug($this->title)));

	}

	public function getShortTitleAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->pub_name), 28, '...');
	}
}