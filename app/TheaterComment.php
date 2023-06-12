<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheaterComment extends Model {
	protected $table = 'theaters_comment';
	protected $casts = [];
	protected $appends = ['images'];

	public function child() {
		return $this->hasMany('App\TheaterComment', 'reply_id', 'id')
			->selectRaw('theaters_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}
}
