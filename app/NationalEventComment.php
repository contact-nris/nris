<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NationalEventComment extends Model {
	public $table = 'events_comment';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function child() {
		return $this->hasMany('App\NationalEventComment', 'reply_id', 'id')
			->selectRaw('events_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

	// public function getImageUrlAttribute(){
	//     return $this->image ? url('upload/casinos/'.$this->image) : '';
	// }

}
