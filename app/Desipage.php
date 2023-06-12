<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Desipage extends Model {
	public $table = 'desi_pages';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? 'https://www.nris.com/upload/mypartner/' . $this->image : '';
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}

	public function getShortTitleAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->title), 28, '...');
	}
}
