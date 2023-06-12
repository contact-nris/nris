<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model {
	public $table = 'blogs_categoires';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
