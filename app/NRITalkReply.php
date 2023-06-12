<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NRITalkReply extends Model {

	public $table = 'nris_talk_reply';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public function child() {
		return $this->hasMany('App\NRITalkReply', 'reply_id', 'id')
			->selectRaw('nris_talk_reply.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "nris_talk_reply.user_id")
			->orderBy('id', 'desc');
	}
}
