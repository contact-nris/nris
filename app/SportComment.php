<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SportComment extends Model {
	public $table = 'sports_comment';
	protected $casts = [];
	protected $appends = ['images'];

	public function child() {
		return $this->hasMany('App\SportComment', 'reply_id', 'id')->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}
}
