<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectronicComment extends Model {
	public $table = 'electronic_comments';
	protected $casts = [];
	protected $appends = [];

	public function child() {
		return $this->hasMany('App\ElectronicComment', 'reply_id', 'id')->selectRaw('electronic_comments.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}
}
