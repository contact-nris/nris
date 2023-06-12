<?php

namespace App\Http\Controllers;

use App\GroceriesComment;
use App\Grocery;
use Auth;
use Illuminate\Http\Request;
use Validator;

class GrocieriesController extends Controller {
	public function index(Request $request) {
		$query = Grocery::selectRaw('groceries.*,states.country_id, cities.name as city_name,
            (SELECT COUNT(*) FROM groceries_comment WHERE groceries_comment.grocery_id = groceries.id) as comment_count')
			->leftJoin('states', 'states.code', 'groceries.state_code')
			->leftJoin('cities', 'cities.id', 'groceries.city_id')
			->leftJoin('groceries_comment', 'groceries_comment.grocery_id', 'groceries.id')
			->groupBy('groceries.id')
			->orderBy('groceries.id', 'desc');

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', groceries.state_code)");
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->filter_name) {
			$query->where('groceries.name', 'like', '%' . $request->filter_name . '%');
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('groceries.city_id', $request->city_code);
		}

		$data['cities'] = $citys->get();

		$data['lists'] = $query->paginate(24);

		$data['page_type'] = $request->req_state ? 'state' : 'country';
		$data['restaturant_category'] = \App\RestaurantType::all();
		$data['job_category'] = \App\JobCategory::all();
		$data['temples_category'] = \App\TempleType::all();
		$data['pubs_category'] = \App\PubType::all();
		$data['theater_category'] = \App\TheaterType::all();

		$data['meta_tags'] = array(

			'title' => 'Grocery',
			'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Grocery and stay updated with the latest posts.',
			'twitter_title' => 'Grocery',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.grocieries.list', $data);
	}

	public function view(Request $request, $slug) {
		// $explode = explode('-', $slug);
		// $id = (int)end($explode);

		$url_slug = $this->clean($slug);
		$data = $request->all();

		$query = Grocery::selectRaw('groceries.*,states.country_id, cities.name as city_name')
			->leftJoin('states', 'states.code', 'groceries.state_code')
			->leftJoin('cities', 'cities.id', 'groceries.city_id')
		//  ->where('groceries.id', $id);
			->where('groceries.url_slug', $url_slug);

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', groceries.state_code)");
			$place_name = $request->req_state['name'];
		}
// echo $query->toSql();
// exit;
		$data['grocieries'] = $query->firstOrFail();

		$data['comments'] = GroceriesComment::selectRaw('groceries_comment.*, users.profile_photo, CONCAT(users.first_name," ", users.last_name) AS user')->leftJoin("users", "users.id", "user_id")->where('grocery_id', $data['grocieries']->id)->where('reply_id', 0)->orderBy('created_at', 'desc')->paginate(5);

		Grocery::find($query->first()->id)->increment('total_views', 1);

		$data['meta_tags'] = array(
			'meta_title' => $data['grocieries']->meta_title,
			'meta_description' => $data['grocieries']->meta_description,
			'meta_keywords' => $data['grocieries']->meta_keywords,
			'title' => $data['grocieries']->name,
			'description' => $data['grocieries']['description'],
			'twitter_title' => $data['grocieries']['name'],
			'image_' => $data['grocieries']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);
		// echo '<pre>';print_r($data['grocieries']);echo '</pre>';die;
		return view('front.grocieries.view', $data);
	}

	public function submitForm(Request $request, GroceriesComment $comment) {
		$data = $request->all();

		$rules = array(
			'comment' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$grocieriesComment = new GroceriesComment();
			$grocieriesComment->grocery_id = $request->model_id;
			$grocieriesComment->reply_id = $comment->id ? $comment->id : 0;
			$grocieriesComment->comment = $request->comment;
			$grocieriesComment->user_id = Auth::user()->id;
			$grocieriesComment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'Grocieries Ad',
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