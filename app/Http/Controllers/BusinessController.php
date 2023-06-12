<?php

namespace App\Http\Controllers;

use App\BusinessComment;
use App\Businesses as Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class BusinessController extends Controller {
	public function index(Request $request, $slug = "") {

		$query = Business::with('comments')->selectRaw('participating_businesses.*,states.country_id, cities.name as city_name, participating_businesses_category.cat_name as business_type_name')
			->leftJoin(
				'states',
				'states.code',
				'participating_businesses.state_code'
			)
			->leftJoin(
				'cities',
				'cities.id',
				'participating_businesses.city'
			)
			->leftJoin(
				'participating_businesses_category',
				'participating_businesses_category.id',
				'participating_businesses.category_id'

			)
			->orderby(
				'participating_businesses.total_views',
				'desc'
			)->get();

		print_r($query);
		exit;

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', business.state_code)");
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('business.city_id', $request->city_code);
			$data['chack'] = $request->city_code;
		}

		$data['cities'] = $citys->get();

		if ($slug) {
			$query->where('business_type.slug', $slug);
		}

		if ($request->filter_name) {
			$query->where('business.business_name', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->paginate(24);

		$data['page_type'] = $request->req_state ? 'state' : 'country';
		$data['restaturant_category'] = \App\RestaurantType::all();
		$data['job_category'] = \App\JobCategory::all();
		$data['temples_category'] = \App\TempleType::all();
		$data['business_category'] = \App\BusinessType::all();
		$data['theater_category'] = \App\TheaterType::all();

		$data['meta_tags'] = array(
			'title' => 'Business',
			'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Business and stay updated with the latest posts.',
			'twitter_title' => 'Business',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.business.list', $data);
	}

	public function view(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$query = Business::selectRaw('business.*,states.country_id, cities.name as city_id, business_type.type as business_type_name')
			->leftJoin('states', 'states.code', 'business.state_code')
			->leftJoin('cities', 'cities.id', 'business.city_id')
			->leftJoin('business_type', 'business_type.id', 'business.business_type')
			->where('business.id', $id);

		// $country_id = $request->req_country ? $request->req_country['id'] : 1;
		// $place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		// $query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', business.state_code)");
			$place_name = $request->req_state['name'];
		}

		$data['business'] = $query->firstOrFail();

		$data['comments'] = BusinessComment::selectRaw('business_comment.*, users.profile_photo, CONCAT(users.first_name," ", users.last_name) AS user')->leftJoin("users", "users.id", "user_id")->where('business_id', $data['business']->id)->where('reply_id', 0)->orderBy('created_at', 'desc')->paginate(5);

		Business::find($id)->increment('total_views', 1);

		$data['meta_tags'] = array(
			'title' => $data['business']->business_name,
			'description' => $data['business']['description'],
			'twitter_title' => $data['business']['business_name'],
			'image_' => $data['business']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		if (!$data['business']) {
			return redirect(route('front.business'));
		}

		return view('front.business.view', $data);
	}

	public function submitForm(Request $request, BusinessComment $comment) {
		$data = $request->all();
		$rules = array(
			'comment' => 'required|min:2',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$businesscomment = new BusinessComment;
			$businesscomment->business_id = $request->model_id;
			$businesscomment->reply_id = $comment->id ? $comment->id : 0;
			$businesscomment->comment = $request->comment;
			$businesscomment->user_id = Auth::user()->id;
			$businesscomment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'Famous Business Comment',
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