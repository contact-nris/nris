<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model {
	public $table = 'forums_categoires';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? assets_url('upload/forum/' . $this->image) : '';
	}
}
