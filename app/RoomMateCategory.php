<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomMateCategory extends Model {
	public $table = 'room_mate_categoires';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}
}
