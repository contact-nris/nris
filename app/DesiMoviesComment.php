<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesiMoviesComment extends Model {
	public $table = 'desimovies_comment';
	protected $casts = [];
	protected $appends = [];

	public function child() {
		return $this->hasMany('App\DesiMoviesComment', 'reply_id', 'id')
			->selectRaw('desimovies_comment.*, users.profile_photo, CONCAT( users.first_name," ", users.last_name) AS user')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}
}