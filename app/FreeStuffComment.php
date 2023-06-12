<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreeStuffComment extends Model {
	public $table = 'free_stuff_comment';
	protected $casts = [];
	protected $appends = [];

	public function child() {
		return $this->hasMany('App\FreeStuffComment', 'reply_id', 'id')
			->selectRaw('free_stuff_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}
}
