<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudenttalkComment extends Model {
	public $table = 'student_talk_comment';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function child() {
		return $this->hasMany('App\StudenttalkComment', 'reply_id', 'id')
			->selectRaw('student_talk_comment.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->orderBy('id', 'desc');
	}

	public function getSlugAttribute() {
		return slug($this->details . '-' . $this->id);
	}

	public static function StuTalk($limit = 10) {
		$query = self::selectRaw('student_talk.*,states.name as state_name')
			->leftJoin('states', 'states.code', 'student_talk.state_code')
			->where('student_talk.status', '1')
			->orderBy('student_talk.created_at', 'desc')
			->limit($limit);

		return $query->get();
	}

	public function getShortDescAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->details), 50);
	}
}
