<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Controllers\HomeController;
use App\MyPartner;
use App\MyPartnerCategory;
use App\MyPartnerComment;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class DesiDateController extends Controller {
	public $meta_tags = array(
		'title' => 'Find Your Perfect Partner in %s | Desi Date ',
		'description' => 'Find the right partner of your match, whether you need a boyfriend or a girlfriend. Our portal has latest Ads on some of the perfect partners for you in USA',
		'twitter_title' => 'Desipage',
		'image_' => '',
		'keywords' => 'find your partner, desi date, Indian roommate in %s, post Indian partner requirements in %s Indian websites in %s, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);
	public $ad_types = ['create_free_ad' => 'Create Free Ad', 'create_premium_ad' => 'Create Premium Ad'];

	public function index(Request $request, $slug = null) {
		$query = MyPartner::selectRaw('post_free_mypartner.*, cities.name as city_name, mypartner_categories.name as category_name_en')
			->leftJoin('mypartner_categories', 'mypartner_categories.id', 'post_free_mypartner.category')
			->leftJoin('cities', 'cities.id', 'post_free_mypartner.city')
			->where(array('post_free_mypartner.post_type' => 1))
			->where(array('post_free_mypartner.display_status' => 1))
			->orderBy('post_free_mypartner.id', 'desc');

		//
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_mypartner.country', $country_id);

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_mypartner.states)");
				// $q->orWhere('post_free_mypartner.states_details', 'ALL');
			});
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$query->where('post_free_mypartner.states', '');
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('post_free_mypartner.city', $request->city_code);
			$data['chack'] = $request->city_code;
		}

		$data['cities'] = $citys->get();

		if ($request->filter_name) {
			$query->where('post_free_mypartner.title', 'like', '%' . $request->filter_name . '%');
		}

		if ($slug) {
			$query->where('mypartner_categories.slug', $slug);
			$data['category_type'] = $slug;
		} else {
			$data['category_type'] = '';
		}
		$data['lists'] = $query->orderby('created_at', 'desc')->paginate(20);
		$data['category'] = MyPartnerCategory::all();

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
		$data['adv'] = HomeController::getSideAds(12);
		return view('front.desi_date.list', $data);
	}

	public function view(Request $request, $slug) {

		$url_slug = $this->clean($slug);

		// $explode = explode('-', $slug);
		// $id = (int) end($explode);
		$data = $request->all();

		$query = MyPartner::selectRaw('post_free_mypartner.*, cities.name as city_id, mypartner_categories.name as category_name_en')
			->leftJoin('mypartner_categories', 'mypartner_categories.id', 'post_free_mypartner.category')
			->leftJoin('cities', 'cities.id', 'post_free_mypartner.city')
		// ->where(array('post_free_mypartner.id' => $id));
			->where('post_free_mypartner.url_slug', $url_slug);

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$query->where('post_free_mypartner.country', $country_id);

		if ($request->req_state) {
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_mypartner.states)");
				$q->orWhere('post_free_mypartner.states_details', 'ALL');
			});
		} else {
			//$query->where('post_free_mypartner.states', '');
		}

		if (auth()->check()) {
			// $data['desi'] = $query->where('user_id',Auth::user()->id)->firstOrFail();
			$data['desi'] = $query->where('display_status', 1)->firstOrFail();
		} else {
			$data['desi'] = $query->where('display_status', 1)->firstOrFail();
		}

		// $data['desi'] = $query->firstOrFail();

		$data['comments'] = MyPartnerComment::selectRaw('mypartner_comment.*, users.profile_photo, users.first_name, users.last_name')->leftJoin("users", "users.id", "user_id")->where('mypartner_id', $data['desi']->id)->where('reply_id', 0)->paginate(5);

		MyPartner::find($data['desi']->id)->increment('total_views', 1);

		$data['states'] = City::all();
		$data['types'] = MyPartnerCategory::all();

		$data['meta_tags'] = array(
			'meta_title' => $data['desi']->meta_title,
			'meta_description' => $data['desi']->meta_description,
			'meta_keywords' => $data['desi']->meta_keywords,
			'title' => $data['desi']->title,
			'description' => htmlspecialchars_decode($data['desi']->details),
			'twitter_title' => $data['desi']['title'],
			'image_' => $data['desi']->image ? $data['desi']->image[0] : '',
			'keywords' => 'find your partner, desi date, Indian roommate in %s, post Indian partner requirements in %s Indian websites in %s, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.desi_date.view', $data);
	}

	public function submitForm(Request $request, MyPartnerComment $comment) {
		$json = array();

		$data = $request->all();
		if ($request->desi_page_id) {
			$rules = array(
				'comment' => 'required|min:2',
			);
		} else {
			$rules = array(
				'comment' => 'required|min:2',
				'model_id' => 'required',
			);
		}

		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {

			$desicomment = new MyPartnerComment;
			$desicomment->mypartner_id = $request->model_id;
			$desicomment->comment = $request->comment;
			$desicomment->reply_id = $comment->id ? $comment->id : 0;
			$desicomment->user_id = Auth::user() ? Auth::user()->id : 0;
			$desicomment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Desi Date Ad',
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

		$data['ad'] = MyPartner::findOrNew($id ? base64_decode($id) : 0);
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

		$data['categories'] = MyPartnerCategory::all();

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $country_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $country_name, $data['meta_tags']['keywords']);

		return view('front.desi_date.create', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = MyPartner::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function sumbitAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();

		$success_text = $ad_type == 'update_ad' ? 'Update Ad' : ($ad_type == 'create_free_ad' ? 'Free Ad' : 'Premium Ad'); //

		$desi = MyPartner::findOrNew($id ? base64_decode($id) : 0);
		$adtype = $desi->id ? "updated" : "created";
		if ($id) {
			$ad = $desi->post_type;
		} else {
			$ad = $ad_type == 'create_free_ad' ? '1' : '2';
		}
		$rules = array(
			'title' => 'required|min:5', //|unique:post_free_mypartner,title,'.$desi->id,
			'images' => 'array|min:1|max:10',
			'description' => 'required',
			'category' => 'required',
			'url' => 'url|nullable',
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
			$matchingRecords = MyPartner::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $desi->title) {
					$desi->title = $new_title;
					$desi->url_slug = $this->clean($new_title);
				}} else {
				$desi->title = $new_title;
				$desi->url_slug = $this->clean($new_title);
			}
			// $desi->title = $data['title'];
			$desi->message = $data['description'];
			$desi->category = $data['category'];
			// $desi->url = $data['url'];
			$desi->contact_name = $data['contact_name'];
			//$desi->contact_number = $data['contact_number'];

			if (strlen($data['url']) > 0) {
				$desi->url = $data['url'];
			}
			if (strlen($data['contact_number']) > 0) {
				$desi->contact_number = $data['contact_number'];
			}

			$desi->contact_email = $data['email'];
			//$desi->states = $data['state_id'];
			if (strlen($data['state_id']) > 0) {
				$desi->states = $data['state_id'];
			}
			$desi->city = $data['city_id'];
			$desi->end_date = date('Y-m-d', strtotime($data['expiry_date']));
			$desi->use_address_on_map = isset($data['use_address_on_map']) ? $data['use_address_on_map'] : 0;
			$desi->show_email = isset($data['show_email']) ? $data['show_email'] : 0;
			// $desi->isPayed = "N";
			$desi->post_type = $ad;
			$desi->country = $request->req_country ? $request->req_country['id'] : '1';
			$desi->user_id = Auth::user()->id;
			if (Auth::user()->id == 2046 || Auth::user()->id == 2371) {
				$ad_type = 1;
				$desi->isPayed = 'Y';
				$desi->payment_id = 65;
				$desi->display_status = 1;

			}

			$image_count = 1;
			if (isset($data['old']) && count($data['old']) > 0) {
				foreach ($data['old'] as $img) {
					$desi->{'image' . $image_count} = $img;
					$image_count++;
				}
			}

			if (isset($data['images']) && count($data['images']) > 0) {
				foreach ($data['images'] as $image) {
					$image_name = uniqname() . '.' . $image->guessExtension();
					$image->move(public_path('upload/mypartner'), $image_name);

					$desi->{'image' . $image_count} = $image_name;
					$image_count++;
				}
			}
			$desi->save();
			$getid = $desi->id;
			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'My partner Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $success_text,
			);
			sendCommentAlert($mail_data);
			sendNotification("Desi Meet", array(
				"type" => $adtype,
				"username" => Auth::user()->name,
				"id" => $getid,
			));

			\Session::flash('success', 'your desi meet ad will be reviewed and live soon hang tight … thank you');
			$json['location'] = route('front.profile.my_ads');
		}
		return $json;
	}
	public function deleteAd(Request $request, $id) {
		$partner = MyPartner::findOrFail(base64_decode($id));
		if ($partner->user_id == Auth::user()->id) {
			$partner->delete();
			\Session::flash('success', 'My partner Ad Deleted Successfully.');
		} else {
			\Session::flash('error', 'You are not authorized to delete this My partner Ad.');
		}
		return redirect()->back();
	}
}
