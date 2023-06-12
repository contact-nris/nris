<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GaragesaleComment extends Model {
	public $table = 'garagesale_comment';
	protected $casts = [];
	protected $appends = [];

	public function child() {
		return $this->hasMany('App\GaragesaleComment', 'reply_id', 'id')
			->selectRaw('garagesale_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}
}
