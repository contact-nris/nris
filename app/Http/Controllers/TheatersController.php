<?php

namespace App\Http\Controllers;

use App\Theater;
use App\TheaterComment;
use App\TheaterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class TheatersController extends Controller {
	public $meta_tags = array(
		'title' => 'Theater',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Theater and stay updated with the latest posts.',
		'twitter_title' => 'Theater',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);

	public function index(Request $request, $slug = null) {
		$query = Theater::selectRaw('theaters.*,states.country_id, cities.name as city_name, theaters_type.type as theaters_type_name')
		// (select count(*) from theaters_comment where theaters_comment.theater_id = theaters.id) as comment_count')
			->leftJoin('states', 'states.code', 'theaters.state_code')
			->leftJoin('cities', 'cities.id', 'theaters.city_id')
			->leftJoin('theaters_type', 'theaters_type.id', 'theaters.theater_type')
		// ->leftJoin('theaters_comment', 'theaters_comment.theater_id', 'theaters.id')
			->with('comments')
			->where(array('states.country_id' => country_id(), 'theaters.status' => 1));

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', theaters.state_code)");
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('theaters.city_id', $request->city_code);
		}

		$data['cities'] = $citys->get();

		if ($slug) {
			$query->where('theaters_type.type', 'like', '%' . str_replace('-', ' ', $slug) . '%');
		}

		if ($request->filter_name) {
			$query->where('theaters.name', 'like', '%' . $request->filter_name . '%');
		}

		if ($request->theater_type) {
			$query->where('theaters_type.slug', $request->theater_type);
		}

		$data['theater_type'] = $slug ? $data['theater_type'] = $slug : null;
		// echo '<pre>';
		// print_r($data['theater_type']);
		// echo '</pre>';
		$data['lists'] = $query->paginate(24);
		$data['types'] = TheaterType::all();

		$data['page_type'] = $request->req_state ? 'state' : 'country';
		$data['restaturant_category'] = \App\RestaurantType::all();
		$data['job_category'] = \App\JobCategory::all();
		$data['temples_category'] = \App\TempleType::all();
		$data['pubs_category'] = \App\PubType::all();
		$data['theater_category'] = \App\TheaterType::all();

		$data['meta_tags'] = $this->meta_tags;

		return view('front.theaters.list', $data);
	}

	public function view(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$query = Theater::selectRaw('theaters.*,states.country_id, cities.name as city_name, theaters_type.type as theaters_type_name')
			->leftJoin('states', 'states.code', 'theaters.state_code')
			->leftJoin('cities', 'cities.id', 'theaters.city_id')
			->leftJoin('theaters_type', 'theaters_type.id', 'theaters.theater_type')
			->where('states.country_id', country_id())
			->where('theaters.id', $id);

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', theaters.state_code)");
			$place_name = $request->req_state['name'];
		}

		$data['theaters'] = $query->firstOrFail();

		$data['comments'] = TheaterComment::selectRaw('theaters_comment.*, users.profile_photo, users.first_name, users.last_name')->leftJoin("users", "users.id", "user_id")->where('theater_id', $data['theaters']->id)->where('reply_id', 0)->orderBy('created_at', 'desc')->paginate(5);

		$data['meta_tags'] = array(
			'meta_title' => $data['theaters']->meta_title,
			'meta_description' => $data['theaters']->meta_description,
			'meta_keywords' => $data['theaters']->meta_keywords,
			'title' => $data['theaters']->name,
			'description' => $data['theaters']['description'],
			'twitter_title' => $data['theaters']['title'],
			'image_' => $data['theaters']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		// echo '<pre>';print_r($data['theaters']);echo '</pre>';die;
		return view('front.theaters.view', $data);
	}

	public function submitForm(Request $request, TheaterComment $comment) {
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
			$theatercomment = new TheaterComment();
			$theatercomment->theater_id = $request->model_id;
			$theatercomment->reply_id = $comment->id ? $comment->id : 0;
			$theatercomment->comment = $request->comment;
			$theatercomment->user_id = Auth::user()->id;
			$theatercomment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'Theater Ad',
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
