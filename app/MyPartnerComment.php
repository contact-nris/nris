<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyPartnerComment extends Model {
	public $table = 'mypartner_comment';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}

	public function child() {
		return $this->hasMany('App\MyPartnerComment', 'reply_id', 'id')
			->selectRaw('mypartner_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}
}
