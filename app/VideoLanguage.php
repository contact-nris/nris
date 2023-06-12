<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoLanguage extends Model {
	public $table = 'videos_languages';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
