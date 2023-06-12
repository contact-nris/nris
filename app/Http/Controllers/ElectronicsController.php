<?php

namespace App\Http\Controllers;

use App\City;
use App\ElectronicCategory;
use App\ElectronicComment;
use App\ElectronicsClassifieds;
use App\Http\Controllers\HomeController;
use App\State;
use Auth;
use Illuminate\Http\Request;
use Validator;

class ElectronicsController extends Controller {
	private $meta_tags = array(
		'title' => 'Electronics Ad in %s | NRIS',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Electronics and stay updated with the latest posts.',
		'twitter_title' => 'Electronics',
		'image_' => '',
		'keywords' => "sell your electronics in %s, buy used electronics, sell used phones in %s, free electronics ads in %s",
	);
	public $ad_types = ['create_free_ad' => 'Create Free Ad', 'create_premium_ad' => 'Create Premium Ad'];

	public function index(Request $request, $slug = "") {
		$query = ElectronicsClassifieds::selectRaw('post_free_electronics.*, cities.name as city_name, electronic_categories.name as category_name_en')
			->leftJoin('cities', 'cities.id', 'post_free_electronics.city')
			->leftJoin('electronic_categories', 'electronic_categories.id', 'post_free_electronics.category')
			->orderBy('post_free_electronics.id', 'DESC')
			->where(array('post_free_electronics.display_status' => 1));

		//
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_electronics.country', $country_id);

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_electronics.states)");
				// $q->orWhere('post_free_electronics.states_details', 'ALL');
			});
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$query->where('post_free_electronics.states', '');
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$query->where('post_free_electronics.city', $request->city_code);
		}

		if ($request->category_type) {
			$citys->where('cities.id', $request->city_code);
			$query->where('post_free_electronics.category', $request->category_type);
		}

		$data['cities'] = $citys->get();

		if ($request->filter_name) {
			$query->where('post_free_electronics.title', 'like', '%' . $request->filter_name . '%');
		}

		if ($slug) {
			$query->where('electronic_categories.id', $slug);
			$data['category_type'] = $slug;
		} else {
			$data['category_type'] = '';
		}

		$data['lists'] = $query->orderby('post_free_electronics.created_at', 'DESC')->paginate(20);
		$data['category'] = ElectronicCategory::all();
		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
		$data['adv'] = HomeController::getSideAds(10);

		return view('front.electronics.list', $data);
	}

	public function getdata(Request $request, $slug) {
		$data = $request->all();
		$explode = explode('-', $slug);
		$id = (int) end($explode);

		$query = ElectronicsClassifieds::selectRaw('post_free_electronics.*, cities.name as city_id,electronic_categories.name as category_name_en')
			->leftJoin('cities', 'cities.id', 'post_free_electronics.city')
			->leftJoin('electronic_categories', 'electronic_categories.id', 'post_free_electronics.category')
			->where('post_free_electronics.id', $id);

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_electronics.country', $country_id);

		if ($request->req_state) {
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_electronics.states)");
				$q->orWhere('post_free_electronics.states_details', 'ALL');
			});
			$place_name = $request->req_state['name'];
		} else {
			// $query->where('post_free_electronics.states', '');
		}

		$data['electronics'] = $query->firstOrFail();
		ElectronicsClassifieds::find($id)->increment('total_views', 1);

		$data['comments'] = ElectronicComment::selectRaw('electronic_comments.*, users.profile_photo, users.first_name, users.last_name')->leftJoin("users", "users.id", "user_id")->where('electronics_id', $data['electronics']->id)->where('reply_id', 0)->paginate(5);
		ElectronicsClassifieds::find($id)->increment('total_views', 1);
		$data['meta_tags'] = array(
			'meta_title' => $data['electronics']->meta_title,
			'meta_description' => $data['electronics']->meta_description,
			'meta_keywords' => $data['electronics']->meta_keywords,
			'title' => $data['electronics']->title,
			'description' => $data['electronics']['message'],
			'twitter_title' => $data['electronics']['title'],
			'image_' => $data['electronics']->image_url,
			'keywords' => str_replace('%s', $place_name, $this->meta_tags['keywords']),
		);

		return view('front.electronics.view', $data);
	}

	public function submitForm(Request $request, ElectronicComment $comment) {
		$data = $request->all();
		if ($request->electronics_id) {
			$rules = array(
				'name' => 'required',
				'email' => 'required',
				'comment' => 'required|min:2',
			);
		} else {
			$rules = array(
				'model_id' => 'required',
				'comment' => 'required|min:2',
			);
		}

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$electronics = new ElectronicComment;
			$electronics->electronics_id = $request->model_id;
			$electronics->reply_id = $comment->id ? $comment->id : 0;
			$electronics->user = $request->name ? $request->name : Auth::user()->name;
			$electronics->user_id = Auth::user()->id;
			$electronics->email = $request->email ? $request->email : Auth::user()->email;
			$electronics->comment = $request->comment;
			$electronics->save();
			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Electronics Ad',
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

		$data['ad'] = ElectronicsClassifieds::findOrNew($id ? base64_decode($id) : 0);
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

		$data['categories'] = ElectronicCategory::all();
		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $country_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $country_name, $data['meta_tags']['keywords']);

		return view('front.electronics.create', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = ElectronicsClassifieds::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function sumbitAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();

		$success_text = $ad_type == 'update_ad' ? 'Update Ad' : ($ad_type == 'create_free_ad' ? 'Free Ad' : 'Premium Ad'); //

		$electronics = ElectronicsClassifieds::findOrNew($id ? base64_decode($id) : 0);
		$adtype = $electronics->id ? "updated" : "created";
		if ($id) {
			$ad = $electronics->post_type;
		} else {
			$ad = $ad_type == 'create_free_ad' ? '1' : '2';
		}
		$rules = array(
			'title' => 'required|min:5', //|unique:post_free_electronics,title,'.$electronics->id,
			'images' => 'array|min:1|max:10',
			'description' => 'required',
			'category' => 'required',
			'next_date' => 'date',
			// 'url' => 'url',
			'contact_name' => 'required|min:3|max:50',
			// 'contact_number' => 'numeric|min:10',
			'email' => 'required|email',
			'states_details' => 'required',
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
			$matchingRecords = ElectronicsClassifieds::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $electronics->title) {
					$electronics->title = $new_title;
					$electronics->url_slug = $this->clean($new_title);
				}} else {
				$electronics->title = $new_title;
				$electronics->url_slug = $this->clean($new_title);
			}
			$electronics->message = $data['description'];
			$electronics->category = $data['category'];
			//$electronics->url = $data['url'];
			$electronics->contact_name = $data['contact_name'];
			// $electronics->contact_number = $data['contact_number'];

			if (strlen($data['url']) > 0) {
				$electronics->url = $data['url'];
			}
			if (strlen($data['contact_number']) > 0) {
				$electronics->contact_number = $data['contact_number'];
			}

			if (strlen($data['state_id']) > 0) {
				$electronics->states = $data['state_id'];
			}

			$electronics->contact_email = $data['email'];
			//$electronics->states = $data['state_id'];               //
			$electronics->states_details = $data['states_details']; //
			$electronics->city = $data['city_id'];
			$electronics->end_date = date('Y-m-d', strtotime($data['expiry_date']));
			$electronics->use_address_on_map = isset($data['use_address_on_map']) ? $data['use_address_on_map'] : 0;
			$electronics->show_email = isset($data['show_email']) ? $data['show_email'] : 0;
			// $electronics->isPayed = "N";
			$electronics->post_type = $ad;
			$electronics->country = $request->req_country ? $request->req_country['id'] : '1';
			$electronics->user_id = Auth::user()->id;
			if (Auth::user()->id == 2046 || Auth::user()->id == 2371) {
				$ad_type = 1;
				$electronics->isPayed = 'Y';
				$electronics->payment_id = 65;
				$electronics->display_status = 1;

			}

			$image_count = 1;
			if (isset($data['old']) && count($data['old']) > 0) {
				foreach ($data['old'] as $img) {
					$electronics->{'image' . $image_count} = $img;
					$image_count++;
				}
			}

			if (isset($data['images']) && count($data['images']) > 0) {
				foreach ($data['images'] as $image) {
					$image_name = uniqname() . '.' . $image->guessExtension();
					$image->move(public_path('upload/electronics'), $image_name);

					$electronics->{'image' . $image_count} = $image_name;
					$image_count++;
				}
			}

			$electronics->save();
			$getid = $electronics->id;
			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Electronics Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $success_text,
			);
			sendCommentAlert($mail_data);
			sendNotification("Electronics", array(
				"type" => $adtype,
				"username" => Auth::user()->name,
				"id" => $getid,
			));

			\Session::flash('success', 'your electronics ad will be reviewed and live soon hang tight … thank you');
			$json['location'] = $ad_type == 'create_premium_ad' ? route('preadbuy.startPayment', ['ad_id' => base64_encode($electronics->id), 'model' => base64_encode('ElectronicsClassifieds')]) : route('front.profile.my_ads');
		}
		return $json;
	}

	public function deleteAd(Request $request, $id) {
		$real = ElectronicsClassifieds::findOrFail(base64_decode($id));
		if ($real->user_id == Auth::user()->id) {
			$real->delete();
			\Session::flash('success', 'Electronics Ad Deleted Successfully.');
		} else {
			\Session::flash('error', 'You are not authorized to delete this Electronics Ad.');
		}
		return redirect()->back();
	}
}