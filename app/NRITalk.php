<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NRITalk extends Model {

	public $table = 'nris_talk';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public function comments() {
		return $this->hasMany(NRITalkReply::class, 'talk_id');
	}
	public function like_nris() {
		return $this->hasMany(NrisLIke::class, 'talk_id');
	}

	public static function count_c($filter = array()) {
		$query = self::selectRaw('count(id) as total');

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(created_at) >= "' . $filter['date_from'] . '" AND DATE(created_at) <= "' . $filter['date_to'] . '"');
		}

		return $query->first()->total;
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}
}
