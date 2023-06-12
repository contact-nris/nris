<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PubComment extends Model {
	public $table = 'pubs_comment';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function child() {
		return $this->hasMany('App\PubComment', 'reply_id', 'id')
			->selectRaw('pubs_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? url('upload/casinos/' . $this->image) : '';
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
		return slug($this->pub_name) . '-' . $this->id;
	}
}
