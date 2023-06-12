<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Controllers\HomeController;
use App\Other;
use App\OtherComment;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class OtherController extends Controller {
	private $meta_tags = array(
		'title' => 'Other in %s',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Other and stay updated with the latest posts.',
		'twitter_title' => 'Other',
		'image_' => '',
		'keywords' => 'Indian websites in %s, NRI websites, Indian community websites, classified website for NRIS in %s, free ads website',
	);
	public $ad_types = ['create_free_ad' => 'Create Free Ad', 'create_premium_ad' => 'Create Premium Ad'];

	public function index(Request $request) {
		$query = Other::selectRaw('post_free_other.*, cities.name as city_name')
			->leftJoin('cities', 'cities.id', 'post_free_other.city')
			->where(array('post_free_other.display_status' => 1))
			->orderBy('post_free_other.id', 'desc');

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_other.country', $country_id);

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_other.states)");
				// $q->orWhere('post_free_other.states_details', 'ALL');
			});
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$query->where('post_free_other.states', '');
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('post_free_other.city', $request->city_code);
			$data['chack'] = $request->city_code;
		}

		$data['cities'] = $citys->get();

		if ($request->filter_name) {
			$query->where('post_free_other.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->orderby('created_at', 'desc')->paginate(20);
		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
		$data['adv'] = HomeController::getSideAds(99);

		return view('front.other.list', $data);
	}

	public function getdata(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$query = Other::selectRaw('post_free_other.*, cities.name as city_id')
			->leftJoin('cities', 'cities.id', 'post_free_other.city')
			->where(array('post_free_other.id' => $id));

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_other.country', $country_id);

		if ($request->req_state) {
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_other.states)");
				$q->orWhere('post_free_other.states_details', 'ALL');
			});
			$place_name = $request->req_state['name'];
		}

		if (auth()->check()) {
			//$data['other'] = $query->where('user_id',Auth::user()->id)->firstOrFail();
			$data['other'] = $query->where('display_status', 1)->firstOrFail();
		} else {
			$data['other'] = $query->where('display_status', 1)->firstOrFail();
		}

		// $data['other'] = $query->firstOrFail();

		$data['comments'] = OtherComment::selectRaw('other_comments.*, users.profile_photo, users.first_name, users.last_name')->leftJoin("users", "users.id", "user_id")->where('other_id', $data['other']->id)->where('reply_id', 0)->paginate(5);

		Other::find($id)->increment('total_views', 1);

		$data['meta_tags'] = array(
			'meta_title' => $data['other']->meta_title,
			'meta_description' => $data['other']->meta_description,
			'meta_keywords' => $data['other']->meta_keywords,
			'title' => $data['other']->title,
			'description' => $data['other']['message'],
			'twitter_title' => $data['other']['title'],
			'image_' => $data['other']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.other.view', $data);
	}

	public function submitForm(Request $request, OtherComment $comment) {
		$data = $request->all();
		if ($request->baby_sitting_id) {
			$rules = array(
				'comment' => 'required|min:2|max:120',
				'name' => 'required|min:2|max:120',
				'email' => 'required|email');
		} else {
			$rules = array(
				'comment' => 'required|min:2|max:120',
				'model_id' => 'required');
		}

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$other = new OtherComment;
			$other->other_id = $request->model_id;
			$other->reply_id = $comment->id ? $comment->id : 0;
			$other->user = $request->name ? $request->name : Auth::user()->name;
			$other->user_id = Auth::user() ? Auth::user()->id : 0;
			$other->email = $request->email ? $request->email : Auth::user()->email;
			$other->comment = $request->comment;
			$other->save();
			$getid = $other->id;
			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Other Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $comment->id ? 'Reply' : 'Comment',
			);
			sendCommentAlert($mail_data);

			\Session::flash('success', 'Comment Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}

	public function createAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();
		$ad_types = $this->ad_types;

		$data['ad'] = Other::findOrNew($id ? base64_decode($id) : 0);
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

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $country_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $country_name, $data['meta_tags']['keywords']);

		return view('front.other.create', $data);
	}
	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Other::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}
	public function sumbitAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();

		$success_text = $ad_type == 'update_ad' ? 'Update Ad' : ($ad_type == 'create_free_add' ? 'Free Ad' : 'Premium Ad'); //

		$other = Other::findOrNew($id ? base64_decode($id) : 0);
		$adtype = $other->id ? "updated" : "created";
		$rules = array(
			'title' => 'required|min:5', //|unique:post_free_other,title,'.$other->id,
			'images' => 'array|min:1|max:10',
			'description' => 'required',
			'next_date' => 'date',
			// 'url' => 'url',
			'contact_name' => 'required|min:3|max:50',
			// 'contact_number' => 'numeric|min:10',
			'email' => 'required|email',
			'states_details' => 'required', //
			'city_id' => 'required',
			'expiry_date' => 'required|date',
			'images.*' => 'image|mimes:jpeg,png,jpg|max:200',
		);
		$rules['state_id'] = $data['states_details'] == 'ALL' ? 'nullable' : 'required';

		$msg = array(
			'city_id.required' => 'The City is not Valid.',
			'state_id.required' => 'The States field is required',
			// 'title.unique' => 'This title is already used',
		);

		$json = array();
		$validator = Validator::make($data, $rules, $msg);

		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = Other::where('url_slug', trim($this->clean($request->title)))->get();
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
			// $other->url = $data['url'];
			$other->contact_name = $data['contact_name'];
			//  $other->contact_number = $data['contact_number'];

			if (strlen($data['url']) > 0) {
				$other->url = $data['url'];
			}
			if (strlen($data['contact_number']) > 0) {
				$other->contact_number = $data['contact_number'];
			}

			$other->contact_email = $data['email'];
			//$other->states = $data['state_id'];

			if (strlen($data['state_id']) > 0) {
				$other->states = $data['state_id'];
			} //

			$other->states_details = $data['states_details']; //
			$other->city = $data['city_id'];
			$other->end_date = date('Y-m-d', strtotime($data['expiry_date']));
			$other->use_address_on_map = isset($data['use_address_on_map']) ? $data['use_address_on_map'] : 0;
			//$other->show_email = isset($data['show_email']) ? $data['show_email'] : 0;
			// $other->isPayed = "N";
			$other->post_type = $ad_type == 'create_free_ad' ? '1' : '2';
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
					$image->move(public_path('upload/other'), $image_name);

					$other->{'image' . $image_count} = $image_name;
					$image_count++;
				}
			}

			$other->save();
			$getid = $other->id;
			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Other Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $success_text,
			);
			sendCommentAlert($mail_data);

			sendNotification("Other", array(
				"type" => $adtype,
				"username" => Auth::user()->name,
				"id" => $getid,
			));

			\Session::flash('success', 'your other ad will be reviewed and live soon hang tight … thank you');
			$json['location'] = $ad_type == 'create_premium_ad' ? route('preadbuy.startPayment', ['ad_id' => base64_encode($other->id), 'model' => base64_encode('Other')]) : route('front.profile.my_ads');
		}
		return $json;
	}

	public function deleteAd(Request $request, $id) {
		$other = Other::findOrFail(base64_decode($id));
		if ($other->user_id == Auth::user()->id) {
			$other->delete();
			\Session::flash('success', 'Other Ad Deleted Successfully.');
		} else {
			\Session::flash('error', 'You are not authorized to delete this Other Ad.');
		}
		return redirect()->back();
	}

}