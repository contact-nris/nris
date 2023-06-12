<?php

namespace App\Http\Controllers;

use App\Temple;
use App\TemplesComment;
use Auth;
use Illuminate\Http\Request;
use Validator;

class TemplesController extends Controller {
	public function index(Request $request, $slug = "") {
		$query = Temple::with('comments')->selectRaw('temples.*,states.country_id, cities.name as city_name, temples_type.type as temples_type_name')
			->leftJoin('states', 'states.code', 'temples.state_code')
			->leftJoin('cities', 'cities.id', 'temples.city_id')
			->leftJoin('temples_type', 'temples_type.id', 'temples.temple_type')
			->orderby('temples.total_views', 'desc');

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$query->where('temples.state_code', $request->req_state['code']);
			$place_name = $request->req_state['name'];
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('temples.city_id', $request->city_code);
			$data['chack'] = $request->city_code;
		}

		$data['cities'] = $citys->get();

		if ($slug) {
			$query->where('temples_type.slug', $slug);
		}

		if ($request->filter_name) {
			$query->where('temples.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate(24);

		if (isset($_GET['test'])) {
			dd($data['lists']);
		};

		$data['page_type'] = $request->req_state ? 'state' : 'country';
		$data['restaturant_category'] = \App\RestaurantType::all();
		$data['job_category'] = \App\JobCategory::all();
		$data['temples_category'] = \App\TempleType::all();
		$data['pubs_category'] = \App\PubType::all();
		$data['theater_category'] = \App\TheaterType::all();

		$data['meta_tags'] = array(
			// 'meta_title' => $data['blog']->meta_title,
			// 'meta_description' => $data['blog']->meta_description,
			// 'meta_keywords' => $data['blog']->meta_keywords,
			'title' => 'Temple',
			'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Temple and stay updated with the latest posts.',
			'twitter_title' => 'Temple',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.temples.list', $data);
	}

	public function view(Request $request, $slug) {
		// $explode = explode('-', $slug);
		// $id = (int)end($explode);
		$url_slug = $this->clean($slug);
		$data = $request->all();

		$query = Temple::selectRaw('temples.*,states.country_id, cities.name as city_name, temples_type.type as temples_type_name')
			->leftJoin('states', 'states.code', 'temples.state_code')
			->leftJoin('cities', 'cities.id', 'temples.city_id')
			->leftJoin('temples_type', 'temples_type.id', 'temples.temple_type')
		// ->where('temples.id', $id);
			->where('temples.url_slug', $url_slug);
		// $country_id = $request->req_country ? $request->req_country['id'] : 1;
		// $place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		// $query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$query->where('temples.state_code', $request->req_state['code']);
			$place_name = $request->req_state['name'];
		}

		$data['temple'] = $query->firstOrFail();

		$data['comments'] = TemplesComment::selectRaw('temples_comment.*, users.profile_photo, CONCAT(users.first_name," ", users.last_name) AS user')->leftJoin("users", "users.id", "user_id")->where('temple_id', $data['temple']->id)->where('reply_id', 0)->orderBy('created_at', 'desc')->paginate(5);

		Temple::find($query->first()->id)->increment('total_views', 1);

		$data['meta_tags'] = array(
			'meta_title' => $data['temple']->meta_title,
			'meta_description' => $data['temple']->meta_description,
			'meta_keywords' => $data['temple']->meta_keywords,
			'title' => $data['temple']->name,
			'description' => $data['temple']['description'],
			'twitter_title' => $data['temple']['name'],
			'image_' => $data['temple']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		if (!$data['temple']) {
			return redirect(route('front.temples'));
		}

		return view('front.temples.view', $data);
	}

	public function submitForm(Request $request, TemplesComment $comment) {
		$data = $request->all();
		$rules = array(
			'comment' => 'required|min:2',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$desicomment = new TemplesComment;
			$desicomment->temple_id = $request->model_id;
			$desicomment->reply_id = $comment->id ? $comment->id : 0;
			$desicomment->user_id = Auth::user()->id;
			$desicomment->comment = $request->comment;
			$desicomment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'Famous Temple Comment',
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