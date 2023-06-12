<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarPoolComment extends Model {
	public $table = 'carpool_comment';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	// public function getImageUrlAttribute(){
	//     return $this->image ? assets_url('upload/batches/'.$this->image) : '';
	// }
}
