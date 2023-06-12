<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Controllers\HomeController;
use App\RoomMate;
use App\RoomMateBid;
use App\RoomMateCategory;
use App\RoomMateComment;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class RoomMateController extends Controller {
	private $meta_tags = array(
		'title' => 'RoomMate Ads in %s',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our RoomMate and stay updated with the latest posts.',
		'twitter_title' => 'RoomMate',
		'image_' => '',
		'keywords' => 'Indian websites in %s, NRI websites, Indian community websites, classified website for NRIS in %s, free ads website',
	);
	public $ad_types = ['create_free_ad' => 'Create Free Ad', 'create_premium_ad' => 'Create Premium Ad'];

	public function index(Request $request, $slug = "") {

		$query = RoomMate::selectRaw('post_free_roommates.*,states.country_id, cities.name as city_name, room_mate_categoires.name as category_name_en')
			->leftJoin('states', 'states.code', 'post_free_roommates.states')
			->leftJoin('cities', 'cities.id', 'post_free_roommates.city')
			->leftJoin('room_mate_categoires', 'room_mate_categoires.id', 'post_free_roommates.category')
			->where(array('post_free_roommates.display_status' => 1))
			->orderBy('post_free_roommates.id', 'desc');

		//
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_roommates.country', $country_id);

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_roommates.states)");
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('post_free_roommates.city', $request->city_code);
			$data['chack'] = $request->city_code;
		}

		$data['cities'] = $citys->get();
		//

		if ($request->city_code) {
			$query->where('post_free_roommates.city', $request->city_code);
		}

		if ($request->filter_name) {
			$query->where('post_free_roommates.title', 'like', '%' . $request->filter_name . '%');
		}

		if ($slug) {
			$query->where('room_mate_categoires.slug', $slug);
			$data['category_type'] = $slug;
		} else {
			$data['category_type'] = '';
		}

		$data['lists'] = $query->paginate(15);
		$data['category'] = RoomMateCategory::all();
		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
		$data['adv'] = HomeController::getSideAds(5);

		return view('front.roommate.list', $data);
	}

	public function getdata(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$query = RoomMate::selectRaw('post_free_roommates.*,states.country_id, cities.name as city_id,room_mate_categoires.name as category_name_en')
			->leftJoin('states', 'states.code', 'post_free_roommates.states')
			->leftJoin('cities', 'cities.id', 'post_free_roommates.city')
			->leftJoin('room_mate_categoires', 'room_mate_categoires.id', 'post_free_roommates.category')
			->where(array('post_free_roommates.id' => $id));

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_roommates.country', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_roommates.states)");
			$place_name = $request->req_state['name'];
		}

		if (auth()->check()) {
			//$data['roommate'] = $query->where('user_id',Auth::user()->id)->firstOrFail();
			$data['roommate'] = $query->where('display_status', 1)->firstOrFail();
		} else {
			$data['roommate'] = $query->where('display_status', 1)->firstOrFail();
		}

		// $data['roommate'] = $query->firstOrFail();
		$data['bid_bargin'] = RoomMateBid::where('roommates_id', $data['roommate']->id)->get();
		$data['comments'] = RoomMateComment::selectRaw('roommates_comments.*, users.profile_photo, users.first_name, users.last_name')->leftJoin("users", "users.id", "user_id")->where('roommates_id', $data['roommate']->id)->where('reply_id', 0)->paginate(5);

		RoomMate::find($id)->increment('total_views', 1);

		$data['meta_tags'] = array(
			'meta_title' => $data['roommate']->meta_title,
			'meta_description' => $data['roommate']->meta_description,
			'meta_keywords' => $data['roommate']->meta_keywords,
			'title' => $data['roommate']->title,
			'description' => $data['roommate']['message'],
			'twitter_title' => $data['roommate']['title'],
			'image_' => $data['roommate']->image_url,
			'keywords' => str_replace('%s', $place_name, $this->meta_tags['keywords']),
		);

		return view('front.roommate.view', $data);
	}

	public function submitForm(Request $request, RoomMateComment $comment) {
		$data = $request->all();

		if ($request->roommates_id) {
			$rules = array(
				'name' => 'required|min:2|max:120',
				'email' => 'required|email',
				'comment' => 'required|min:2|max:120',
			);} else {
			$rules = array(
				'comment' => 'required|min:2|max:120',
				'model_id' => 'required');
		}

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$roomcomment = new RoomMateComment;
			$roomcomment->roommates_id = $request->model_id;
			$roomcomment->reply_id = $comment->id ? $comment->id : 0;
			$roomcomment->user_id = Auth::user()->id;
			$roomcomment->user = $request->name ? $request->name : Auth::user()->name;
			$roomcomment->email = $request->email ? $request->email : Auth::user()->email;
			$roomcomment->comment = $request->comment;
			$roomcomment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Room Mate Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $comment->id ? 'Reply' : 'Comment',
			);
			sendCommentAlert($mail_data);

			\Session::flash('success', 'Comment Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}

	public function submitBio(Request $request) {
		$data = $request->all();
		$rules = array(
			'name' => 'required',
			'amount' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$autocomment = new RoomMateBid();
			$autocomment->roommates_id = $request->roommates_id;
			$autocomment->comment = $request->name;
			$autocomment->amount = $request->amount;
			$autocomment->user_id = Auth::user() ? Auth::user()->id : "";
			$autocomment->save();

			\Session::flash('success', 'Room Mate Bid Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}
	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = RoomMate::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}
	public function createAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();
		$ad_types = $this->ad_types;

		$data['ad'] = RoomMate::findOrNew($id ? base64_decode($id) : 0);
		if ($data['ad'] && $id) {
			if ($data['ad']->user_id != Auth::user()->id) {
				return abort(404);
			}
			$ad_types['update_ad'] = 'Update Ad';
		}

		$data['id'] = $id;
		if (!array_key_exists($ad_type, $ad_types)) {
			return abort(404);
		}
		$data['ad_type'] = $ad_type;
		$data['ad_type_text'] = $ad_types[$ad_type];

		$country_id = $data['ad']->country_id ?: ($request->req_country ? $request->req_country['id'] : '1');
		$state_id = $request->req_state ? $request->req_state['id'] : '1';

		$country_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$data['current_state'] = $data['ad']->states ?: State::find($state_id)->code;
		$data['states_list'] = State::selectRaw('code,name')->where('country_id', $country_id)->get()->keyBy('code');
		$data['city_name'] = $data['ad']->city ? \App\City::where('id', $data['ad']->city)->pluck('name')->first() : '';

		$data['user'] = Auth::user();

		$data['states_select'] = [
			$data['current_state'] => 'Current State Only',
			'ALL' => 'All States in ' . $country_name,
			'multiple' => 'Select Multiple States',
		];

		$data['categories'] = RoomMateCategory::all();

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $country_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $country_name, $data['meta_tags']['keywords']);

		return view('front.roommate.create', $data);
	}

	public function sumbitAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();

		$success_text = $ad_type == 'update_ad' ? 'Update Ad' : ($ad_type == 'create_free_ad' ? 'Free Ad' : 'Premium Ad'); //
		$roommate = RoomMate::findOrNew($id ? base64_decode($id) : 0);
		$adtype = $roommate->id ? "updated" : "created";
		if ($id) {
			$ad = $roommate->post_type;
		} else {
			$ad = $ad_type == 'create_free_ad' ? '1' : '2';
		}
		$rules = array(
			'title' => 'required|min:5', //|unique:post_free_roommates,title,'.$roommate->id,
			'images' => 'array|min:1|max:10',
			'description' => 'required',
			'category' => 'required',
			'gender_type' => 'required',
			'rent' => 'required|numeric',
			// 'url' => 'url',
			'contact_name' => 'required|min:3|max:50',
			// 'contact_number' => 'numeric|min:10',
			'email' => 'required|email',
			'state_id' => 'required',
			'city_id' => 'required',
			'expiry_date' => 'required|date',
			'images.*' => 'image|mimes:jpeg,png,jpg|max:200',
		);

		$msg = array(
			'city_id.required' => 'The City is not Valid.',
			// 'title.unique' => 'This title is already used',
		);

		$json = array();
		$validator = Validator::make($data, $rules, $msg);

		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = RoomMate::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $roommate->title) {
					$roommate->title = $new_title;
					$roommate->url_slug = $this->clean($new_title);
				}} else {
				$roommate->title = $new_title;
				$roommate->url_slug = $this->clean($new_title);
			}
			$roommate->message = $data['description'];
			$roommate->category = $data['category'];
			$roommate->gender_type = $data['gender_type'];
			$roommate->rent = $data['rent'];
			//  $roommate->url = $data['url'];
			$roommate->contact_name = $data['contact_name'];
			//$roommate->contact_number = $data['contact_number'];
			if (strlen($data['url']) > 0) {
				$roommate->url = $data['url'];
			}
			if (strlen($data['contact_number']) > 0) {
				$roommate->contact_number = $data['contact_number'];
			}

			$roommate->contact_email = $data['email'];
			//$roommate->states = $data['state_id'];

			if (strlen($data['state_id']) > 0) {
				$roommate->states = $data['state_id'];
			}

			$roommate->city = $data['city_id'];
			$roommate->end_date = date('Y-m-d', strtotime($data['expiry_date']));
			$roommate->use_address_on_map = isset($data['use_address_on_map']) ? $data['use_address_on_map'] : 0;
			$roommate->show_email = isset($data['show_email']) ? $data['show_email'] : 0;
			// $roommate->isPayed = "N";
			$roommate->post_type = $ad;
			$roommate->country = $request->req_country ? $request->req_country['id'] : '1';
			$roommate->user_id = Auth::user()->id;

			if (Auth::user()->id == 2046 || Auth::user()->id == 2371) {
				$ad_type = 1;
				$roommate->isPayed = 'Y';
				$roommate->payment_id = 65;
				$roommate->display_status = 1;

			}

			$image_count = 1;
			if (isset($data['old']) && count($data['old']) > 0) {
				foreach ($data['old'] as $img) {
					$roommate->{'image' . $image_count} = $img;
					$image_count++;
				}
			}

			if (isset($data['images']) && count($data['images']) > 0) {
				foreach ($data['images'] as $image) {
					$image_name = uniqname() . '.' . $image->guessExtension();
					$image->move(public_path('upload/roommates'), $image_name);

					$roommate->{'image' . $image_count} = $image_name;
					$image_count++;
				}
			}

			$roommate->save();
			$getid = $roommate->id;
			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Room Mate Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $success_text,
			);
			sendCommentAlert($mail_data);
			sendNotification("Room Mates", array(
				"type" => $adtype,
				"username" => Auth::user()->name,
				"id" => $getid,
			));

			\Session::flash('success', 'Room mates ' . $success_text . ' Data Saved Successfully.');

			$json['location'] = $ad_type == 'create_premium_ad' ? route('preadbuy.startPayment', ['ad_id' => base64_encode($roommate->id), 'model' => base64_encode('RoomMate')]) : route('front.profile.my_ads');
		}
		return $json;
	}

	public function deleteAd(Request $request, $id) {
		$roomamte = RoomMate::findOrFail(base64_decode($id));
		if ($roomamte->user_id == Auth::user()->id) {
			$roomamte->delete();
			\Session::flash('success', 'Room mates Ad Deleted Successfully.');
		} else {
			\Session::flash('error', 'You are not authorized to delete this Room mates Ad.');
		}
		return redirect()->back();
	}

}