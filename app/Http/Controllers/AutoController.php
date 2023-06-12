<?php

namespace App\Http\Controllers;

use App\Autobiocomment;
use App\AutoClassified;
use App\AutoColor;
use App\Autocomments;
use App\AutoMake;
use App\AutoModel;
use App\Http\Controllers\HomeController;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AutoController extends Controller {

	private $meta_tags = array(
		'title' => 'Auto in %s',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Auto and stay updated with the latest posts.',
		'twitter_title' => 'Auto',
		'image_' => '',
		'keywords' => 'Indian websites in %s, NRI websites, Indian community websites, classified website for NRIS in %s, free ads website',
	);
	public $ad_types = ['create_free_ad' => 'Create Free Add', 'create_premium_ad' => 'Create Premium Add'];
	public $auto_properties;

	public function __construct() {
		$condition = ['new', 'almost_new', 'excellent', 'fair', 'used', 'salavage', 'wrecked'];
		$transmission = ['automatic', 'manual'];
		$cylinder = ['v4', 'v6', 'v8', 'v10', 'v12', 'other'];
		$type = ['sedan', 'crossover', 'suv', 'mini', 'van', 'truck', 'convertible', 'commercial_vehicle'];
		$drive_train = ['awd', '4_X_4', 'fwd', 'rwd'];

		$this->auto_properties = [
			'condition' => $condition,
			'transmission' => $transmission,
			'cylinder' => $cylinder,
			'type' => $type,
			'drive_train' => $drive_train,
		];
	}

	public function index(Request $request) {
		$query = AutoClassified::selectRaw('
            auto_classifieds.*,
            cities.name as city_name,
            auto_makes.name as auto_makes_name,
            auto_colors.name as color_name,
            auto_models.model_name as model_name')
			->leftJoin('auto_colors', 'auto_colors.code', 'auto_classifieds.color')
			->leftJoin('cities', 'cities.id', 'auto_classifieds.city')
			->leftJoin('auto_makes', 'auto_makes.id', 'auto_classifieds.make')
			->leftJoin('auto_models', 'auto_models.id', 'auto_classifieds.model')
			->orderBy('auto_classifieds.id', 'DESC')
			->where(array('auto_classifieds.display_status' => 1));

		$place_name = $request->req_state ? $request->req_state['name'] : 'USA';
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$query->where('auto_classifieds.country', $country_id);

		if ($request->req_state) {
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', auto_classifieds.states)");
				$q->orWhere('auto_classifieds.states_details', 'ALL');
			});
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$query->where('auto_classifieds.states', '');
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('auto_classifieds.city', $request->city_code);
		}

		$data['cities'] = $citys->get();

		$query->where(function ($q) use ($request) {
			$request->filter_name ? $q->where('auto_classifieds.title', 'like', '%' . $request->filter_name . '%') : '';
			$request->min_year ? $q->orWhere('auto_classifieds.year', '>=', $request->min_year) : '';
			$request->price ? $q->orWhere('auto_classifieds.price', $request->price) : '';
			$request->color ? $q->orWhereIn('auto_colors.id', $request->color) : '';
			$request->condition ? $q->orWhereIn('auto_classifieds.auto_condition', $request->condition) : '';
			$request->transmission ? $q->orWhereIn('auto_classifieds.transmission', $request->transmission) : '';
			$request->cylinder ? $q->orWhereIn('auto_classifieds.cylinder', $request->cylinder) : '';
			$request->type ? $q->orWhereIn('auto_classifieds.type', $request->type) : '';
			$request->drive_train ? $q->orWhereIn('auto_classifieds.drive_train', $request->drive_train) : '';
			$request->make ? $q->orWhere('auto_classifieds.make', $request->make) : '';
			$request->auto_models ? $q->orWhere('auto_classifieds.model', $request->auto_models) : '';
		});

		$data['lists'] = $query->orderby('created_at', 'desc')->paginate(15);
		$data['auto_colors'] = AutoColor::all();
		$data['auto_makes'] = AutoMake::all();
		$data['auto_models'] = AutoModel::selectRaw('auto_make_id,model_name,id')->get()->toArray();

		$data['auto_properties'] = $this->auto_properties;

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
		//  $data['adv'] = $qur_data1->where('home_advertisements.ad_position','Category Left')->where('categories_id', 1)->where('sdate','<=', Carbon::today())->orderBy('home_advertisements.ad_position_no', 'ASC')->limit(10)->get();
		$data['adv'] = HomeController::getSideAds(1);

		return view('front.auto.list', $data);
	}

	public function getdata(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);

		$data = $request->all();
		$a = AutoClassified::where('id', $id)->pluck('user_id');
		$b = AutoClassified::where('user_id', $a[0])->where('id', '!=', $id)->where('display_status', 1)->limit(1)->pluck('id');
		if (!isset($b[0])) {
			$b[0] = 0;
		}

		$query = AutoClassified::selectRaw('auto_classifieds.*,
            cities.name as city_name,
            auto_makes.name as auto_makes_name,
            auto_colors.name as color_name,
            auto_models.model_name as model_name')
			->leftJoin('cities', 'cities.id', 'auto_classifieds.city')
			->leftJoin('auto_colors', 'auto_colors.id', 'auto_classifieds.color')
			->leftJoin('auto_makes', 'auto_makes.id', 'auto_classifieds.make')
			->leftJoin('auto_models', 'auto_models.id', 'auto_classifieds.model')
			->orderBy('auto_classifieds.id', 'DESC')
		// ->where(array('auto_classifieds.id' => $id));
			->whereIn('auto_classifieds.id', [$id, $b[0]]);
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$query->where('auto_classifieds.country', $country_id);

		if ($request->req_state) {
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', auto_classifieds.states)");
				$q->orWhere('auto_classifieds.states_details', 'ALL');
			});
		} else {
			$query->where('auto_classifieds.states', '');
		}

		if (auth()->check()) {
			//$data['list'] = $query->where('user_id',Auth::user()->id)->firstOrFail();
			$data['list'] = $query->where('display_status', 1)->firstOrFail();

		} else {
			$data['list'] = $query->where('display_status', 1)->firstOrFail();

		}

//                $data['list2'] = $query->where('auto_classifieds.id',$b[0])->firstOrFail();

// print_r($data['list2']);
//             exit;
		// $data['list'] = $query->firstOrFail();
		$data['bid_bargin'] = Autobiocomment::where('auto_id', $data['list']->id)->get();

		$data['comments'] = Autocomments::selectRaw('auto_classifieds_comments.*, users.profile_photo, users.first_name, users.last_name')
			->leftJoin("users", "users.id", "user_id")
			->where('auto_id', $data['list']->id)
			->where('reply_id', 0)
			->orderBy('created_at', 'desc')
			->paginate(5);

		AutoClassified::find($id)->increment('total_views', 1);

		$data['meta_tags'] = array(
			'meta_title' => $data['list']->meta_title,
			'meta_description' => $data['list']->meta_description,
			'meta_keywords' => $data['list']->meta_keywords,
			'title' => $data['list']->title,
			'description' => $data['list']['message'],
			'twitter_title' => $data['list']['title'],
			'image_' => $data['list']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

// print_r($data);
		return view('front.auto.view', $data);
	}

	public function submitForm(Request $request, Autocomments $comment) {
		$data = $request->all();
		if ($request->auto_id) {
			$rules = array(
				'name' => 'required',
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
			$autocomment = new Autocomments;
			$autocomment->auto_id = $request->model_id;
			$autocomment->user = $request->name ? $request->name : Auth::user()->name;
			$autocomment->user_id = Auth::user()->id;
			$autocomment->email = $request->email ? $request->email : Auth::user()->email;
			$autocomment->comment = $request->comment;
			$autocomment->reply_id = $comment->id ? $comment->id : 0;
			$autocomment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'National Auto Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $comment->id ? 'Reply' : 'Comment',
			);
			sendCommentAlert($mail_data);
			\Session::flash('success', 'Comment Saved Successfully.');

			$json['reload'] = true;
		}

		return $json;
	}

	public function submitBio(Request $request, Autobiocomment $comment) {
		$data = $request->all();
		$rules = array(
			'name' => 'required',
			'amount' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$autocomment = new Autobiocomment();
			$autocomment->auto_id = $request->auto_id;
			$autocomment->comment = $request->name;
			$autocomment->amount = $request->amount;
			$autocomment->user_id = Auth::user() ? Auth::user()->id : "";
			$autocomment->save();

			\Session::flash('success', 'Auto Bid Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}
	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = AutoClassified::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function createAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();
		$ad_types = $this->ad_types;

		$data['ad'] = AutoClassified::findOrNew($id ? base64_decode($id) : 0);
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

		$data['auto_colors'] = AutoColor::all();
		$data['auto_makes'] = AutoMake::all();
		$data['auto_models'] = AutoModel::selectRaw('auto_make_id,model_name,id')->get()->toArray();

		$data['auto_properties'] = $this->auto_properties;

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $country_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $country_name, $data['meta_tags']['keywords']);

		return view('front.auto.create', $data);
	}

	public function sumbitAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();

		$success_text = $ad_type == 'update_ad' ? 'Update Ad' : ($ad_type == 'create_free_ad' ? 'Free Ad' : 'Premium Ad'); //
		$auto = AutoClassified::findOrNew($id ? base64_decode($id) : 0);
		$adtype = $auto->id ? "updated" : "created";
		if ($id) {
			$ad = $auto->post_type;
		} else {
			$ad = $ad_type == 'create_free_ad' ? '1' : '2';
		}
		$auto_models = AutoModel::where('auto_make_id', $data['auto_makes'])->pluck('id')->toArray();

		$rules = array(
			'title' => 'required|min:5', //|unique:auto_classifieds,title,'.$auto->id,
			'images' => 'array|min:1|max:10',
			'description' => 'required',
			'auto_makes' => 'required',
			'auto_models' => 'in:' . implode(',', $auto_models),
			// 'url' => 'url',
			'price' => 'required|numeric|min:1',
			'contact_name' => 'required|min:3|max:50',
			// 'contact_number' => 'numeric|min:10',
			'email' => 'required|email',
			'states_details' => 'required', //
			'city_id' => 'required',
			'expiry_date' => 'required|date',
			'images.*' => 'image|mimes:jpeg,png,jpg|max:200',
		);
		$rules['state_id'] = $data['states_details'] == 'ALL' ? 'nullable' : 'required';

		$msg = array(
			'city_id.required' => 'The City is not Valid.',
			'state_id.required' => 'The States field is required',
		);

		$json = array();
		$validator = Validator::make($data, $rules, $msg);

		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = AutoClassified::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $auto->title) {
					$auto->title = $new_title;
					$auto->url_slug = $this->clean($new_title);
				}} else {
				$auto->title = $new_title;
				$auto->url_slug = $this->clean($new_title);
			}
			$auto->message = $data['description'];
			$auto->make = $data['auto_makes'];
			$auto->model = $data['auto_models'];
			$auto->color = $data['auto_colors'];
			$auto->auto_condition = $data['condition'];
			$auto->transmission = $data['transmission'];
			$auto->cylinder = $data['cylinder'];
			$auto->type = $data['type'];
			$auto->vin_number = $data['vin_number'];
			$auto->year = $data['year'];
			$auto->mpg = $data['current_mpg'];
			$auto->drive_train = $data['drive_train'];
			$auto->price = $data['price'];
			$auto->odo = $data['odo_meter_reading'];
			//$auto->url = $data['url'];
			$auto->contact_name = $data['contact_name'];
			//$auto->contact_number = $data['contact_number'];

			if (strlen($data['url']) > 0) {
				$auto->url = $data['url'];
			}
			if (strlen($data['contact_number']) > 0) {
				$auto->contact_number = $data['contact_number'];
			}

			if (strlen($data['state_id']) > 0) {
				$auto->states = $data['state_id'];
			}

			$auto->contact_email = $data['email'];
			// $auto->states = $data['state_id'];               //
			$auto->states_details = $data['states_details']; //
			$auto->city = $data['city_id'];
			$auto->end_date = date('Y-m-d', strtotime($data['expiry_date']));
			$auto->use_address_on_map = isset($data['use_address_on_map']) ? $data['use_address_on_map'] : 0;
			$auto->show_email = isset($data['show_email']) ? $data['show_email'] : 0;
			$auto->country = $request->req_country ? $request->req_country['id'] : '1';
			$auto->post_type = $ad;

			// $auto->isPayed = "N";
			$auto->user_id = Auth::user()->id;

			if (Auth::user()->id == 2046 || Auth::user()->id == 2371) {
				$ad_type = 1;
				$auto->isPayed = 'Y';
				$auto->payment_id = 65;
				$auto->display_status = 1;

			}

			$image_count = 1;
			if (isset($data['old']) && count($data['old'])) {
				foreach ($data['old'] as $img) {
					$auto->{'image' . $image_count} = $img;
					$image_count++;
				}
			}

			if (isset($data['images']) && count($data['images'])) {
				foreach ($data['images'] as $image) {
					$image_name = uniqname() . '.' . $image->guessExtension();
					$image->move(public_path('upload/auto'), $image_name);

					$auto->{'image' . $image_count} = $image_name;
					$image_count++;
				}
			}

			$auto->save();
			$getid = $auto->id;
			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'National Auto Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $success_text,
			);
			sendCommentAlert($mail_data);

			sendNotification("Autos", array(
				"type" => $adtype,
				"username" => Auth::user()->name,
				"id" => $getid,
			));

			\Session::flash('success', 'your auto ad will be reviewed and live soon hang tight … thank you');
			$json['location'] = $ad_type == 'create_premium_ad' ? route('preadbuy.startPayment', ['ad_id' => base64_encode($auto->id), 'model' => base64_encode('AutoClassified')]) : route('front.profile.my_ads');
		}
		return $json;
	}

	public function deleteAd(Request $request, $id) {
		$auto = AutoClassified::findOrFail(base64_decode($id));
		if ($auto->user_id == Auth::user()->id) {
			$auto->delete();
			\Session::flash('success', 'Auto Ad Deleted Successfully.');
		} else {
			\Session::flash('error', 'You are not authorized to delete this Auto Ad.');
		}
		return redirect()->back();
	}
}