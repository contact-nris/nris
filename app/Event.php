<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {
	public $table = 'events';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? asset('upload/events/' . $this->image) : '';
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}

	public static function count_c($filter = array()) {
		$query = self::leftJoin('states', 'states.code', 'events.state_code')->where('states.country_id', country_id());

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(events.created_at) >= "' . $filter['date_from'] . '" AND DATE(events.created_at) <= "' . $filter['date_to'] . '"');
		}
		return $query->count();

		return self::leftJoin('states', 'states.code', 'events.state_code')->where('states.country_id', country_id())->count();
	}

	public function getShortTitleAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->title), 28, '...');
	}
}
