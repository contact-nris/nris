<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobComment extends Model {
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public function child() {
		return $this->hasMany('App\JobComment', 'reply_id', 'id')
			->selectRaw('job_comments.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}
}
