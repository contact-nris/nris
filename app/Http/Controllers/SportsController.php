<?php

namespace App\Http\Controllers;

use App\City;
use App\Sport;
use App\SportComment;
use App\SportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class SportsController extends Controller {
	public function index(Request $request) {
		$query = Sport::selectRaw('sports.*,sports_type.type as sport_type_name,states.country_id, cities.name as city_name,
            (SELECT COUNT(*) FROM sports_comment WHERE sports_comment.sport_id = sports.id) as comment_count')
			->leftJoin('sports_type', 'sports_type.id', 'sports.sport_type')
			->leftJoin('states', 'states.code', 'sports.state_code')
			->leftJoin('cities', 'cities.id', 'sports.city_id')
			->leftJoin('sports_comment', 'sports_comment.sport_id', 'sports.id')
			->where('states.country_id', country_id())
			->orderBy('sports.id', 'desc');

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', sports.state_code)");
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('sports.city_id', $request->city_code);
		}

		$data['cities'] = $citys->get();

		if ($request->sport_type) {
			$query->where('sports.sport_type', (int) $request->sport_type);
		}

		if ($request->filter_name) {
			$query->where('sports.name', 'like', '%' . $request->filter_name . '%');
		}

		$query->where(array('sports.status' => 1));

		$data['lists'] = $query->paginate(15);
		$data['types'] = SportType::all();
		$data['citys'] = City::CityWithState();

		$data['meta_tags'] = array(
			// 'meta_title' => $data['blog']->meta_title,
			// 'meta_description' => $data['blog']->meta_description,
			// 'meta_keywords' => $data['blog']->meta_keywords,
			'title' => 'Sport',
			'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Sport and stay updated with the latest posts.',
			'twitter_title' => 'Sport',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.sports.list', $data);
	}

	public function view(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$query = Sport::selectRaw('sports.*,sports_type.type as sport_type_name,states.country_id, cities.name as city_name')
			->leftJoin('sports_type', 'sports_type.id', 'sports.sport_type')
			->leftJoin('states', 'states.code', 'sports.state_code')
			->leftJoin('cities', 'cities.id', 'sports.city_id')
			->leftJoin('sports_comment', 'sports_comment.sport_id', 'sports.id')
			->where('states.country_id', country_id());

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', sports.state_code)");
			$place_name = $request->req_state['name'];
		}

		$data['sports'] = $query->where('sports.id', $id)->firstOrFail();

		$data['comments'] = SportComment::selectRaw('sports_comment.*, CONCAT(users.first_name," ",users.last_name) as user')
			->leftJoin('users', 'users.id', 'sports_comment.user_id')
			->where('sport_id', $data['sports']->id)
			->where('reply_id', 0)
			->orderBy('id', 'desc')
			->paginate(5);

		$data['meta_tags'] = array(
			'meta_title' => $data['sports']->meta_title,
			'meta_description' => $data['sports']->meta_description,
			'meta_keywords' => $data['sports']->meta_keywords,
			'title' => $data['sports']->name,
			'description' => $data['sports']['description'],
			'twitter_title' => $data['sports']['title'],
			'image_' => $data['sports']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.sports.view', $data);
	}

	public function submitForm(Request $request, SportComment $comment) {
		$data = $request->all();

		$rules = array(
			'comment' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$grocieriesComment = new SportComment();
			$grocieriesComment->comment = $request->comment;
			$grocieriesComment->sport_id = $request->model_id;
			$grocieriesComment->reply_id = $comment->id ? $comment->id : 0;
			$grocieriesComment->user_id = Auth::user() ? Auth::user()->id : 0;
			$grocieriesComment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'Sports Cub Ad',
				'name' => Auth::user()->name,
				'sub_type' => $comment->id ? 'Reply' : 'Comment',
			);
			sendCommentAlert($mail_data);

			\Session::flash('success', ' Comment Saved Successfully.');
			$json['reload'] = true;
		}
		return $json;
	}

}