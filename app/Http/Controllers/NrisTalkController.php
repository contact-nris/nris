<?php

namespace App\Http\Controllers;

use App\NrisLIke;
use App\NRITalk;
use App\NRITalkReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class NrisTalkController extends Controller {

	private $meta_tags = array(
		'title' => 'NRIS Talk',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our NRIS talk and stay updated with the latest posts.',
		'twitter_title' => 'NRIS Talk',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);

	public function index(Request $request) {
		$query = NRITalk::with('comments', 'like_nris')->selectRaw('nris_talk.*')
		// (SELECT COUNT(nris_like.id) FROM nris_like WHERE nris_like.talk_id = nris_talk.id) as like_count ')
		// (SELECT COUNT(nris_talk_reply.id) FROM nris_talk_reply WHERE nris_talk_reply.talk_id = nris_talk.id) as reply_count,
		// ->leftJoin('nris_talk_reply', 'nris_talk_reply.talk_id', 'nris_talk.id')
		// ->leftJoin('nris_like', 'nris_like.talk_id', 'nris_talk.id')
			->orderBy('nris_talk.created_at', 'desc');
		if ($request->filter_name) {
			$query->where('nris_talk.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->where(array('nris_talk.status' => '1'))
			->paginate(50);

		$data['meta_tags'] = $this->meta_tags;

		return view('front.nristalk.list', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = NRITalk::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function view(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		//print_R($data);
		//exit;

		$query = NRITalk::selectRaw('nris_talk.*, CONCAT(users.first_name," ",users.last_name) as username,users.mobile,
            (SELECT COUNT(nris_talk_reply.id) FROM nris_talk_reply WHERE nris_talk_reply.talk_id = nris_talk.id) as reply_count,
            (SELECT COUNT(nris_like.id) FROM nris_like WHERE nris_like.talk_id = nris_talk.id) as like_count ')
			->leftJoin('nris_talk_reply', 'nris_talk_reply.talk_id', 'nris_talk.id')
			->leftJoin('nris_like', 'nris_like.talk_id', 'nris_talk.id')
			->leftJoin('users', 'users.id', 'nris_talk.user_id')
			->where(array('nris_talk.status' => '1', 'nris_talk.id' => $id));

		$data['nristalk'] = $query->firstOrFail();

		// echo "<pre>";

		$data['comments'] = NRITalkReply::selectRaw('nris_talk_reply.*, users.profile_photo, CONCAT(users.first_name," ", users.last_name) AS user')->leftJoin("users", "users.id", "user_id")->where('talk_id', $data['nristalk']->id)->where('reply_id', 0)->orderBy('created_at', 'desc')->paginate(5);
		NRITalk::find($id)->increment('total_views', 1);
		// print_R( $data['comments']);
		// exit;

		if (auth()->check()) {
			$data['likeModel'] = NrisLIke::where([
				'talk_id' => $data['nristalk']->id,
				'user_id' => auth()->user()->id,
			])->first();

			$data['likeTotal'] = likeDislike(NrisLIke::selectRaw('COUNT(status) as total, status')->where('talk_id', $data['nristalk']->id)->where('status', '>=', 0)->groupBy('status')->get());
		}

		$data['meta_tags'] = array(
			'meta_title' => $data['nristalk']->meta_title,
			'meta_description' => $data['nristalk']->meta_description,
			'meta_keywords' => $data['nristalk']->meta_keywords,
			'title' => $data['nristalk']->title,
			'description' => $data['nristalk']->description,
			'twitter_title' => $data['nristalk']->title,
			'image_' => $data['nristalk']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

//   echo "<pre>";
//         print_r($data);
//          echo "</pre>";
//         exit;
		return view('front.nristalk.view', $data);
	}

	public function createTopic(Request $request) {
		$data = $request->all();

		$data['user'] = Auth::user();
		$data['meta_tags'] = $this->meta_tags;

		return view('front.nristalk.create', $data);
	}

	public function sumbitTopic(Request $request) {
		$data = $request->all();

		$talk = new NRITalk;
		$rules = array(
			'title' => 'required|unique:nris_talk,title|min:5',
			'description' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);

		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
		
				$talk->title =$request->title;
				$talk->url_slug = $this->clean($request->title);
			$talk->description = $data['description'];
			$talk->state_code = 'MI';
			$talk->status = 0;
			$talk->user_id = Auth::user()->id;
			$talk->save();
			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'NRIsTalk Topic Created',
				'name' => Auth::user()->name,
				'sub_type' => 'NRI\'s Talk Topic Saved Successfully',
			);
			sendCommentAlert($mail_data);

			\Session::flash('success', 'NRI\'s Talk Topic Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}

	public function submitForm(Request $request, NRITalkReply $comment) {
		$data = $request->all();

		$rules = array(
			'comment' => 'required|min:2|max:120',
			'model_id' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			// $matchingRecords = NationalEvent::where('url_slug', trim($this->clean($request->title)))->get();
			// $matchingCount = $matchingRecords->count();
			// if ($matchingCount > 0) {
			// 	$new_title = $this->get_uniq_slug($request->title);
			// } else {
			// 	$new_title = $request->title;
			// }

			// if ($id > 0) {
			// 	if (trim($request->title) != $event->title) {
			// 		$event->title = $new_title;
			// 		$event->url_slug = $this->clean($new_title);
			// 	}} else {
			// 	$event->title = $new_title;
			// 	$event->url_slug = $this->clean($new_title);
			// }
			$nrisReplay = new NRITalkReply();
			$nrisReplay->talk_id = $request->model_id;
			$nrisReplay->reply_id = $comment ? $comment->id : 0;
			$nrisReplay->user_id = Auth::user()->id;
			$nrisReplay->reply_id = $comment->id ? $comment->id : 0;
			$nrisReplay->comment = $request->comment;

			$nrisReplay->save();
			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'NRIsTalk Topic Comment',
				'name' => Auth::user()->name,
				'sub_type' => $comment->id ? 'Reply' : 'Comment',
			);
			sendCommentAlert($mail_data);

			\Session::flash('success', 'Comment Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}
}