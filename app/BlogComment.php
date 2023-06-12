<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model {
	public $table = 'blogs_comment';
	protected $casts = [];
	protected $appends = [];

	public function child() {
		return $this->hasMany('App\BlogComment', 'reply_id', 'id')
			->selectRaw('blogs_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}
}
