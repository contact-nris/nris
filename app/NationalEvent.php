<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NationalEvent extends Model {
	public $table = 'national_events';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function getSlugAttribute() {
		return slug($this->title);

		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}

	public function getImageUrlAttribute() {
		return $this->image ? asset('upload/national_events/' . $this->image) : '';
	}

	public function getShortTitleAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->title), 28, '...');
	}
}
