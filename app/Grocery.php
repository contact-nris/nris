<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grocery extends Model {

	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? url('https://www.nris.com/upload/groceries/' . $this->image) : '';
	}

	public static function count_c($filter = array()) {
		$query = self::leftJoin('states', 'states.code', 'groceries.state_code')->where('states.country_id', country_id());

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(groceries.created_at) >= "' . $filter['date_from'] . '" AND DATE(groceries.created_at) <= "' . $filter['date_to'] . '"');
		}
		return $query->count();

		return self::leftJoin('states', 'states.code', 'groceries.state_code')->where('states.country_id', country_id())->count();
	}

	public function getSlugAttribute() {

		return slug($this->name);

	}
	public function getShortTitleAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->name), 28, '...');
	}

	public static function GroceryData($limit = 10, $req_state = "") {
		if ($req_state && $req_state['code']) {
			$query = self::where(array('status' => 1, 'state_code' => $req_state['code']))->orderBy('created_at', 'desc')->limit($limit);
			return $query->get();
		}
		return [];
	}

}
