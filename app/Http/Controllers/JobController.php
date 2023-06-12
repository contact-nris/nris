<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Controllers\HomeController;
use App\JobCategory;
use App\JobClassifieds;
use App\JobComment;
use App\JobRoles;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class JobController extends Controller {
	private $meta_tags = array(
		'title' => 'Job Ads in %s',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Job and stay updated with the latest posts.',
		'twitter_title' => 'Job',
		'image_' => '',
		'keywords' => 'Indian websites in %s, NRI websites, Indian community websites, classified website for NRIS in %s, free ads website',
	);
	public $ad_types = ['create_free_ad' => 'Create Free Ad', 'create_premium_ad' => 'Create Premium Ad'];

	public function index(Request $request, $slug = "") {
		$data = $request->all();

		$query = JobClassifieds::selectRaw('post_free_job.*,states.country_id, cities.name as city_name, job_categories.name as category_name_en')
			->leftJoin(
				'states',
				'states.code',
				'post_free_job.states'
			)
			->leftJoin(
				'cities',
				'cities.id',
				'post_free_job.city'
			)
			->leftJoin(
				'job_categories',
				'job_categories.id',
				'post_free_job.category'
			)
			->where(
				array('post_free_job.display_status' => 1)
			)->where('post_free_job.user_id', '>', 0);
		// ->orderBy('post_free_job.total_views', 'asc');

		//
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_job.country', $country_id);

		if ($request->req_state) {
			$place_name = $request->req_state['name'];
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_job.states)");
				$q->orWhere('post_free_job.states_details', 'ALL');
			});
			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('post_free_job.city', $request->city_code);
		}

		$data['cities'] = $citys->get();
		//

		if ($slug) {
			$query->where('job_categories.slug', $slug);
			$data['category_type'] = $slug;
		} else {
			$data['category_type'] = '';
		}

		if ($request->filter_name) {
			$query->where('post_free_job.title', 'like', '%' . $request->filter_name . '%');
		}

		$data['lists'] = $query->orderBy('id', 'DESC')->paginate(20);

		$data['page_type'] = $request->req_state ? 'state' : 'country';
		$data['restaturant_category'] = \App\RestaurantType::all();
		$data['job_category'] = \App\JobCategory::all();
		$data['temples_category'] = \App\TempleType::all();
		$data['pubs_category'] = \App\PubType::all();
		$data['theater_category'] = \App\TheaterType::all();

		$data['category'] = JobCategory::all();
		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
		$data['adv'] = HomeController::getSideAds(11);

		return view('front.job.list', $data);
	}

	public function getdata(Request $request, $slug) {
// 		$explode = explode('-', $slug);
// 		$id = (int) end($explode);
		$data = $request->all();
		$url_slug = $this->clean($slug);
		// echo $url_slug;
		// exit;
// 		$a = JobClassifieds::where('id', $id)->pluck('user_id');
		// $b = JobClassifieds::where('user_id',  $a[0])->where('id' ,'!=' ,$id)->limit(1)->pluck('id');
		// if(!isset($b[0])){
		//   $b[0] = 0;
		// }
		$query = JobClassifieds::selectRaw('post_free_job.*,states.country_id, cities.name as city_id,job_categories.name as category_name_en')
			->leftJoin('states', 'states.code', 'post_free_job.states')
			->leftJoin('cities', 'cities.id', 'post_free_job.city')
			->leftJoin('job_categories', 'job_categories.id', 'post_free_job.category')
		// ->whereIn('post_free_job.id',[$id,$b[0]]);
// 			->where('post_free_job.id', $id)
			->where('post_free_job.url_slug', $url_slug)
			->where('post_free_job.user_id', '>', 0);

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		$query->where('post_free_job.country', $country_id);

		if ($request->req_state) {

			$place_name = $request->req_state['name'];
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_job.states)");
				$q->orWhere('post_free_job.states_details', 'ALL');
			});
		}
		$data['list2'] = '';
		if (auth()->check()) {
// 			$query->orWhere('user_id', Auth::user()->id);
			$data['job'] = $query->Where('display_status', 1)->firstOrFail();
			// if($b[0] != 0){
			//   $data['list2'] = $query->where('display_status',1)->where('post_free_job.id',$b[0])->limit(1)->firstOrFail();
			// }

		} else {
			$data['job'] = $query->where('display_status', 1)->firstOrFail();
			//       if($b[0] != 0){
			//      $data['list2'] = $query->where('display_status',1)->where('post_free_job.id',$b[0])->limit(1)->firstOrFail();
			//  }
		}
		//	$data['job'] = $query->firstOrFail();

		$data['comments'] = JobComment::selectRaw('job_comments.*, users.profile_photo, users.first_name, users.last_name')->leftJoin("users", "users.id", "user_id")->where('jobs_id', $data['job']->id)->where('reply_id', 0)->paginate(5);

		JobClassifieds::find($data['job']->id)->increment('total_views', 1);

		$data['meta_tags'] = array(
			'meta_title' => $data['job']->meta_title,
			'meta_description' => $data['job']->meta_description,
			'meta_keywords' => $data['job']->meta_keywords,
			'title' => $data['job']->title,
			'description' => $data['job']['message'],
			'twitter_title' => $data['job']['title'],
			'image_' => $data['job']->image_url,
			'keywords' => str_replace('%s', $place_name, $this->meta_tags['keywords']),
		);
// echo " <pre>";
//         print_R($data);
// exit;
		return view('front.job.view', $data);
	}

	public function submitForm(Request $request, JobComment $comment) {
		$data = $request->all();
		if ($request->jobs_id) {
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
			$jobcomment = new JobComment;
			$jobcomment->jobs_id = $request->model_id;
			$jobcomment->user_id = Auth::user()->id;
			$jobcomment->user = $request->name ? $request->name : Auth::user()->name;
			$jobcomment->email = $request->email ? $request->email : Auth::user()->email;
			$jobcomment->reply_id = $comment->id ? $comment->id : 0;
			$jobcomment->comment = $request->comment;
			$jobcomment->save();

			\Session::flash('success', 'Comment Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}

	public function createAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();
		$ad_types = $this->ad_types;

		$data['ad'] = JobClassifieds::findOrNew($id ? base64_decode($id) : 0);
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

		$data['job_roles'] = JobRoles::selectRaw('job_cat_id,role,id')->get()->toArray();
		$data['categories'] = JobCategory::all();
		$data['meta_tags'] = $this->meta_tags;

		return view('front.job.create', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = JobClassifieds::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function sumbitAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();

		$success_text = $ad_type == 'update_ad' ? 'Update Ad' : ($ad_type == 'create_free_ad' ? 'Free Ad' : 'Premium Ad'); //
		$job = JobClassifieds::findOrNew($id ? base64_decode($id) : 0);
		$adtype = $job->id ? "updated" : "created";
		$job_roles = JobRoles::where('job_cat_id', $data['category'])->pluck('id')->toArray();
		if ($id) {
			$ad = $job->post_type;
		} else {
			$ad = $ad_type == 'create_free_ad' ? '1' : '2';
		}
		$rules = array(
			'title' => 'required|min:5', //|unique:post_free_job,title,'.$job->id,
			'images' => 'array|min:1|max:10',
			'description' => 'required',
			'category' => 'required',
			'job_role' => 'required|in:' . implode(',', $job_roles),
			'employment_type' => 'required',
			// 'job_ref_id' => 'required',
			'next_date' => 'date',
			// 'url' => 'url',
			'contact_name' => 'required|min:3|max:50',
			// 'contact_number' => 'numeric|min:10',
			'email' => 'required|email',
			'states_details' => 'required',
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
			if (strlen($data['state_id']) == 0) {
				$data['state_id'] = NULL;
			} else {
				$data['state_id'] = 'asdf';
			}

			$matchingRecords = JobClassifieds::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $job->title) {
					$job->title = $new_title;
					$job->url_slug = $this->clean($new_title);
				}} else {
				$job->title = $new_title;
				$job->url_slug = $this->clean($new_title);
			}

			//$job->title = $data['title'];
			$job->message = $data['description'];
			$job->category = $data['category'];
			$job->job_role = $data['job_role'];
			$job->emp_type = $data['employment_type'];
			$job->job_ref_id = $data['job_ref_id'];
			// $job->url = $data['url'];
			$job->contact_name = $data['contact_name'];
			//  $job->contact_number = $data['contact_number'];

			if (strlen($data['url']) > 0) {
				$job->url = $data['url'];
			}
			if (strlen($data['contact_number']) > 0) {
				$job->contact_number = $data['contact_number'];
			}

			$job->contact_email = $data['email'];
			// $job->states = $data['state_id'];

			if (strlen($data['state_id']) > 0) {
				$job->states = $data['state_id'];
			} //
			$job->states_details = $data['states_details']; //
			$job->city = $data['city_id'];
			$job->end_date = date('Y-m-d', strtotime($data['expiry_date']));
			$job->use_address_on_map = isset($data['use_address_on_map']) ? $data['use_address_on_map'] : 0;
			$job->show_email = isset($data['show_email']) ? $data['show_email'] : 0;
			// $job->isPayed = "N";
			$job->post_type = $ad;
			$job->country = $request->req_country ? $request->req_country['id'] : '1';
			$job->user_id = Auth::user()->id;
			if (Auth::user()->id == 2046 || Auth::user()->id == 2371) {
				$ad_type = 1;
				$job->isPayed = 'Y';
				$job->payment_id = 65;
				$job->display_status = 1;

			}

			$image_count = 1;
			if (isset($data['old']) && count($data['old']) > 0) {
				foreach ($data['old'] as $img) {
					$job->{'image' . $image_count} = $img;
					$image_count++;
				}
			}

			if (isset($data['images']) && count($data['images']) > 0) {
				foreach ($data['images'] as $image) {
					$image_name = uniqname() . '.' . $image->guessExtension();
					$image->move(public_path('upload/job'), $image_name);

					$job->{'image' . $image_count} = $image_name;
					$image_count++;
				}
			}

			$job->save();
			$getid = $job->id;
			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Job Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $success_text,
			);
			sendCommentAlert($mail_data);
			sendNotification("Jobs", array(
				"type" => $adtype,
				"username" => Auth::user()->name,
				"id" => $getid,
			));

			\Session::flash('success', 'your job ad will be reviewed and live soon hang tight … thank you');
			$json['location'] = $ad_type == 'create_premium_ad' ? route('preadbuy.startPayment', ['ad_id' => base64_encode($job->id), 'model' => base64_encode('JobClassifieds')]) : route('front.profile.my_ads');
		}
		return $json;
	}
	public function deleteAd(Request $request, $id) {
		$real = JobClassifieds::findOrFail(base64_decode($id));
		if ($real->user_id == Auth::user()->id) {
			$real->delete();
			\Session::flash('success', 'Job Ad Deleted Successfully.');
		} else {
			\Session::flash('error', 'You are not authorized to delete this Job Ad.');
		}
		return redirect()->back();
	}

}