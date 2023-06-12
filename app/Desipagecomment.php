<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Desipagecomment extends Model {
	public $table = 'desi_pages_comment';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function child() {
		return $this->hasMany('App\Desipagecomment', 'reply_id', 'id')->orderBy('id', 'desc');
	}

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? url('upload/casinos/' . $this->image) : '';
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}

}
