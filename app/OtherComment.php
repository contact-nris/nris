<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherComment extends Model {
	public $table = 'other_comments';
	protected $casts = [];
	protected $appends = [];

	public function child() {
		return $this->hasMany('App\OtherComment', 'reply_id', 'id')
			->selectRaw('other_comments.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}
}
