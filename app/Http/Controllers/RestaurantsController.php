<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\RestaurantsComment;
use App\RestaurantType;
use Auth;
use Illuminate\Http\Request;
use Validator;

class RestaurantsController extends Controller {
	public $meta_tags = array(
		'title' => 'Restaurant',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Restaurant and stay updated with the latest posts.',
		'twitter_title' => 'Restaurant',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);

	public function index(Request $request, $slug = "") {

		$data = $request->all();
		$a = get_states();
		$query = Restaurant::selectRaw('restaurants.*, cities.name as city_name, restaurants_type.type as category_name_en')
			->leftJoin('cities', 'cities.id', 'restaurants.city_id')
			->leftJoin('restaurants_type', 'restaurants_type.id', 'restaurants.restaurant_type')
			->whereIn('restaurants.state_code', explode(",", $a[0]))
			->orderBy('restaurants.total_views', 'desc');

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', restaurants.state_code)");
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			// echo "<pre>";
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
			//  dd($citys);
			// print_r($country_id);
			// echo "</pre>";
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('restaurants.city_id', $request->city_code);
			$data['chack'] = $request->city_code;
		}

		$data['cities'] = $citys->get();

		if ($slug) {
			$query->where('restaurants_type.slug', $slug);
			$data['demo'] = RestaurantType::where('restaurants_type.slug', $slug)->first();
		}

		if ($request->filter_name) {
			$query->where('restaurants.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate(24);

		$data['page_type'] = $request->req_state ? 'state' : 'country';
		$data['restaturant_category'] = \App\RestaurantType::all();
		$data['job_category'] = \App\JobCategory::all();
		$data['temples_category'] = \App\TempleType::all();
		$data['pubs_category'] = \App\PubType::all();
		$data['theater_category'] = \App\TheaterType::all();

		$data['meta_tags'] = $this->meta_tags;

		return view('front.restaurant.list', $data);
	}

	public function getdata(Request $request, $slug) {
		// $explode = explode('-', $slug);

		$url_slug = $this->clean($slug);

		// echo $url_slug;

		// $id = (int)end($explode);
		$data = $request->all();

		$query = Restaurant::selectRaw('restaurants.*, cities.name as city_name, restaurants_type.type as category_name_en')
			->leftJoin('states', 'states.code', 'restaurants.state_code')
			->leftJoin('cities', 'cities.id', 'restaurants.city_id')
			->leftJoin('restaurants_type', 'restaurants_type.id', 'restaurants.restaurant_type')
		// ->where('restaurants.id', $id);

			->where('url_slug', $url_slug);

		// $country_id = $request->req_country ? $request->req_country['id'] : 1;
		// $place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		// $query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', restaurants.state_code)");
			$place_name = $request->req_state['name'];
		}

		$data['list'] = $query->firstorfail();

		$data['comments'] = RestaurantsComment::selectRaw('restaurants_comment.*, users.profile_photo, CONCAT(users.first_name," ", users.last_name) AS user')->leftJoin("users", "users.id", "user_id")->where('restaurant_id', $data['list']->id)->where('reply_id', 0)->orderBy('created_at', 'desc')->paginate(5);

		Restaurant::find($query->first()->id)->increment('total_views', 1);

		$data['meta_tags'] = array(
			'meta_title' => $data['list']->meta_title,
			'meta_description' => $data['list']->meta_description,
			'meta_keywords' => $data['list']->meta_keywords,
			'title' => $data['list']->name,
			'description' => $data['list']['description'],
			'twitter_title' => $data['list']['name'],
			'image_' => $data['list']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.restaurant.view', $data);
	}

	public function submitForm(Request $request, RestaurantsComment $comment) {
		$data = $request->all();
		$rules = array(
			'comment' => 'required|min:2',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$desicomment = new RestaurantsComment;
			$desicomment->restaurant_id = $request->model_id;
			$desicomment->reply_id = $comment->id ? $comment->id : 0;
			$desicomment->user_id = Auth::user()->id;
			$desicomment->comment = $request->comment;
			$desicomment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'Famous Restaureants Comment',
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
