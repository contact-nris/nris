<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NationalBatchesComment extends Model {
	public $table = 'national_batches_comment';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function child() {
		return $this->hasMany('App\NationalBatchesComment', 'reply_id', 'id')
			->selectRaw('national_batches_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "national_batches_comment.user")
			->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}
}
