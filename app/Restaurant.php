<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Restaurant extends Model {

	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public static function count_c($filter = array()) {
		$query = self::leftJoin('states', 'states.code', 'restaurants.state_code')->where('states.country_id', country_id());

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(restaurants.created_at) >= "' . $filter['date_from'] . '" AND DATE(restaurants.created_at) <= "' . $filter['date_to'] . '"');
		}
		return $query->count();

		return self::leftJoin('states', 'states.code', 'restaurants.state_code')->where('states.country_id', country_id())->count();
	}

	public function getSlugAttribute($path = false) {

		return slug($this->name);

	}

	public function getImageUrlAttribute() {
		return $this->image ? asset('upload/restaurants/' . $this->image) : '';
	}

	//for home page
	public static function RestaurantData($limit = 10, $req_state = "",$id) {
		DB::getQueryLog();
// 		echo $id;
			$a = get_states_id($id);
// 		 print_r($a);
// 		  exit;
		$query = self::selectRaw('restaurants.name as title,restaurants.id,restaurants.image,cities.name as city_name,states.name as state_name')
			->leftJoin('states', 'states.code', 'restaurants.state_code')
			->leftJoin('cities', 'cities.id', 'restaurants.city_id')
			->leftJoin('restaurants_type', 'restaurants_type.id', 'restaurants.restaurant_type')
			->orderBy('restaurants.total_views', 'desc');
		if ($req_state) {

			if (isset($req_state['code'])) {
				$query->whereRaw("FIND_IN_SET('" . $req_state['code'] . "', restaurants.state_code)");
			} else {
				$query->whereRaw("FIND_IN_SET('" . explode(",", $a[0]) . "', restaurants.state_code)");
			}
		} else {
		
			$query->whereIn('restaurants.state_code', explode(",", $a[0]));
		}

		$a = $query->limit($limit)->get();

		$b = DB::getQueryLog();

		//  print_r($b);

		return $a;
	}

	public function getSlugWithPathAttribute() {
		if (strlen($this->title) > 0) {
			return route('restaurants.view', slug($this->title));
		} else {
			return route('restaurants.view', slug($this->title));
		}}

	public function getShortTitleAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->name), 10, '...');
	}

}
