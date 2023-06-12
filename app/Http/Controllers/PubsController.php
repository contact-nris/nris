<?php

namespace App\Http\Controllers;

use App\Pub;
use App\PubComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class PubsController extends Controller {
	public function index(Request $request, $slug = "") {

		$query = Pub::with('comments')->selectRaw('pubs.*,states.country_id, cities.name as city_name, pubs_type.type as pubs_type_name')
			->leftJoin(
				'states',
				'states.code',
				'pubs.state_code'
			)
			->leftJoin(
				'cities',
				'cities.id',
				'pubs.city_id'
			)
			->leftJoin(
				'pubs_type',
				'pubs_type.id',
				'pubs.pub_type'
			)
			->orderby(
				'pubs.total_views',
				'desc'
			);

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', pubs.state_code)");
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('pubs.city_id', $request->city_code);
			$data['chack'] = $request->city_code;
		}

		$data['cities'] = $citys->get();

		if ($slug) {
			$query->where('pubs_type.slug', $slug);
		}

		if ($request->filter_name) {
			$query->where('pubs.pub_name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate(24);

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
			'title' => 'Pub',
			'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Pub and stay updated with the latest posts.',
			'twitter_title' => 'Pub',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.pubs.list', $data);
	}

	public function view(Request $request, $slug) {
		// $explode = explode('-', $slug);
		// $id = (int)end($explode);
		$url_slug = $this->clean($slug);
		$data = $request->all();

		$query = Pub::selectRaw('pubs.*,states.country_id, cities.name as city_id, pubs_type.type as pubs_type_name')
			->leftJoin('states', 'states.code', 'pubs.state_code')
			->leftJoin('cities', 'cities.id', 'pubs.city_id')
			->leftJoin('pubs_type', 'pubs_type.id', 'pubs.pub_type')
		// ->where('pubs.id', $id);
			->where('pubs.url_slug', $url_slug);

		// $country_id = $request->req_country ? $request->req_country['id'] : 1;
		// $place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		// $query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', pubs.state_code)");
			$place_name = $request->req_state['name'];
		}

		$data['pub'] = $query->firstOrFail();

		$data['comments'] = PubComment::selectRaw('pubs_comment.*, users.profile_photo, CONCAT(users.first_name," ", users.last_name) AS user')->leftJoin("users", "users.id", "user_id")->where('pub_id', $data['pub']->id)->where('reply_id', 0)->orderBy('created_at', 'desc')->paginate(5);

		Pub::find($query->first()->id)->increment('total_views', 1);

		$data['meta_tags'] = array(
			'meta_title' => $data['pub']->meta_title,
			'meta_description' => $data['pub']->meta_description,
			'meta_keywords' => $data['pub']->meta_keywords,
			'title' => $data['pub']->pub_name,
			'description' => $data['pub']['description'],
			'twitter_title' => $data['pub']['pub_name'],
			'image_' => $data['pub']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		if (!$data['pub']) {
			return redirect(route('front.pubs'));
		}

		return view('front.pubs.view', $data);
	}

	public function submitForm(Request $request, PubComment $comment) {
		$data = $request->all();
		$rules = array(
			'comment' => 'required|min:2',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$pubcomment = new PubComment;
			$pubcomment->pub_id = $request->model_id;
			$pubcomment->reply_id = $comment->id ? $comment->id : 0;
			$pubcomment->comment = $request->comment;
			$pubcomment->user_id = Auth::user()->id;
			$pubcomment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'Famous Pubs Comment',
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