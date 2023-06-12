<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uni_Studenttalk extends Model {
	public $table = 'university_student_talk';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	// public function getImageUrlAttribute(){
	//     return $this->image ? url('upload/casinos/'.$this->image) : '';
	// }

	public static function StuTalk($limit = 10, $req_state = "") {
		$studata = array();

		$query = self::selectRaw('university_student_talk.*,states.name as state_name,student_talk.uni_name as u_name')
			->leftJoin('states', 'states.code', 'university_student_talk.state_code')
			->leftJoin('student_talk', 'student_talk.id', 'university_student_talk.university_id')
			->where('university_student_talk.type', 'Accommodation')
			->orderBy('university_student_talk.created_at', 'desc');

		if ($req_state) {
			$query->whereRaw("FIND_IN_SET('" . $req_state['code'] . "', university_student_talk.state_code)");
		}
		$query->limit($limit);

		$studata['accommodation'] = $query->get();

		$query = self::selectRaw('university_student_talk.*,states.name as state_name,student_talk.uni_name as u_name')
			->leftJoin('states', 'states.code', 'university_student_talk.state_code')
			->leftJoin('student_talk', 'student_talk.id', 'university_student_talk.university_id')
			->where('university_student_talk.type', 'CampusJobs')
			->orderBy('university_student_talk.created_at', 'desc');

		if ($req_state) {
			$query->whereRaw("FIND_IN_SET('" . $req_state['code'] . "', university_student_talk.state_code)");
		}
		$query->limit($limit);

		$studata['campusJobs'] = $query->get();

		$query = self::selectRaw('university_student_talk.*,states.name as state_name,student_talk.uni_name as u_name')
			->leftJoin('states', 'states.code', 'university_student_talk.state_code')
			->leftJoin('student_talk', 'student_talk.id', 'university_student_talk.university_id')
			->whereIn('university_student_talk.type', ['ChangeGroups', 'OtherTopics'])
			->orderBy('university_student_talk.created_at', 'desc');

		if ($req_state) {
			$query->whereRaw("FIND_IN_SET('" . $req_state['code'] . "', university_student_talk.state_code)");
		}
		$query->limit($limit);

		$studata['other'] = $query->get();

		return $studata;
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
		return \Illuminate\Support\Str::limit(strip_tags($this->message), 200);
	}
}
