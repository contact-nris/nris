<?php

namespace App\Http\Controllers;
use App\Http\Controllers\HomeController;
use App\RealEstate;
use App\RealestateCategory;
use App\RealEstateComment;
use App\State;
use Auth;
use Illuminate\Http\Request;
use Validator;

class RealEstateController extends Controller {
	private $meta_tags = array(
		'title' => 'Real Estate Ads in %s',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our RealEstate and stay updated with the latest posts.',
		'twitter_title' => 'RealEstate',
		'image_' => '',
		'keywords' => 'real estate ads in %s, post real estate ads in %s, free real estate classified ads, post real estate ad in %s, property ads posting sites',
	);
	public $ad_types = ['create_free_ad' => 'Create Free Add', 'create_premium_ad' => 'Create Premium Add'];

	public function index(Request $request, $slug = '') {
		$query = RealEstate::selectRaw('post_free_real_estate.*,realestate_categoires.name as category_name')
			->leftJoin('states', 'states.code', 'post_free_real_estate.states')
			->leftJoin('cities', 'cities.id', 'post_free_real_estate.city')
			->leftJoin('realestate_categoires', 'realestate_categoires.id', 'post_free_real_estate.category_id')
			->orderBy('post_free_real_estate.id', 'DESC')
			->where(array('post_free_real_estate.display_status' => 1));

		//
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_real_estate.country', $country_id);

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_real_estate.states)");
				$q->orWhere('post_free_real_estate.states_details', 'ALL');
			});
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(50);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(50);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('post_free_real_estate.city', $request->city_code);
		}

		$data['cities'] = $citys->get();

		if ($request->filter_name) {
			$query->where('post_free_real_estate.title', 'like', '%' . $request->filter_name . '%');
		}

		if ($slug) {
			$query->where('realestate_categoires.slug', $slug);
			$data['category_type'] = $slug;
		} else {
			$data['category_type'] = '';
		}

		$data['lists'] = $query->orderBy('created_at', 'desc')->paginate(20);
		$data['category'] = RealestateCategory::all();
		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
		$data['adv'] = HomeController::getSideAds(4);

		return view('front.realestate.list', $data);
	}

	public function getdata(Request $request, $slug) {
// 		$explode = explode('-', $slug);
// 		$id = (int) end($explode);
		$url_slug = $this->clean($slug);
		$data = $request->all();
// echo 	$url_slug;
// exit;
// 		$a = RealEstate::where('id', $id)->pluck('user_id');
// 		$b = RealEstate::where('user_id', $a[0])->where('id', '!=', $id)->where('display_status', 1)->limit(1)->pluck('id');
// 		if (!isset($b[0])) {
// 			$b[0] = 0;
// 		}

// echo "$b[0]";
// exit;

		$query = RealEstate::selectRaw('post_free_real_estate.*,realestate_categoires.name as category_name,cities.name as city_name, realestate_categoires.slug as category_slug')
			->leftJoin('cities', 'cities.id', 'post_free_real_estate.city')
			->leftJoin('realestate_categoires', 'realestate_categoires.id', 'post_free_real_estate.category_id')
		// ->where(array('post_free_real_estate.id'=>$id));
// 			->whereIn('post_free_real_estate.id', [$id, $b[0]]);			
->where('post_free_real_estate.url_slug', $url_slug);

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_real_estate.country', $country_id);

		if ($request->req_state) {
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_real_estate.states)");
				$q->orWhere('post_free_real_estate.states_details', 'ALL');
			});
			$place_name = $request->req_state['name'];
		}
		$data['list2'] = '';

		if (auth()->check()) {
			//$data['list'] = $query->where('user_id',Auth::user()->id)->firstOrFail();
			$data['list'] = $query->where('display_status', 1)->firstOrFail();
		} else {
			$data['list'] = $query->where('display_status', 1)->firstOrFail();
		}

		// if(auth()->check()){
		//     //$data['list'] = $query->where('user_id',Auth::user()->id)->firstOrFail();
		//      $data['list'] = $query->where('display_status',1)->firstOrFail();

		//        if($b[0] != 0){
		//        $data['list2'] = $query->where('post_free_real_estate.id',$b[0])->firstOrFail();
		//     }

		// } else {

		// }

// $query2 = $query;
// echo $b[0];
//   $data['list'] = $query->where('display_status',1)->firstOrFail();

//    if($b[0] != 0){
//                $data['list2'] = RealEstate::where('post_free_real_estate.id',$b[0])->get();
//             }

		// echo auth()->check();
		// echo "asdf";
		// exit;

		// $data['list'] = $query->firstOrFail();

		$data['comments'] = RealEstateComment::selectRaw('realestate_comments.*, users.profile_photo, users.first_name, users.last_name')->leftJoin("users", "users.id", "user_id")->where('real_estate_id', $data['list']->id)->where('reply_id', 0)->paginate(5);

		// echo '<pre>';
		// print_r($data['comments']);die;
		// echo '</pre>';

		RealEstate::find($query->first()->id)->increment('total_views', 1);

		$data['meta_tags'] = array(
			'meta_title' => $data['list']->meta_title,
			'meta_description' => $data['list']->meta_description,
			'meta_keywords' => $data['list']->meta_keywords,
			'title' => $data['list']->title,
			'description' => $data['list']->message,
			'twitter_title' => $data['list']['title'],
			'image_' => $data['list']->image_url,
			'keywords' => str_replace('%s', $place_name, $this->meta_tags['keywords']),
		);

		return view('front.realestate.view', $data);
	}

	public function submitForm(Request $request, RealEstateComment $comment) {
		$data = $request->all();
		if ($request->real_id) {
			$rules = array(
				'user' => 'required',
				'email' => 'required',
				'comment' => 'required|min:2',
			);
		} else {
			$rules = array(
				'comment' => 'required|min:2',
				'model_id' => 'required',
			);
		}

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$relcomment = new RealEstateComment;
			$relcomment->real_estate_id = (int) $request->model_id;
			$relcomment->reply_id = $comment->id ? $comment->id : 0;
			$relcomment->user = $request->user ? $request->user : Auth::user()->name;
			$relcomment->user_id = Auth::user()->id;
			$relcomment->comment = $request->comment;
			$relcomment->email = $request->email ? $request->email : Auth::user()->email;
			$relcomment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Real Estate Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $comment->id ? 'Reply' : 'Comment',
			);
			sendCommentAlert($mail_data);

			\Session::flash('success', 'Comment Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}
	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = RealEstate::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}
	public function createAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();
		$ad_types = $this->ad_types;

		$data['ad'] = RealEstate::findOrNew($id ? base64_decode($id) : 0);
		if ($data['ad'] && $id) {
			if ($data['ad']->user_id != Auth::user()->id) {
				return abort(404);
			}
			$ad_types['update_ad'] = 'Update Ad';
		}

		$data['id'] = $id;

		if (!array_key_exists($ad_type, $ad_types)) {
			return abort(404);
		}
		$data['ad_type'] = $ad_type;
		$data['ad_type_text'] = $ad_types[$ad_type];

		$country_id = $data['ad']->country_id ?: ($request->req_country ? $request->req_country['id'] : '1');
		$state_id = $request->req_state ? $request->req_state['id'] : '1';

		$country_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$data['current_state'] = $data['ad']->states ?: State::find($state_id)->code;
		$data['states_list'] = State::selectRaw('code,name')->where('country_id', $country_id)->get()->keyBy('code');
		$data['city_name'] = $data['ad']->city ? \App\City::where('id', $data['ad']->city)->pluck('name')->first() : '';

		$data['user'] = Auth::user();

		$data['states_select'] = [
			$data['current_state'] => 'Current State Only',
			'ALL' => 'All States in ' . $country_name,
			'multiple' => 'Select Multiple States',
		];

		$data['property_types'] = RealestateCategory::all();
		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $country_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $country_name, $data['meta_tags']['keywords']);

		return view('front.realestate.create', $data);

	}

	public function sumbitAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();

		$success_text = $ad_type == 'update_ad' ? 'Update Ad' : ($ad_type == 'create_free_ad' ? 'Free Ad' : 'Premium Ad'); //

		$real = RealEstate::findOrNew($id ? base64_decode($id) : 0);
		$adtype = $real->id ? "updated" : "created";
		if ($id) {
			$ad = $real->post_type;
		} else {
			$ad = $ad_type == 'create_free_ad' ? '1' : '2';
		}
		$rules = array(
			'title' => 'required||min:5', //|unique:post_free_real_estate,title,'.$real->id,
			'images' => 'array|min:1|max:10',
			'description' => 'required',
			'property_type' => 'required',
			'built_year' => 'required|numeric|min:1900|max:' . date('Y'),
			'property_price' => 'required|numeric|min:1',
			'square_feet' => 'required|numeric|min:1',
			'bedrooms' => 'required|numeric|min:1',
			'bathrooms' => 'required|numeric|min:1',
			'other_rooms' => 'required|numeric|min:1',
			'next_date' => 'date',
			// 'url' => 'required|url',
			'contact_name' => 'required|min:3|max:50',
			// 'contact_number' => 'numeric|min:10',
			'email' => 'required|email',
			'states_details' => 'required', //
			'state_id' => 'required',
			'city_id' => 'required',
			'expiry_date' => 'required|date',
			'images.*' => 'image|mimes:jpeg,png,jpg|max:200',
		);
		$rules['state_id'] = $data['states_details'] == 'ALL' ? 'nullable' : 'required';
		$msg = array(
			'city_id.required' => 'The City is not Valid.',
			'state_id.required' => 'The States field is required',
			// 'title.unique' => 'This title is already used',
		);

		$json = array();
		$validator = Validator::make($data, $rules, $msg);

		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = RealEstate::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $real->title) {
					$real->title = $new_title;
					$real->url_slug = $this->clean($new_title);
				}} else {
				$real->title = $new_title;
				$real->url_slug = $this->clean($new_title);
			}
			$real->message = $data['description'];
			$real->category_id = $data['property_type'];
			$real->built_year = $data['built_year'];
			$real->property_price = $data['property_price'];
			$real->square_feet = $data['square_feet'];
			$real->bedrooms = $data['bedrooms'];
			$real->bathrooms = $data['bathrooms'];
			$real->other = $data['other_rooms'];
			$real->next_date = date('Y-m-d', strtotime($data['next_date']));
			// if(strlen($data['url']) > 0){
			//   $real->url = $data['url'];
			// }
			// if(strlen($data['contact_number']) > 0){
			//   $real->contact_number = $data['contact_number'];
			// }

			$real->contact_name = $data['contact_name'];

			$real->contact_email = $data['email'];
			//$real->states = $data['state_id'];

			if (strlen($data['state_id']) > 0) {
				$real->states = $data['state_id'];
			} //

			$real->states_details = $data['states_details']; //
			$real->city = $data['city_id'];
			$real->post_type = $ad;
			$real->end_date = date('Y-m-d', strtotime($data['expiry_date']));
			$real->use_address_on_map = isset($data['use_address_on_map']) ? $data['use_address_on_map'] : 0;
			$real->show_email = isset($data['show_email']) ? $data['show_email'] : 0;
			// $real->isPayed = "N";
			$real->country = $request->req_country ? $request->req_country['id'] : '1';
			$real->user_id = Auth::user()->id;
			if (Auth::user()->id == 2046 || Auth::user()->id == 2371) {
				$ad_type = 1;
				$real->isPayed = 'Y';
				$real->payment_id = 65;
				$real->display_status = 1;

			}
			$image_count = 1;
			if (isset($data['old']) && count($data['old']) > 0) {
				foreach ($data['old'] as $img) {
					$real->{'image' . $image_count} = $img;
					$image_count++;
				}
			}

			if (isset($data['images']) && count($data['images']) > 0) {
				foreach ($data['images'] as $image) {
					$image_name = uniqname() . '.' . $image->guessExtension();
					$image->move(public_path('upload/realestate'), $image_name);

					$real->{'image' . $image_count} = $image_name;
					$image_count++;
				}
			}

			$real->save();
			$getid = $real->id;

			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Real Estate Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $success_text,
			);
			sendCommentAlert($mail_data);
			sendNotification("Real Estate", array(
				"type" => $adtype,
				"username" => Auth::user()->name,
				"id" => $getid,
			));

			\Session::flash('success', 'your realestate ad will be reviewed and live soon hang tight … thank you');
			$json['location'] = $ad_type == 'create_premium_ad' ? route('preadbuy.startPayment', ['ad_id' => base64_encode($real->id), 'model' => base64_encode('RealEstate')]) : route('front.profile.my_ads');
		}

		return $json;
	}

	public function deleteAd(Request $request, $id) {
		$real = RealEstate::findOrFail(base64_decode($id));
		if ($real->user_id == Auth::user()->id) {
			$real->delete();
			\Session::flash('success', 'Real Estate Ad Deleted Successfully.');
		} else {
			\Session::flash('error', 'You are not authorized to delete this Real Estate Ad.');
		}
		return redirect()->back();
	}
}