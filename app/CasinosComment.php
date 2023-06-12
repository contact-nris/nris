<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CasinosComment extends Model {
	public $table = 'casinos_comment';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function child() {
		return $this->hasMany('App\CasinosComment', 'reply_id', 'id')
			->selectRaw('casinos_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? url('upload/casinos/' . $this->image) : '';
	}

	public function getSlugAttribute() {

		return slug($this->name . '-' . $this->id);

	}

	public static function count_c() {
		return self::leftJoin('states', 'states.code', 'casinos.state_code')->where('states.country_id', country_id())->count();
	}
}
