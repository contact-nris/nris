<?php

namespace App\Http\Controllers;

use App\State;
use App\Student_Talk;
use App\Uni_Studenttalk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AddUniversityController extends Controller {

	public $meta_tags = array(
		'title' => 'Add University',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Add University and stay updated with the latest posts.',
		'twitter_title' => 'Add University',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);

	public function index(Request $request, $slug = '') {
		$query = Student_Talk::selectRaw('student_talk.*,states.name as states_name')
			->leftJoin('states', 'states.code', 'student_talk.state_code')
			->where(array('student_talk.status' => 1));

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', student_talk.state_code)");
			});
		}

		if ($request->filter_name) {
			$query->where('student_talk.uni_name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->orderBy('created_at', 'desc')->paginate(20);
		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);

		return view('front.adduniversity.list', $data);
	}

	public function view(Request $request, $id) {
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';

		$data['university'] = Uni_Studenttalk::selectRaw('university_student_talk.*,student_talk.uni_name')
			->leftJoin('student_talk', 'student_talk.id', 'university_student_talk.university_id')
			->where('student_talk.id', base64_decode($id))->first();

		$data['accommodation'] = Uni_Studenttalk::where('type', 'like', '%accommodation%')->where('university_id', base64_decode($id))->orderBy('created_at', 'desc')->limit(10)->get();
		$data['campusJobs'] = Uni_Studenttalk::where('type', 'like', '%CampusJobs%')->where('university_id', base64_decode($id))->orderBy('created_at', 'desc')->limit(10)->get();
		$data['ChangeGroups'] = Uni_Studenttalk::where('type', 'like', '%AssignmentHelp%')->where('university_id', base64_decode($id))->orderBy('created_at', 'desc')->limit(10)->get();
		$data['other'] = Uni_Studenttalk::where('type', 'like', '%OtherTopics%')->where('university_id', base64_decode($id))->orderBy('created_at', 'desc')->limit(10)->get();

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);

		return view('front.adduniversity.view', $data);
	}

	public function topic_list(Request $request, $topic, $uni) {
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';

		$data['uni'] = Student_Talk::where('id', base64_decode($uni))->first();
		$data['topic_list'] = Uni_Studenttalk::where('type', base64_decode($topic))->where('university_id', base64_decode($uni))->where('state_code', $request->req_state['code'])->orderBy('created_at', 'desc')->paginate(15);

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
		return view('front.adduniversity.topic_list', $data);
	}

	public function Topic_Form(Request $request, $id = "") {
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';

		$data['university'] = Student_Talk::where('state_code', $request->req_state['code'])->get();

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
		return view('front.adduniversity.add_toplic', $data);
	}

	public function submitTopic(Request $request) {

		$data = $request->all();

		$rules = array(
			'title' => 'required',
			'uni_name' => 'required',
			'topic_type' => 'required',
			'topic_body' => 'required|min:5',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$uni_topic = new Uni_Studenttalk();
			$uni_topic->university_id = $request->uni_name;
			$uni_topic->state_code = $request->req_state['code'];
			$uni_topic->user_id = Auth::user()->id;
			$uni_topic->title = $request->title;
			$uni_topic->message = $request->topic_body;
			$uni_topic->type = $request->topic_type;
			$uni_topic->save();

			\Session::flash('success', 'University Topic Saved Successfully.');
			$json['location'] = route('adduniversity.view', ['id' => base64_encode($request->uni_name)]);
		}
		return $json;
	}

	public function indexForm(Request $request) {

		$data['country_name'] = $request->req_country ? $request->req_country['name'] : 'USA';
		$place_name = $request->req_state ? $request->req_state['name'] : $data['country_name'];

		$data['page_type'] = $request->req_state ? 'state' : 'country';
		$data['place_name'] = $place_name;

		$country_id = $request->req_country ? $request->req_country['id'] : '1';
		$data['states'] = State::where('country_id', $country_id)->get();

		$data['stu_state'] = $request->req_state['code'];
		$data['meta_tags'] = $this->meta_tags;

		return view('front.adduniversity.form', $data);
	}

	public function submitForm(Request $request) {

		$data = $request->all();

		$rules = array(
			'name' => 'required',
			'comment' => 'required|min:2',
			'uni_image' => 'mimes:jpeg,jpg,png|required|max:2048',
		);

		$msg = array(
			'uni_image.mimes' => 'allow only image file',
		);

		$json = array();
		$validator = Validator::make($data, $rules, $msg);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			if ($request->file('uni_image')) {
				$file = request()->file('uni_image');
				$fileName = time() . "." . $file->getClientOriginalExtension();
				$file->move(public_path('upload/university'), $fileName);
			}

			$university = new Student_Talk();
			$university->user_id = Auth::user()->id;
			$university->uni_name = $request->name;
			$university->email_id = $request->email;
			$university->state_code = $request->state;
			$university->url = $request->link;
			$university->edu_field = $request->educationa;
			$university->details = $request->comment;
			$university->uni_img = $fileName;
			$university->save();

			\Session::flash('success', 'University Saved Successfully.');
			$json['location'] = route('adduniversity.index');
		}
		return $json;
	}

}