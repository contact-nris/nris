<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationTeachingComment extends Model {
	public $table = 'education_teaching_comment';
	protected $casts = [];
	protected $appends = ['images'];

	public function remove() {
		$this->delete();
	}

	public function child() {
		return $this->hasMany('App\EducationTeachingComment', 'reply_id', 'id')->selectRaw('education_teaching_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")->orderBy('id', 'desc');
	}

	public function getImagesAttribute() {
		$images = [];
		for ($i = 1; $i <= 10; $i++) {
			$img = $this->{'image' . $i};
			if ($img) {
				$images[] = assets_url('upload/education/' . $img);
			}
		}

		return $images;
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}

	public function getShortDescAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->message), 80, '...');
	}
}
