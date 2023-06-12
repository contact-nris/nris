<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroceriesComment extends Model {
	public $table = 'groceries_comment';
	protected $casts = [];
	protected $appends = ['images'];

	public function child() {
		return $this->hasMany('App\GroceriesComment', 'reply_id', 'id')
			->selectRaw('groceries_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}

}
