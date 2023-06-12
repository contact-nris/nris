<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplesComment extends Model {
	public $table = 'temples_comment';
	protected $casts = [];
	protected $appends = [];

	public function child() {
		return $this->hasMany('App\TemplesComment', 'reply_id', 'id')
			->selectRaw('temples_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

}
