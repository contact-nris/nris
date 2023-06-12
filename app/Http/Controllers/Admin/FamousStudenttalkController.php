<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\State;
use App\Student_Talk;
use App\Uni_Studenttalk;
use Illuminate\Http\Request;
use Validator;

class FamousStudenttalkController extends Controller {
	public function index(Request $request) {
		$query = Student_Talk::selectRaw('student_talk.*,states.country_id')
			->leftJoin('states', 'states.code', 'student_talk.state_code')
			->where('states.country_id', country_id());

		if ($request->state_code) {
			$query->where('student_talk.state_code', $request->state_code);
		}

		if ($request->filter_name) {
			$query->where('student_talk.uni_name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate();

		return view('admin.famous.Studentstalk.index', $data);
	}

	public function studentTalkTopic(Request $request) {
		$query = Uni_Studenttalk::selectRaw('university_student_talk.*,student_talk.uni_name as university')
			->leftJoin('student_talk', 'student_talk.id', 'university_student_talk.university_id');

		if ($request->state_code) {
			$query->where('university_student_talk.state_code', $request->state_code);
		}

		if ($request->topic_type) {
			$query->where('university_student_talk.type', 'like', '%' . $request->topic_type . '%');
		}

		if ($request->filter_name) {
			$query->where('university_student_talk.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['accommodation'] = $query->orderBy('created_at', 'desc')->paginate();

		return view('admin.studentTalk_topic.uni_accommodation', $data);
	}

	public function topic_deleteItem(Request $request, $id) {
		$data = $request->all();
		$studentstalk_tipoc = Uni_Studenttalk::findOrNew($id);
		$studentstalk_tipoc->remove();

		\Session::flash('success', 'Student Talk Topic Deleted Successfully.');
		return redirect()->back();
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['states'] = State::all();
		$data['students_talk'] = Student_Talk::findOrNew($id);

		return view('admin.famous.Studentstalk.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Student_Talk::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$studentstalk = Student_Talk::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
			'state_code' => 'required',
			'details' => 'required',
			'email_id' => 'required',
			'status' => 'required',
		);

		if ($request->email_id) {
			$rules['email_id'] = 'email';
		}

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = Student_Talk::where('url_slug', trim($this->clean($request->name)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->name);
			} else {
				$new_title = $request->name;
			}

			if ($id > 0) {
				if (trim($request->name) != $studentstalk->name) {
					$studentstalk->name = $new_title;
					$studentstalk->url_slug = $this->clean($new_title);
				}} else {
				$studentstalk->name = $new_title;
				$studentstalk->url_slug = $this->clean($new_title);
			}
			$studentstalk->state_code = $request->state_code;
			$studentstalk->edu_field = $request->edu_name;
			$studentstalk->details = $request->details;
			$studentstalk->url = $request->url;
			$studentstalk->email_id = $request->email_id;
			$studentstalk->status = $request->status;
			$studentstalk->other_details = $request->other_details;
			$studentstalk->meta_title = $request->meta_title;
			$studentstalk->meta_description = $request->meta_description;
			$studentstalk->meta_keywords = $request->meta_keywords;
			// if($request->hasFile('image')){
			//     $studentstalk->image = uniqname() .'.'. $request->file('image')->guessExtension();
			//     $request->file('image')->move(public_path('upload/pubs'), $studentstalk->image);
			// }

			$studentstalk->save();
			\App\BusinessHour::sync($request->business_hours_type, $studentstalk->id, $request);

			\Session::flash('success', 'Student Data Saved Successfully.');
			$json['location'] = route('famous_studenttal.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$studentstalk = Student_Talk::findOrNew($id);
		$studentstalk->remove();

		\Session::flash('success', 'Student Deleted Successfully.');
		return redirect()->back();
	}
}
