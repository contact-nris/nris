<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BabySittingComment extends Model {
	public $table = 'baby_sitting_comment';
	protected $casts = [];
	protected $appends = [];

	public function child() {
		return $this->hasMany('App\BabySittingComment', 'reply_id', 'id')
			->selectRaw('baby_sitting_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}
}