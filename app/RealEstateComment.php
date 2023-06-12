<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealEstateComment extends Model {
	public $table = 'realestate_comments';
	protected $casts = [];
	protected $appends = [];

	public function child() {
		return $this->hasMany('App\RealEstateComment', 'reply_id', 'id')
			->selectRaw('realestate_comments.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

}
