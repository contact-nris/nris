<?php

namespace App\Http\Controllers;

use App\City;
use App\GarageSale;
use App\GaragesaleCategory;
use App\GaragesaleComment;
use App\Http\Controllers\HomeController;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class GarageSaleController extends Controller {
	private $meta_tags = array(
		'title' => 'Garage Sale Ads in %s',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Garage Sale and stay updated with the latest posts.',
		'twitter_title' => 'Garage Sale',
		'image_' => '',
		'keywords' => 'Indian websites in %s, NRI websites, Indian community websites, classified website for NRIS in %s, free ads website',
	);
	public $ad_types = ['create_free_ad' => 'Create Free Ad', 'create_premium_ad' => 'Create Premium Ad'];

	public function index(Request $request, $slug = "") {

		$query = GarageSale::selectRaw('post_free_garagesale.*,states.country_id, cities.name as city_name, garagesale_categoires.name as category_name_en')
			->leftJoin('states', 'states.code', 'post_free_garagesale.states')
			->leftJoin('cities', 'cities.id', 'post_free_garagesale.city')
			->leftJoin('garagesale_categoires', 'garagesale_categoires.id', 'post_free_garagesale.items')
			->where(array('post_free_garagesale.display_status' => 1))
			->orderBy('post_free_garagesale.id', 'desc');

		//
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_garagesale.country', $country_id);

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_garagesale.states)");
			});
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('post_free_garagesale.city', $request->city_code);
			$data['chack'] = $request->city_code;
		}

		$data['cities'] = $citys->get();
		//

		if ($request->filter_name) {
			$query->where('post_free_garagesale.title', 'like', '%' . $request->filter_name . '%');
		}

		if ($slug) {
			$query->where('garagesale_categoires.slug', $slug);
			$data['category_type'] = $slug;
		} else {
			$data['category_type'] = '';
		}

		$data['lists'] = $query->orderby('created_at', 'desc')->paginate(20);
		$data['category'] = GaragesaleCategory::all();
		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
		$data['adv'] = HomeController::getSideAds(6);

		return view('front.garagesale.list', $data);
	}

	public function getdata(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$query = GarageSale::selectRaw('post_free_garagesale.*,states.country_id, cities.name as city_id,garagesale_categoires.name as category_name_en')
			->leftJoin('states', 'states.code', 'post_free_garagesale.states')
			->leftJoin('cities', 'cities.id', 'post_free_garagesale.city')
			->leftJoin('garagesale_categoires', 'garagesale_categoires.id', 'post_free_garagesale.items')
			->where('post_free_garagesale.id', $id);

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_garagesale.country', $country_id);

		if ($request->req_state) {
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_garagesale.states)");
			});
			$place_name = $request->req_state['name'];
		}

		$data['garagesale'] = $query->firstOrFail();

		$data['comments'] = GaragesaleComment::selectRaw('garagesale_comment.*, users.profile_photo, users.first_name, users.last_name')->leftJoin("users", "users.id", "user_id")->where('garagesale_id', $data['garagesale']->id)->where('reply_id', 0)->paginate(5);

		GarageSale::find($id)->increment('total_views', 1);

		$data['meta_tags'] = array(
			'meta_title' => $data['garagesale']->meta_title,
			'meta_description' => $data['garagesale']->meta_description,
			'meta_keywords' => $data['garagesale']->meta_keywords,
			'title' => $data['garagesale']->title,
			'description' => $data['garagesale']['message'],
			'twitter_title' => $data['garagesale']['title'],
			'image_' => $data['garagesale']->image_url,
			'keywords' => str_replace('%s', $place_name, $this->meta_tags['keywords']),
		);

		return view('front.garagesale.view', $data);
	}

	public function submitForm(Request $request, GaragesaleComment $comment) {
		$data = $request->all();
		if ($request->garagesale_id) {
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
			$garagesale = new GaragesaleComment;
			$garagesale->garagesale_id = $request->model_id;
			$garagesale->reply_id = $comment->id ? $comment->id : 0;
			$garagesale->user = $request->name ? $request->name : Auth::user()->name;
			$garagesale->user_id = Auth::user()->id;
			$garagesale->email = $request->email ? $request->email : Auth::user()->email;
			$garagesale->comment = $request->comment;
			$garagesale->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Garage Sale Ad',
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

		$data['ad'] = GarageSale::findOrNew($id ? base64_decode($id) : 0);
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

		$data['categories'] = GaragesaleCategory::all();

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $country_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $country_name, $data['meta_tags']['keywords']);

		return view('front.garagesale.create', $data);
	}
	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = GarageSale::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}
	public function sumbitAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();

		$success_text = $ad_type == 'update_ad' ? 'Update Ad' : ($ad_type == 'create_free_ad' ? 'Free Ad' : 'Premium Ad'); //

		$garagesale = GarageSale::findOrNew($id ? base64_decode($id) : 0);
		$adtype = $garagesale->id ? "updated" : "created";
		if ($id) {
			$ad = $garagesale->post_type;
		} else {
			$ad = $ad_type == 'create_free_ad' ? '1' : '2';
		}
		$rules = array(
			'title' => 'required|min:5', //|unique:post_free_garagesale,title,'.$garagesale->id,
			'images' => 'array|min:1|max:10',
			'category' => 'required',
			'description' => 'required',
			'next_date' => 'date',
			// 'url' => 'url',
			'contact_name' => 'required|min:3|max:50',
			// 'contact_number' => 'numeric|min:10',
			'email' => 'required|email',
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
			$matchingRecords = GarageSale::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $garagesale->title) {
					$garagesale->title = $new_title;
					$garagesale->url_slug = $this->clean($new_title);
				}} else {
				$garagesale->title = $new_title;
				$garagesale->url_slug = $this->clean($new_title);
			}
			$garagesale->message = $data['description'];
			$garagesale->items = isset($data['category']) ? implode(',', $data['category']) : '';
			$garagesale->contact_name = $data['contact_name'];
			//$garagesale->contact_number = $data['contact_number'];

			if (strlen($data['contact_number']) > 0) {
				$garagesale->contact_number = $data['contact_number'];
			}

			$garagesale->contact_email = $data['email'];

			//$garagesale->states = $data['state_id'];

			if (strlen($data['state_id']) > 0) {
				$garagesale->states = $data['state_id'];
			}
			$garagesale->city = $data['city_id'];
			$garagesale->end_date = date('Y-m-d', strtotime($data['expiry_date']));
			$garagesale->use_address_on_map = isset($data['use_address_on_map']) ? $data['use_address_on_map'] : 0;
			$garagesale->show_email = isset($data['show_email']) ? $data['show_email'] : 0;
			// $garagesale->isPayed = "N";
			$garagesale->post_type = $ad;
			$garagesale->country = $request->req_country ? $request->req_country['id'] : '1';
			$garagesale->user_id = Auth::user()->id;
			if (Auth::user()->id == 2046 || Auth::user()->id == 2371) {
				$ad_type = 1;
				$garagesale->isPayed = 'Y';
				$garagesale->payment_id = 65;
				$garagesale->display_status = 1;

			}

			$image_count = 1;
			if (isset($data['old']) && count($data['old']) > 0) {
				foreach ($data['old'] as $img) {
					$garagesale->{'image' . $image_count} = $img;
					$image_count++;
				}
			}

			if (isset($data['images']) && count($data['images']) > 0) {
				foreach ($data['images'] as $image) {
					$image_name = uniqname() . '.' . $image->guessExtension();
					$image->move(public_path('upload/garagesale'), $image_name);

					$garagesale->{'image' . $image_count} = $image_name;
					$image_count++;
				}
			}

			$garagesale->save();
			$getid = $garagesale->id;
			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Garage Sale Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $success_text,
			);
			sendCommentAlert($mail_data);
			sendNotification("Garage Sale", array(
				"type" => $adtype,
				"username" => Auth::user()->name,
				"id" => $getid,
			));

			\Session::flash('success', 'your garage sale ad will be reviewed and live soon hang tight … thank you');
			$json['location'] = $ad_type == 'create_premium_ad' ? route('preadbuy.startPayment', ['ad_id' => base64_encode($garagesale->id), 'model' => base64_encode('GarageSale')]) : route('front.profile.my_ads');
		}
		return $json;
	}

	public function deleteAd(Request $request, $id) {
		$real = GarageSale::findOrFail(base64_decode($id));
		if ($real->user_id == Auth::user()->id) {
			$real->delete();
			\Session::flash('success', 'Garage Sale Ad Deleted Successfully.');
		} else {
			\Session::flash('error', 'You are not authorized to delete this Garage Sale Ad.');
		}
		return redirect()->back();
	}
}