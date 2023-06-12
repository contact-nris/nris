<?php

namespace App\Http\Controllers;

use App\City;
use App\Desipage;
use App\Desipagecomment;
use App\Desipage_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class DesiPageController extends Controller {
	public $meta_tags = array(
		'title' => 'Desipage',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our desipage and stay updated with the latest posts.',
		'twitter_title' => 'Desipage',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);

	public function index(Request $request) {
		$query = Desipage::selectRaw('desi_pages.*,states.country_id, cities.name as city_name, desi_pages_cat.name as category_name_en')
			->leftJoin('states', 'states.code', 'desi_pages.state_code')
			->leftJoin('cities', 'cities.id', 'desi_pages.city_id')
			->leftJoin('desi_pages_cat', 'desi_pages_cat.id', 'desi_pages.category_name')
			->orderBy('desi_pages.id', 'desc');

		//
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', desi_pages.state_code)");
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('cities.id', $request->city_code);
		}

		$data['cities'] = $citys->get();
		//

		if ($request->filter_name) {
			$query->where('desi_pages.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->orderby('created_at', 'desc')->paginate(20);

		$data['meta_tags'] = $this->meta_tags;

		return view('front.desi_page.list', $data);
	}

	public function view(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$query = Desipage::selectRaw('desi_pages.*,states.country_id, cities.name as city_id, desi_pages_cat.name as category_name_en')
			->leftJoin('states', 'states.code', 'desi_pages.state_code')
			->leftJoin('cities', 'cities.id', 'desi_pages.city_id')
			->leftJoin('desi_pages_cat', 'desi_pages_cat.id', 'desi_pages.category_name')
			->where(array('desi_pages.id' => $id));

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$query->where('states.country_id', $country_id);

		if ($request->req_state) {
			$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', desi_pages.state_code)");
		}

		$data['desipage'] = $query->firstOrFail();

		$data['comments'] = Desipagecomment::selectRaw('desi_pages_comment.*, CONCAT(users.first_name," ",users.last_name) as user')
			->leftJoin('users', 'users.id', 'desi_pages_comment.user_id')
			->where('desi_page_id', $data['desipage']->id)
			->orderby('id', 'desc')
			->where('reply_id', 0)
			->paginate(5);

		Desipage::find($id)->increment('total_views', 1);

		$data['states'] = City::all();
		$data['types'] = Desipage_type::all();

		$data['meta_tags'] = array(
			'meta_title' => $data['desipage']->meta_title,
			'meta_description' => $data['desipage']->meta_description,
			'meta_keywords' => $data['desipage']->meta_keywords,
			'title' => $data['desipage']->title,
			'description' => htmlspecialchars_decode($data['desipage']->details),
			'twitter_title' => $data['desipage']['title'],
			'image_' => $data['desipage']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.desi_page.view', $data);
	}

	public function submitForm(Request $request, Desipagecomment $comment) {
		$json = array();

		$data = $request->all();
		if ($request->desi_page_id) {
			$rules = array(
				'comment' => 'required|min:2',
			);
		} else {
			$rules = array(
				'comment' => 'required|min:2',
				'model_id' => 'required',
			);
		}

		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$desipagecomment = new Desipagecomment;
			$desipagecomment->desi_page_id = $request->model_id;
			$desipagecomment->comment = $request->comment;
			$desipagecomment->reply_id = $comment->id ? $comment->id : 0;
			$desipagecomment->user_id = Auth::user() ? Auth::user()->id : 0;
			$desipagecomment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'Desi Page Ad',
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
