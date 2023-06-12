<?php

namespace App\Http\Controllers;

use App\City;
use App\FreeStuff;
use App\FreeStuffComment;
use App\Http\Controllers\HomeController;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class FreeStuffController extends Controller {

	private $meta_tags = array(
		'title' => 'FreeStuff in %s ',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our FreeStuff and stay updated with the latest posts.',
		'twitter_title' => 'FreeStuff',
		'image_' => '',
		'keywords' => 'Indian websites in %s, NRI websites, Indian community websites, classified website for NRIS in %s, free ads website',
	);
	public $ad_types = ['create_free_ad' => 'Create Free Ad', 'create_premium_ad' => 'Create Premium Ad'];

	public function index(Request $request) {

		$query = FreeStuff::selectRaw('post_free_stuff.*,states.country_id, cities.name as city_name')
			->leftJoin('states', 'states.code', 'post_free_stuff.state')
			->leftJoin('cities', 'cities.id', 'post_free_stuff.city')
			->where(array('post_free_stuff.display_status' => 1))
			->orderBy('post_free_stuff.id', 'desc');

		//
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_stuff.country', $country_id);

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_stuff.state)");
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('post_free_stuff.city', $request->city_code);
			$data['chack'] = $request->city_code;
		}

		$data['cities'] = $citys->get();
		//

		if ($request->filter_name) {
			$query->where('post_free_stuff.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->orderby('created_at', 'desc')->paginate(20);
		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
		$data['adv'] = HomeController::getSideAds(7);

		return view('front.freestuff.list', $data);
	}

	public function getdata(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$query = FreeStuff::selectRaw('post_free_stuff.*,states.country_id, cities.name as city_id')
			->leftJoin('states', 'states.code', 'post_free_stuff.state')
			->leftJoin('cities', 'cities.id', 'post_free_stuff.city')
			->where(array('post_free_stuff.id' => $id));

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_stuff.country', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_stuff.state)");
			$place_name = $request->req_state['name'];
		}

		if (auth()->check()) {
			//$data['freestuff'] = $query->where('user_id',Auth::user()->id)->firstOrFail();
			$data['freestuff'] = $query->where('display_status', 1)->firstOrFail();
		} else {
			$data['freestuff'] = $query->where('display_status', 1)->firstOrFail();
		}

		// $data['freestuff'] = $query->firstOrFail();

		$data['comments'] = FreeStuffComment::selectRaw('free_stuff_comment.*, users.profile_photo, users.first_name, users.last_name')->leftJoin("users", "users.id", "user_id")->where('free_stuff_id', $data['freestuff']->id)->where('reply_id', 0)->paginate(5);

		FreeStuff::find($id)->increment('total_views', 1);

		$data['meta_tags'] = array(
			'meta_title' => $data['freestuff']->meta_title,
			'meta_description' => $data['freestuff']->meta_description,
			'meta_keywords' => $data['freestuff']->meta_keywords,
			'title' => $data['freestuff']->title,
			'description' => $data['freestuff']['message'],
			'twitter_title' => $data['freestuff']['title'],
			'image_' => $data['freestuff']->image_url,
			'keywords' => str_replace('%s', $place_name, $this->meta_tags['keywords']),
		);

		return view('front.freestuff.view', $data);
	}

	public function submitForm(Request $request, FreeStuffComment $comment) {
		$data = $request->all();
		if ($request->real_id) {
			$rules = array(
				'user' => 'required',
				'email' => 'required',
				'comment' => 'required|min:2',
			);
		} else {
			$rules = array(
				'comment' => 'required|min:2',
				'model_id' => 'required',
			);
		}

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$freestuff = new FreeStuffComment;
			$freestuff->free_stuff_id = $request->model_id;
			$freestuff->reply_id = $comment->id ? $comment->id : 0;
			$freestuff->user = $request->name ? $request->name : Auth::user()->name;
			$freestuff->user_id = Auth::user()->id;
			$freestuff->email = $request->email ? $request->email : Auth::user()->email;
			$freestuff->comment = $request->comment;
			$freestuff->save();

			\Session::flash('success', 'Comment Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}

	public function createAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();
		$ad_types = $this->ad_types;

		$data['ad'] = FreeStuff::findOrNew($id ? base64_decode($id) : 0);
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

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $country_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $country_name, $data['meta_tags']['keywords']);
		return view('front.freestuff.create', $data);
	}
	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = FreeStuff::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function sumbitAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();

		$success_text = $ad_type == 'update_ad' ? 'Update Ad' : ($ad_type == 'create_free_ad' ? 'Free Ad' : 'Premium Ad'); //

		$other = FreeStuff::findOrNew($id ? base64_decode($id) : 0);
		$adtype = $other->id ? "updated" : "created";
		if ($id) {
			$ad = $other->post_type;
		} else {
			$ad = $ad_type == 'create_free_ad' ? '1' : '2';
		}
		$rules = array(
			'title' => 'required|min:5', //|unique:post_free_stuff,title,'.$other->id,
			'images' => 'array|min:1|max:10',
			'description' => 'required',
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
			$matchingRecords = FreeStuff::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $other->title) {
					$other->title = $new_title;
					$other->url_slug = $this->clean($new_title);
				}} else {
				$other->title = $new_title;
				$other->url_slug = $this->clean($new_title);
			}
			$other->message = $data['description'];
			$other->contact_name = $data['contact_name'];
			// $other->contact_number = $data['contact_number'];
			$other->contact_email = $data['email'];
			// $other->state = $data['state_id'];
			if (strlen($data['contact_number']) > 0) {
				$other->contact_number = $data['contact_number'];
			}
			if (strlen($data['state_id']) > 0) {
				$other->state = $data['state_id'];
			}
			$other->city = $data['city_id'];
			$other->end_date = date('Y-m-d', strtotime($data['expiry_date']));
			$other->use_address_on_map = isset($data['use_address_on_map']) ? $data['use_address_on_map'] : 0;
			$other->show_email = isset($data['show_email']) ? $data['show_email'] : 0;
			// $other->isPayed = "N";
			$other->post_type = $ad;
			$other->country = $request->req_country ? $request->req_country['id'] : '1';
			$other->user_id = Auth::user()->id;
			if (Auth::user()->id == 2046 || Auth::user()->id == 2371) {
				$ad_type = 1;
				$other->isPayed = 'Y';
				$other->payment_id = 65;
				$other->display_status = 1;

			}
			$image_count = 1;
			if (isset($data['old']) && count($data['old']) > 0) {
				foreach ($data['old'] as $img) {
					$other->{'image' . $image_count} = $img;
					$image_count++;
				}
			}

			if (isset($data['images']) && count($data['images']) > 0) {
				foreach ($data['images'] as $image) {
					$image_name = uniqname() . '.' . $image->guessExtension();
					$image->move(public_path('upload/free_stuff'), $image_name);

					$other->{'image' . $image_count} = $image_name;
					$image_count++;
				}
			}

			$other->save();
			$getid = $other->id;
			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Freestuff Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $success_text,
			);
			sendCommentAlert($mail_data);
			sendNotification("Free Stuff", array(
				"type" => $adtype,
				"username" => Auth::user()->name,
				"id" => $getid,
			));

			\Session::flash('success', 'your freestuff ad will be reviewed and live soon hang tight … thank you');
			$json['location'] = $ad_type == 'create_premium_ad' ? route('preadbuy.startPayment', ['ad_id' => base64_encode($other->id), 'model' => base64_encode('FreeStuff')]) : route('front.profile.my_ads');
		}
		return $json;
	}
	public function deleteAd(Request $request, $id) {
		$free = FreeStuff::findOrFail(base64_decode($id));
		if ($free->user_id == Auth::user()->id) {
			$free->delete();
			\Session::flash('success', 'Freestuff Ad Deleted Successfully.');
		} else {
			\Session::flash('error', 'You are not authorized to delete this Freestuff Ad.');
		}
		return redirect()->back();
	}
}