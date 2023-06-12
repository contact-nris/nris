<?php

namespace App\Http\Controllers;

use App\Citymovie;
use App\DesiMoviesComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class DesiMoviesController extends Controller {
	public $meta_tags = array(
		'title' => 'City Desi Movies',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our citydesimovies and stay updated with the latest posts.',
		'twitter_title' => 'CityDesiMovies',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);

	public function index(Request $request) {
		$query = Citymovie::selectRaw('city_movies.*,states.country_id, cities.name as city_name')
			->leftJoin('states', 'states.code', 'city_movies.state_code')
			->leftJoin('cities', 'cities.id', 'city_movies.city_id')
			->where('city_movies.status', 1);

		if ($request->req_state) {
			$query->where('city_movies.state_code', $request->req_state['code']);
		}

		$data['lists'] = $query->orderby('created_at', 'desc')->paginate(21);

		$data['meta_tags'] = $this->meta_tags;

		return view('front.desi_movies.list', $data);
	}

	public function getdata(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$query = Citymovie::selectRaw('city_movies.*,states.country_id, cities.name as city_name')
			->leftJoin('states', 'states.code', 'city_movies.state_code')
			->leftJoin('cities', 'cities.id', 'city_movies.city_id')
			->where(array('city_movies.id' => $id));

		if ($request->req_state) {
			$query->where('city_movies.state_code', $request->req_state['code']);
		}

		$data['desimovie'] = $query->firstOrFail();

		$data['comments'] = DesiMoviesComment::selectRaw('desimovies_comment.*, users.profile_photo, CONCAT(users.first_name," ", users.last_name) AS user')
			->leftJoin('users', 'users.id', 'user_id')
			->where('desi_movie_id', $data['desimovie']->id)
			->orderby('id', 'desc')
			->where('reply_id', 0)
			->orderBy('created_at', 'desc')
			->paginate(5);

		$data['meta_tags'] = array(
			'meta_title' => $data['desimovie']->meta_title,
			'meta_description' => $data['desimovie']->meta_description,
			'meta_keywords' => $data['desimovie']->meta_keywords,
			'title' => $data['desimovie']->name,
			'description' => htmlspecialchars_decode($data['desimovie']->name),
			'twitter_title' => $data['desimovie']['name'],
			'image_' => $data['desimovie']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.desi_movies.view', $data);
	}

	public function submitForm(Request $request, DesiMoviesComment $comment) {
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
			$desipagecomment = new DesiMoviesComment;
			$desipagecomment->desi_movie_id = $request->model_id;
			$desipagecomment->comment = $request->comment;
			$desipagecomment->reply_id = $comment->id ? $comment->id : 0;
			$desipagecomment->user_id = Auth::user() ? Auth::user()->id : 0;
			$desipagecomment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'Desi Movies Ad',
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
