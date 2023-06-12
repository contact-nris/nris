<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobRoles extends Model {
	public $table = 'job_role';
	protected $casts = [];

	public function remove() {
		$this->delete();
	}
}
