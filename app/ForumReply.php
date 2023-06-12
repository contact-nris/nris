<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model {
	public $table = 'forums_reply';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public function child() {
		return $this->hasMany('App\ForumReply', 'reply_id', 'id')
			->selectRaw('forums_reply.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}
}
