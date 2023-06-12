<?php

namespace App\Http\Controllers;

use App\CarPool;
use App\CarPoolComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class CarpoolController extends Controller {
	private $meta_tags = array(
		'title' => 'CarPool %s | NRIS',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our CarPool and stay updated with the latest posts.',
		'twitter_title' => 'CarPool',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);

	public function index(Request $request, $slug) {
		$data = $request->all();
		$query = CarPool::selectRaw('carpool.from_city as f_city,carpool.to_city as t_city,carpool.start_date as s_date,carpool.start_time as s_time,c1.name as c1_name,
        c2.name as c2_name')
			->leftJoin('cities as c1', 'c1.id', 'carpool.from_city')
			->leftJoin('cities as c2', 'c2.id', 'carpool.to_city')
			->orderBy('carpool.id', 'desc');

		if ($request->filter_name) {
			$query->where('c1.name', 'like', '%' . $request->filter_name . '%')->orWhere('c2.name', 'like', '%' . $request->filter_name . '%');
		}

		if ($slug) {
			$query->where('carpool.type', 'like', $slug);
		}

		$data['lists'] = $query->paginate(10);
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$data['page_type'] = $request->req_state ? 'state' : 'country';
		$data['restaturant_category'] = \App\RestaurantType::all();
		$data['job_category'] = \App\JobCategory::all();
		$data['temples_category'] = \App\TempleType::all();
		$data['pubs_category'] = \App\PubType::all();
		$data['theater_category'] = \App\TheaterType::all();

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);

		return view('front.carpool.list', $data);
	}

	public function createAd(Request $request, $id = null) {

		$data = $request->all();

		$country_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$data['id'] = $id;
// 		$data['cities'] = \App\City::where('state_code', $request->req_state['code'])->get();
// 		$data['states'] = \App\State::where('country_id', $request->req_country['id'])->get();
		$data['country'] = \App\Country::all();
		  $data['states'] = \App\State::all();
		  $data['cities'] = \App\City::all();

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $country_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $country_name, $data['meta_tags']['keywords']);

		return view('front.carpool.create', $data);
	}

	public function submitAd(Request $request, $id = null) {
		$data = $request->all();
		$carpool = CarPool::findOrNew($id);
		$adtype = $carpool->id ? "updated" : "created";
		$rules = array(
			'carpool_types' => 'required',
			'contact_name' => 'required|min:3|max:50',
			'contact_number' => 'required|min:3|max:50',
			'email' => 'required|email',
			'from_city' => 'required',
			'to_city' => 'required',
			'from_state' => 'required',
			'to_state' => 'required',
			'from_country' => 'required',
			'to_country' => 'required',
			'address' => 'required',
			'start_date' => 'required|date',
			// 'end_date' => 'required|date',
			'start_time' => 'required',
			// 'end_time' => 'required|date_format:h:i A',
		);

		// $msg = array(
		//     'city_id.required' => 'The City is not Valid.',
		//     'state_id.required' => 'The States field is required',
		//     // 'title.unique' => 'This title is already used',
		// );
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$carpool->name = $data['contact_name'];
			$carpool->email = $data['email'];
			$carpool->mobile = $data['contact_number'];
			$carpool->user_id = Auth::user()->id;
			$carpool->type = $data['carpool_types'];
			$carpool->from_state = $data['from_state'];
			$carpool->to_state = $data['to_state'];
			$carpool->country = $data['from_country'];
			$carpool->to_country = $data['to_country'];
			$carpool->from_city = $data['from_city'];
			$carpool->to_city = $data['to_city'];
			$carpool->address = $data['address'];
			$carpool->start_date = $data['start_date'];
			$carpool->end_date = $data['end_date'];
			$carpool->start_time = $data['start_time'];
			$carpool->end_time = $data['end_time'];
			$carpool->flex_date = $data['flex_date'];
			$carpool->flex_time = $data['flex_time'];
			$carpool->flex_location = $data['flex_location'];
			$carpool->save();

			$getid = $carpool->id;

			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'CarPool',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => "Your" . $data['carpool_types'] . " CarPool Add",
			);
			sendCommentAlert($mail_data);

			// sendNotification("Car Pool", array(
			//     "type" => "CarPool"
			//     "username" => Auth::user()->name,
			//     "id" => $getid,
			// ));

			\Session::flash('success', 'Your CarPool Saved Successfully.');
			$json['location'] = route('front.carpool', ['slug' => $request->carpool_types]);
		}

		return $json;
	}

	public function submitForm(Request $request, CarPoolComment $comment) {
		$data = $request->all();
		$rules = array(
			'name' => 'required',
			'email' => 'required',
			'message' => 'required|min:2',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$carcomment = new CarPoolComment;
			$carcomment->carpool_id = $request->carpool_id;
			$carcomment->reply_id = $comment->id ? $comment->id : 0;
			$carcomment->name = $request->name;
			$carcomment->comment = $request->message;
			$carcomment->email = $request->email;
			$carcomment->save();

			\Session::flash('success', 'CarPool Comment Saved Successfully.');
			$json['location'] = route('front.carpool');
		}

		return $json;
	}

}