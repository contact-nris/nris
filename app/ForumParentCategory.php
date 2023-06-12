<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumParentCategory extends Model {
	public $table = 'forums_parent_categoires';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
