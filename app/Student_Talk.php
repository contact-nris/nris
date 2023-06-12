<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_Talk extends Model {
	public $table = 'student_talk';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}

	public function getUniSlugAttribute() {
		return slug($this->u_name . '-' . $this->id);
	}

	public function getShortDescAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->details), 100);
	}

}
