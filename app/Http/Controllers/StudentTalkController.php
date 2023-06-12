<?php

namespace App\Http\Controllers;

use App\StudenttalkComment;
use App\Uni_Studenttalk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class StudentTalkController extends Controller {

	public function view(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$query = Uni_Studenttalk::selectRaw('university_student_talk.*,states.country_id,CONCAT(users.first_name," ",users.last_name) as user,users.mobile')
			->leftJoin('states', 'states.code', 'university_student_talk.state_code')
			->leftJoin('users', 'users.id', 'university_student_talk.user_id')
			->where('university_student_talk.id', $id);

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		// $query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', university_student_talk.state_code)");
			$place_name = $request->req_state['name'];
		}

		$data['student'] = $query->firstOrFail();

		$data['comments'] = StudenttalkComment::selectRaw('student_talk_comment.*, users.profile_photo, CONCAT(users.first_name," ", users.last_name) AS user')->leftJoin("users", "users.id", "user_id")->where('talk_id', $data['student']->id)->where('reply_id', 0)->orderBy('created_at', 'desc')->paginate(5);

		$data['meta_tags'] = array(
			'meta_title' => $data['student']->meta_title,
			'meta_description' => $data['student']->meta_description,
			'meta_keywords' => $data['student']->meta_keywords,
			'title' => $data['student']->title,
			'description' => $data['student']['message'],
			'twitter_title' => $data['student']['title'],
			'image_' => $data['student']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);
		// echo "<pre>";
		// print_r($data);
		//  echo "</pre>";
		// exit;

		return view('front.studentTalk.view', $data);
	}

	public function submitForm(Request $request, StudenttalkComment $comment) {
		$data = $request->all();

		$rules = array(
			'comment' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$student = new StudenttalkComment();
			$student->comment = $request->comment;
			$student->reply_id = $comment->id ? $comment->id : 0;
			$student->talk_id = $request->model_id;
			$student->user_id = Auth::user()->id;
			$student->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'Student\'Talk Ad',
				'name' => Auth::user()->name,
				'sub_type' => $comment->id ? 'Reply' : 'Comment',
			);
			sendCommentAlert($mail_data);

			\Session::flash('success', 'Student Talk Comment Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}
}