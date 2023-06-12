<?php

namespace App\Http\Controllers;
use App\Casino;
use App\CasinosComment;
use Auth;
use Illuminate\Http\Request;
// use App\Autobiocomment;
use Validator;

class CasinosController extends Controller {
	public $meta_tags = array(
		'title' => 'Casino',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Casino and stay updated with the latest posts.',
		'twitter_title' => 'Casino',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);

	public function index(Request $request, $slug = '') {
		$query = Casino::selectRaw('casinos.*, states.name as states_name, cities.name as city_name')
			->leftJoin(
				'states',
				'states.code',
				'casinos.state_code'
			)
			->leftJoin(
				'cities',
				'cities.id',
				'casinos.city_id'
			)
			->orderby(
				'casinos.total_views',
				'desc'
			);

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', casinos.state_code)");
			$place_name = $request->req_state['name'];
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($slug == 'top-rated') {
			$query->orderBy('casinos.total_views', 'DESC');
		} else if (strpos($slug, $place_name) !== false) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', casinos.state_code)");
			$query->orderBy('casinos.id', 'DESC');
		} else {
			$query->orderBy('casinos.id', 'DESC');
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('casinos.city_id', $request->city_code);
			$data['chack'] = $request->city_code;
		}

		$data['cities'] = $citys->get();

		if ($request->filter_name) {
			$query->where('casinos.name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate(24);

		$data['page_type'] = $request->req_state ? 'state' : 'country';
		$data['restaturant_category'] = \App\RestaurantType::all();
		$data['job_category'] = \App\JobCategory::all();
		$data['temples_category'] = \App\TempleType::all();
		$data['pubs_category'] = \App\PubType::all();
		$data['theater_category'] = \App\TheaterType::all();

		$data['meta_tags'] = $this->meta_tags;

		return view('front.casinos.list', $data);
	}

	public function getdata(Request $request, $slug) {
		// $explode = explode('-', $slug);
		// $id = (int)end($explode);
		$url_slug = $this->clean($slug);
		$data = $request->all();
		$query = Casino::selectRaw('casinos.*, states.country_id , cities.name as city_name')
			->leftJoin('states', 'states.code', 'casinos.state_code')
			->leftJoin('cities', 'cities.id', 'casinos.city_id')
			->orderBy('casinos.id', 'DESC')
		// ->where('casinos.id', $id);
			->where('casinos.url_slug', $url_slug);

		// $country_id = $request->req_country ? $request->req_country['id'] : 1;
		// $place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		// $query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', casinos.state_code)");
			$place_name = $request->req_state['name'];
		}

		$data['list'] = $query->firstOrFail();

		$data['comments'] = CasinosComment::selectRaw('casinos_comment.*, users.profile_photo, CONCAT(users.first_name," ", users.last_name) AS user')->leftJoin("users", "users.id", "user_id")->where('casino_id', $data['list']->id)->where('reply_id', 0)->orderBy('created_at', 'desc')->paginate(5);

		Casino::find($query->first()->id)->increment('total_views', 1);

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

		return view('front.casinos.view', $data);
	}

	public function submitForm(Request $request, CasinosComment $comment) {
		$data = $request->all();
		$rules = array(
			'comment' => 'required|min:2',
			'model_id' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$casinoscomment = new CasinosComment;
			$casinoscomment->casino_id = $request->model_id;
			$casinoscomment->reply_id = $comment->id ? $comment->id : 0;
			$casinoscomment->user_id = Auth::user()->id;
			$casinoscomment->comment = $request->comment;
			$casinoscomment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Famous Casinos',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $comment->id ? 'Reply' : 'Comment',
			);
			sendCommentAlert($mail_data);

			\Session::flash('success', 'Comment Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}

}