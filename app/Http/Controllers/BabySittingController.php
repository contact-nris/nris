<?php

namespace App\Http\Controllers;

use App\BabySittingCategory;
use App\BabySittingClassified;
use App\BabySittingComment;
use App\City;
use App\Http\Controllers\HomeController;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class BabySittingController extends Controller {
	private $meta_tags = array(
		'title' => 'Baby Sitting Ads in %s | NRIS',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our BabySitting and stay updated with the latest    posts.',
		'twitter_title' => 'BabySitting',
		'image_' => '',
		'keywords' => "baby sitting jobs in %s, live in nanny jobs %s, local babysitting jobs available, babysitting jobs near me, baby sitting ads near %s",
	);
	public $ad_types = ['create_free_ad' => 'Create Free Ad', 'create_premium_ad' => 'Create Premium Ad'];

	public function index(Request $request, $slug = '') {
		$query = BabySittingClassified::selectRaw('
                post_free_baby_sitting.*,
                states.name as states_name,
                cities.name as city_name,
                baby_sitting_categories.name as baby_sitting_name
            ')
			->leftJoin('cities', 'cities.id', 'post_free_baby_sitting.city')
			->leftJoin('states', 'states.code', 'post_free_baby_sitting.state')
			->leftJoin('baby_sitting_categories', 'baby_sitting_categories.id', 'post_free_baby_sitting.category')
			->where(array('post_free_baby_sitting.display_status' => 1));

		//
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_baby_sitting.country', $country_id);
		$qur_data1 = $query;

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_baby_sitting.state)");
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('post_free_baby_sitting.city', $request->city_code);
		}

		if ($request->filter_name) {
			$query->where('post_free_baby_sitting.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['cities'] = $citys->get();
		//
		if ($slug) {
			$query->where('baby_sitting_categories.slug', $slug);
			$data['category_type'] = $slug;
		} else {
			$data['category_type'] = '';
		}

		$data['lists'] = $query->orderby('created_at', 'desc')->paginate(20);
		$data['category'] = BabySittingCategory::all();

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
		$data['adv'] = HomeController::getSideAds(2);
		return view('front.babysitting.list', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = BabySittingClassified::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function view(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$query = BabySittingClassified::selectRaw('
                post_free_baby_sitting.*,
                states.name as states_name,
                cities.name as city_name,
                users.profile_photo as profile_photo,
                baby_sitting_categories.name as baby_sitting_name,
                baby_sitting_categories.slug as category_slug,
                CONCAT(users.first_name, " ", users.last_name) as user_name
            ')
			->leftJoin('users', 'users.id', 'post_free_baby_sitting.user_id')
			->leftJoin('cities', 'cities.id', 'post_free_baby_sitting.city')
			->leftJoin('states', 'states.code', 'post_free_baby_sitting.state')
			->leftJoin('baby_sitting_categories', 'baby_sitting_categories.id', 'post_free_baby_sitting.category')
			->where(array('post_free_baby_sitting.id' => $id));

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_baby_sitting.country', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_baby_sitting.state)");
			$place_name = $request->req_state['name'];
		}

		if (auth()->check()) {
			//$data['babysitting'] = $query->where('user_id',Auth::user()->id)->firstOrFail();
			$data['babysitting'] = $query->where('display_status', 1)->firstOrFail();
		} else {
			$data['babysitting'] = $query->where('display_status', 1)->firstOrFail();
		}

		BabySittingClassified::find($id)->increment('total_views', 1);

		$data['comments'] = BabySittingComment::selectRaw('baby_sitting_comment.*, users.profile_photo, users.first_name, users.last_name')->leftJoin("users", "users.id", "user_id")->where('baby_sitting_id', $data['babysitting']->id)->where('reply_id', 0)->paginate(5);

		$data['meta_tags'] = array(
			'meta_title' => $data['babysitting']->meta_title,
			'meta_description' => $data['babysitting']->meta_description,
			'meta_keywords' => $data['babysitting']->meta_keywords,
			'title' => $data['babysitting']->title,
			'description' => $data['babysitting']->message,
			'twitter_title' => $data['babysitting']->title,
			'image_' => $data['babysitting']->image_url,
			'keywords' => str_replace('%s', $place_name, $this->meta_tags['keywords']),
		);

		return view('front.babysitting.view', $data);
	}

	public function submitForm(Request $request, BabySittingComment $comment) {
		$data = $request->all();

		if ($request->baby_sitting_id) {
			$rules = array(
				'comment' => 'required|min:2|max:120',
				'name' => 'required|min:2|max:120',
				'email' => 'required|email',
			);
		} else {
			$rules = array(
				'comment' => 'required|min:2|max:120',
				'model_id' => 'required',
			);
		}

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$BabysitingComment = new BabySittingComment();
			$BabysitingComment->baby_sitting_id = $request->model_id;
			$BabysitingComment->reply_id = $comment->id ? $comment->id : 0;
			$BabysitingComment->user_id = Auth::user()->id;
			$BabysitingComment->user = $request->name ? $request->name : Auth::user()->name;
			$BabysitingComment->email = $request->email ? $request->email : Auth::user()->email;
			$BabysitingComment->comment = $request->comment;
			$BabysitingComment->save();

			\Session::flash('success', 'Comment Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}

	public function createAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();
		$ad_types = $this->ad_types;

		$data['ad'] = BabySittingClassified::findOrNew($id ? base64_decode($id) : 0);
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

		$data['category_types'] = BabySittingCategory::all();

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $country_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $country_name, $data['meta_tags']['keywords']);

		return view('front.babysitting.create', $data);
	}

	public function sumbitAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();

		$success_text = $ad_type == 'update_ad' ? 'Update Ad' : ($ad_type == 'create_free_ad' ? 'Free Ad' : 'Premium Ad'); //

		$baby = BabySittingClassified::findOrNew(base64_decode($id));
		$adtype = $baby->id ? "updated" : "created";
		if ($id) {
			$ad = $baby->post_type;
		} else {
			$ad = $ad_type == 'create_free_ad' ? '1' : '2';
		}
		$rules = array(
			'title' => 'required|min:5', //|unique:post_free_baby_sitting,title,'.$baby->id,
			'images' => 'array|min:1|max:10',
			'description' => 'required',
			'category_types' => 'required',
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
			'state_id.required' => 'The States field is required',
			// 'title.unique' => 'This title is already used',
		);

		$json = array();
		$validator = Validator::make($data, $rules, $msg);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = BabySittingClassified::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $baby->title) {
					$baby->title = $new_title;
					$baby->url_slug = $this->clean($new_title);
				}} else {
				$baby->title = $new_title;
				$baby->url_slug = $this->clean($new_title);
			}
			$baby->message = $data['description'];
			$baby->category = $data['category_types'];
			$baby->contact_name = $data['contact_name'];
			//$baby->contact_number = $data['contact_number'];
			if (strlen($data['contact_number']) > 0) {
				$baby->contact_number = $data['contact_number'];
			}
			$baby->contact_email = $data['email'];
			$baby->end_date = date('Y-m-d', strtotime($data['expiry_date']));
			$baby->use_address_on_map = isset($data['use_address_on_map']) ? $data['use_address_on_map'] : 0;
			$baby->show_email = isset($data['show_email']) ? $data['show_email'] : 0;
			// $baby->isPayed = "N";
			$baby->city = $data['city_id'];
			//$baby->state = $data['state_id'];

			if (strlen($data['state_id']) > 0) {
				$baby->state = $data['state_id'];
			}
			$baby->country = $request->req_country ? $request->req_country['id'] : '1';
			$baby->user_id = Auth::user()->id;
			$baby->post_type = $ad;
			if (Auth::user()->id == 2046 || Auth::user()->id == 2371) {
				$ad_type = 1;
				$baby->isPayed = 'Y';
				$baby->payment_id = 65;
				$baby->display_status = 1;

			}

			$image_count = 1;
			if (isset($data['old']) && count($data['old']) > 0) {
				foreach ($data['old'] as $img) {
					$baby->{'image' . $image_count} = $img;
					$image_count++;
				}
			}

			if (isset($data['images']) && count($data['images']) > 0) {
				foreach ($data['images'] as $image) {
					$image_name = uniqname() . '.' . $image->guessExtension();
					$image->move(public_path('upload/babysitting'), $image_name);

					$baby->{'image' . $image_count} = $image_name;
					$image_count++;
				}
			}

			$baby->save();
			$getid = $baby->id;
			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Baby Sitting Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $success_text,
			);
			sendCommentAlert($mail_data);

			sendNotification("Baby Sitting", array(
				"type" => $adtype,
				"username" => Auth::user()->name,
				"id" => $getid,
			));

			\Session::flash('success', 'your babysitting ad will be reviewed and live soon hang tight … thank you');
			$json['location'] = $ad_type == 'create_premium_ad' ? route('preadbuy.startPayment', ['ad_id' => base64_encode($baby->id), 'model' => base64_encode('BabySittingClassified')]) : route('front.profile.my_ads');
		}

		return $json;
	}

	public function deleteAd(Request $request, $id) {
		$baby = BabySittingClassified::findOrFail(base64_decode($id));
		if ($baby->user_id == Auth::user()->id) {
			$baby->delete();
			\Session::flash('success', 'Baby Sitting Ad Deleted Successfully.');
		} else {
			\Session::flash('error', 'You are not authorized to delete this Baby Sitting Ad.');
		}
		return redirect()->back();
	}
}