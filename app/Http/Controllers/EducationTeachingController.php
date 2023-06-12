<?php

namespace App\Http\Controllers;
use App\EducationTeachingCategory;
use App\EducationTeachingClassified;
use App\EducationTeachingComment;
use App\Http\Controllers\HomeController;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class EducationTeachingController extends Controller {
	private $meta_tags = array(
		'title' => 'EducationTeaching',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our EducationTeaching and stay updated with the latest posts.',
		'twitter_title' => 'EducationTeaching',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);
	public $ad_types = ['create_free_ad' => 'Create Free Ad', 'create_premium_ad' => 'Create Premium Ad'];

	public function index(Request $request, $slug = "") {
		$query = EducationTeachingClassified::selectRaw('post_free_education.*,education_teaching_categories.name as category_name,cities.name as city_name')
			->leftJoin('cities', 'cities.id', 'post_free_education.city')
			->leftJoin('education_teaching_categories', 'education_teaching_categories.id', 'post_free_education.category')
			->orderBy('post_free_education.id', 'DESC')
			->where(array('post_free_education.display_status' => 1));

		//
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$query->where('post_free_education.country', $country_id);

		if ($request->req_state) {
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_education.states)");
				// $q->orWhere('post_free_education.states_details', 'ALL');
			});

			$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->where('states.country_id', $country_id)->limit(10);
		}

		if ($request->city_code) {
			$citys->where('cities.id', $request->city_code);
			$query->where('post_free_education.city', $request->city_code);
		}

		$data['cities'] = $citys->get();
		//

		if ($request->filter_name) {
			$query->where('post_free_education.title', 'like', '%' . $request->filter_name . '%');
		}

		if ($slug) {
			$query->where('education_teaching_categories.slug', $slug);
			$data['category_type'] = $slug;
		} else {
			$data['category_type'] = '';
		}

		$data['lists'] = $query->orderby('created_at', 'desc')->paginate(15);
		$data['category'] = EducationTeachingCategory::all();
		$data['meta_tags'] = $this->meta_tags;

		$data['adv'] = HomeController::getSideAds(4);

// echo "<pre>";
// print_R($data['adv']);
// echo "</pre>";

// exit;
		return view('front.educationteaching.list', $data);
	}

	public function getdata(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);

		$data = $request->all();
		$query = EducationTeachingClassified::selectRaw('education_teaching_comment.comment as comment,post_free_education.*,education_teaching_categories.name as category_name,cities.name as city_name')
			->leftJoin('cities', 'cities.id', 'post_free_education.city')
			->leftJoin('education_teaching_comment', 'education_teaching_comment.education_id', 'post_free_education.id')
			->leftJoin('education_teaching_categories', 'education_teaching_categories.id', 'post_free_education.category')
			->orderBy('education_teaching_comment.id', 'DESC')
			->where(array('post_free_education.id' => $id));

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$query->where('post_free_education.country', $country_id);

		if ($request->req_state) {
			$query->where(function ($q) use ($request) {
				$q->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', post_free_education.states)");
				$q->orWhere('post_free_education.states_details', 'ALL');
			});
		}

		if (auth()->check()) {
			// $data['list'] = $query->where('post_free_education.user_id',Auth::user()->id)->firstOrFail();
			$data['list'] = $query->where('display_status', 1)->firstOrFail();
		} else {
			$data['list'] = $query->where('display_status', 1)->firstOrFail();
		}
		// $data['list'] = $query->firstOrFail();

		EducationTeachingClassified::find($id)->increment('total_views', 1);

		$data['comments'] = EducationTeachingComment::selectRaw('education_teaching_comment.*, users.profile_photo, users.first_name, users.last_name')->leftJoin("users", "users.id", "user_id")->where('education_id', $data['list']->id)->where('reply_id', 0)->paginate(5);

		$data['meta_tags'] = array(
			'meta_title' => $data['list']->meta_title,
			'meta_description' => $data['list']->meta_description,
			'meta_keywords' => $data['list']->meta_keywords,
			'title' => $data['list']->title,
			'description' => $data['list']['comment'],
			'twitter_title' => $data['list']['title'],
			'image_' => $data['list']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.educationteaching.view', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = EducationTeachingClassified::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, EducationTeachingComment $comment) {
		$json = array();
		$data = $request->all();

		if ($request->edu_id) {
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

		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$relcomment = new EducationTeachingComment;
			$relcomment->education_id = (int) $request->model_id;
			$relcomment->reply_id = $comment->id ? $comment->id : 0;
			$relcomment->user = $request->name ? $request->name : Auth::user()->name;
			$relcomment->user_id = Auth::user()->id;
			$relcomment->comment = $request->comment;
			$relcomment->email = $request->email ? $request->email : Auth::user()->email;
			$relcomment->save();

			\Session::flash('success', 'Comment Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}

	public function createAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();
		$ad_types = $this->ad_types;

		$data['ad'] = EducationTeachingClassified::findOrNew($id ? base64_decode($id) : 0);
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

		$data['categories'] = EducationTeachingCategory::all();
		$data['meta_tags'] = $this->meta_tags;

		return view('front.educationteaching.create', $data);
	}

	public function sumbitAd(Request $request, $ad_type, $id = null) {
		// echo "<pre>";
		// print_R($_POST);
		// exit;
		$data = $request->all();

		$success_text = $ad_type == 'update_ad' ? 'Update Ad' : ($ad_type == 'create_free_ad' ? 'Free Ad' : 'Premium Ad'); //

		$education = EducationTeachingClassified::findOrNew($id ? base64_decode($id) : 0);
		$adtype = $education->id ? "updated" : "created";
		if ($id) {
			$ad = $education->post_type;
		} else {
			$ad = $ad_type == 'create_free_ad' ? '1' : '2';
		}

		$rules = array(
			'title' => 'required|min:5', //|unique:post_free_education,title,'.$education->id,
			'images' => 'array|min:1|max:10',
			'description' => 'required',
			'category' => 'required',
			'next_date' => 'date',
			// 'url' => 'url',
			'contact_name' => 'required|min:3|max:50',
			// 'contact_number' => 'numeric|min:10',
			'email' => 'required|email',
			'states_details' => 'required',
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
			$matchingRecords = EducationTeachingClassified::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $education->title) {
					$education->title = $new_title;
					$education->url_slug = $this->clean($new_title);
				}} else {
				$education->title = $new_title;
				$education->url_slug = $this->clean($new_title);
			}
			$education->message = $data['description'];
			$education->category = $data['category'];
			// $education->url = $data['url'];
			$education->contact_name = $data['contact_name'];
			// $education->contact_number = $data['contact_number'];

			if (strlen($data['url']) > 0) {
				$education->url = $data['url'];
			}
			if (strlen($data['contact_number']) > 0) {
				$education->contact_number = $data['contact_number'];
			}
			if (strlen($data['state_id']) > 0) {
				$education->states = $data['state_id'];
			}

			$education->contact_email = $data['email'];
			//
			$education->states_details = $data['states_details']; //
			$education->city = $data['city_id'];
			$education->end_date = date('Y-m-d', strtotime($data['expiry_date']));
			$education->use_address_on_map = isset($data['use_address_on_map']) ? $data['use_address_on_map'] : 0;
			$education->show_email = isset($data['show_email']) ? $data['show_email'] : 0;
			// $education->isPayed = "N";
			$education->post_type = $ad;
			$education->country = $request->req_country ? $request->req_country['id'] : '1';
			$education->user_id = Auth::user()->id;
			if (Auth::user()->id == 2046 || Auth::user()->id == 2371) {
				$ad_type = 1;
				$education->isPayed = 'Y';
				$education->payment_id = 65;
				$education->display_status = 1;

			}

			$image_count = 1;
			if (isset($data['old']) && count($data['old']) > 0) {
				foreach ($data['old'] as $img) {
					$education->{'image' . $image_count} = $img;
					$image_count++;
				}
			}

			if (isset($data['images']) && count($data['images']) > 0) {
				foreach ($data['images'] as $image) {
					$image_name = uniqname() . '.' . $image->guessExtension();
					$image->move(public_path('upload/education'), $image_name);

					$education->{'image' . $image_count} = $image_name;
					$image_count++;
				}
			}

			$education->save();
			$getid = $education->id;
			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Education & Teaching',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $success_text,
			);
			sendCommentAlert($mail_data);
			sendNotification("Education & Teaching", array(
				"type" => $adtype,
				"username" => Auth::user()->name,
				"id" => $getid,
			));

			\Session::flash('success', 'your education & teaching ad will be reviewed and live soon hang tight … thank you');
			$json['location'] = $ad_type == 'create_premium_ad' ? route('preadbuy.startPayment', ['ad_id' => base64_encode($education->id), 'model' => base64_encode('EducationTeachingClassified')]) : route('front.profile.my_ads');
		}
		return $json;
	}
	public function deleteAd(Request $request, $id) {
		$real = EducationTeachingClassified::findOrFail(base64_decode($id));
		if ($real->user_id == Auth::user()->id) {
			$real->delete();
			\Session::flash('success', 'Education & Teaching Ad Deleted Successfully.');
		} else {
			\Session::flash('error', 'You are not authorized to delete this Education & Teaching Ad.');
		}
		return redirect()->back();
	}
}