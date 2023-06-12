<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventCategory;
use App\NationalEvent;
use App\NationalEventComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class NationalEventController extends Controller {

	public $meta_tags = array(
		'title' => 'National Events',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our National Events and stay updated with the latest posts.',
		'twitter_title' => 'National Events',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);

	public function index(Request $request, $slug) {

		$category = EventCategory::where('name', 'like', base64_decode($slug))->firstOrFail();
		if ($request->req_state) {
			if ($category) {
				$query = Event::selectRaw('events.*,states.country_id, cities.name as city_name')
					->leftJoin('states', 'states.code', 'events.state_code')
					->leftJoin('cities', 'cities.id', 'events.city_id')
					->where('events.category', $category->id)
					->where_in('events.status', ['Active', 1])

					->orderBy('id', 'DESC');
			}

			$country_id = $request->req_country ? $request->req_country['id'] : 1;
			$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
			// $query->where('events.country', $country_id);
			if ($request->req_state) {
				$place_name = $request->req_state['name'];
				$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', events.state_code)");
				$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
			} else {
				$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
					->leftJoin('states', 'states.code', 'cities.state_code')
					->where('states.country_id', $country_id)->limit(10);
			}

			if ($request->city_code) {
				$citys->where('cities.id', $request->city_code);
				$query->where('events.city_id', $request->city_code);
			}

			if ($request->filter_name) {
				$query->where('events.title', 'like', '%' . $request->filter_name . '%');
			}

			$data['cities'] = $citys->get();

			$data['event'] = $query->groupby('national_events.id')->paginate(15);
		} else {

			if ($category) {
				$query = NationalEvent::selectRaw('national_events.*,states.country_id, cities.name as city_name')
					->leftJoin('states', 'states.code', 'national_events.state_code')
					->leftJoin('cities', 'cities.id', 'national_events.city_id')
					->where('national_events.category', $category->id)
					->orderBy('id', 'DESC');
			}

			$country_id = $request->req_country ? $request->req_country['id'] : 1;
			$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
			$query->where('national_events.country', $country_id);

			if ($request->req_state) {
				$place_name = $request->req_state['name'];
				$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', national_events.state_code)");
				$citys = \App\City::where('state_code', $request->req_state['code'])->limit(10);
			} else {
				$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id ,states.name as state_name')
					->leftJoin('states', 'states.code', 'cities.state_code')
					->where('states.country_id', $country_id)->limit(10);
			}

			if ($request->city_code) {
				$citys->where('cities.id', $request->city_code);
				$query->where('national_events.city_id', $request->city_code);
			}

			if ($request->filter_name) {
				$query->where('national_events.title', 'like', '%' . $request->filter_name . '%');
			}

			$data['cities'] = $citys->get();

			$data['event'] = $query->groupby('national_events.id')->paginate(15);
		}

		$data['meta_tags'] = $this->meta_tags;

		$data['sulg'] = $slug;

		// echo "<pre>";

		//// print_r($data);
		// exit;
		return view('front.nationalevent.list', $data);
	}

	public function getdata(Request $request, $slug) {
		// echo $slug;
		// echo "<br>";
		// echo $this->clean($slug);
		if ($slug == 'asdf') {
			$b = array(
				"adduniversity_topic", "auto_classifieds", "batches", "blogs", "desi_pages", "events", "forums_thread", "national_batches", "new_auto_classifieds",
				"new_blogs", "new_events", "new_forums_thread", "new_national_batches", "new_national_events", "new_news_videos", "new_nris_talk",
				"new_post_free_baby_sitting", "new_post_free_education", "new_post_free_electronics", "new_post_free_garagesale", "new_post_free_job",
				"new_post_free_mypartner", "new_post_free_other", "new_post_free_real_estate", "new_post_free_roommates", "new_post_free_stuff",
				"new_university_student_talk", "new_videos", "news_videos", "nris_talk", "post_free_baby_sitting", "post_free_education",
				"post_free_electronics",
				"post_free_garagesale", "post_free_mypartner", "post_free_other", "post_free_real_estate",
				"post_free_roommates", "post_free_stuff", "university_student_talk", "videos",

			);

// name

			$b = array('auto_colors', 'auto_makes', 'baby_sitting_categories', 'batches_categories', 'batches_category', 'blogs_categoires', 'casinos', 'categories',
				'desi_pages_cat', 'education_teaching_categories', 'electronic_categories', 'events_category',
				'forums_categoires', 'forums_parent_categoires', 'garagesale_categoires', 'groceries', 'job_categories', 'mypartner_categories',
				'realestate_categoires', 'restaurants', 'room_mate_categoires', 'sports', 'temples', 'theaters');

			$b = array('post_free_job');

// 'carpool',issue
// 'city_movies',will be like old

			// 'participating_businesses', -> skiiped

			// "post_free_job", ->skipped due to large data

			foreach ($b as $k => $v) {
				$a = DB::table($v)->get();
				// echo "<pre>";
				// print_R($a);

				// if(!isset($a[0]->url_slug))

				// {
				//       $q= " ALTER  table $v  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `name`";
				//       DB::select($q);
				// }

				foreach ($a as $k => $v1) {
					DB::table($v)
						->where('id', $v1->id)
						->update(['url_slug' => $this->clean($v1->title)]);
				}

//title
// $ABC = DB::select("

// UPDATE $v u1 JOIN ( SELECT title, COUNT(*) AS cnt, GROUP_CONCAT(id ORDER BY id) AS ids FROM $v GROUP BY title HAVING COUNT(*) > 1 )
// AS u2 ON u1.title = u2.title SET u1.title = CONCAT(u1.title, '-', FIND_IN_SET(u1.id, u2.ids))

// ") ;

//name
// $ABC = DB::select("

// UPDATE $v u1 JOIN ( SELECT name, COUNT(*) AS cnt, GROUP_CONCAT(id ORDER BY id) AS ids FROM $v GROUP BY name HAVING COUNT(*) > 1 )
// AS u2 ON u1.name = u2.name SET u1.name = CONCAT(u1.name, '-', FIND_IN_SET(u1.id, u2.ids))
// ") ;

// uniq

//  $ABC = DB::select("alter table $v   CHANGE `name` `name` VARCHAR(700) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL");

//  $ABC = DB::select("alter table $v  add UNIQUE(name)");
				print_r($v);
				echo "<br>";
				echo "done";

			}
			exit;
			//   echo "<pre>";
			// foreach($a as $k=>$v){
			// $event = NationalEvent::findOrNew($v->id);
			// $event->url_slug = $this->clean($v->title);
			// $event->save();
			// }
		}

		// $explode = explode('-', $slug);
		// if((int)end($explode) > 0){
		//      $id = (int)end($explode);
		//       array_pop($explode);
		// }

		$url_slug = $this->clean($slug);
		// echo  $url_slug;
		// exit;
		$data = $request->all();

		if ($request->req_state) {
			$query = Event::selectRaw('events.*,events_category.name as cat_name,states.country_id,cities.name as city_name')
				->leftJoin('states', 'states.code', 'events.state_code')
				->leftJoin('cities', 'cities.id', 'events.city_id')
				->leftJoin('events_category', 'events_category.id', 'events.category')
			// ->where('events.id', $id);
				->where('national_events.url_slug', $url_slug);

			$country_id = $request->req_country ? $request->req_country['id'] : 1;
			$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
			// $query->where('events.country', $country_id);

			if ($request->req_state) {
				$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', events.state_code)");
				$place_name = $request->req_state['name'];
			}

//             print_r(DB::getQueryLog());
// exit;
		} else {
			$query = NationalEvent::selectRaw('national_events.*,events_category.name as cat_name,states.country_id,cities.name as city_name')
				->leftJoin('states', 'states.code', 'national_events.state_code')
				->leftJoin('cities', 'cities.id', 'national_events.city_id')
				->leftJoin('events_category', 'events_category.id', 'national_events.category')
			// ->where('national_events.id', $id);
				->where('national_events.url_slug', $url_slug);
			$country_id = $request->req_country ? $request->req_country['id'] : 1;
			$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
			$query->where('national_events.country', $country_id);
			if ($request->req_state) {
				$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', national_events.state_code)");
				$place_name = $request->req_state['name'];
			}

		}
		//   echo   $query->toSql();

		//   echo    $url_slug ;
		//   exit;

		$data['event'] = $query->firstOrFail();
		$id = $query->first()->id;
		Event::find($id)->increment('total_views', 1);

		NationalEvent::find($query->first()->id)->increment('total_views', 1);

		// array_pop($explode);
		//   if(str_replace('at','',$this->clean(implode(' ', $explode ))) != str_replace('at','',$this->clean($data['event']->title)) ){
		//       echo $this->clean(implode(' ', $explode ));echo "<br>";echo  $this->clean($data['event']->title) ;

		//       echo "<br>";
		//       echo str_replace('at','',$this->clean(implode(' ', $explode )));echo "<br>";echo  str_replace('at','',$this->clean($data['event']->title)) ;

		//                 return abort(404);
		//     }

		$data['comments'] = NationalEventComment::selectRaw('events_comment.*, users.profile_photo, users.first_name, users.last_name')->leftJoin("users", "users.id", "user_id")->where('event_id', $data['event']->id)->where('reply_id', 0)->orderBy('created_at', 'desc')->paginate(5);

		$data['meta_tags'] = array(
			'meta_title' => $data['event']->meta_title,
			'meta_description' => $data['event']->meta_description,
			'meta_keywords' => $data['event']->meta_keywords,
			'title' => $data['event']->title,
			'description' => $data['event']->details,
			'twitter_title' => $data['event']['title'],
			'image_' => $data['event']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		$doc = new \DOMDocument ();
		$doc->substituteEntities = false;
		$content = mb_convert_encoding($data['event']->details, 'html-entities', 'utf-8');
		@$doc->loadHTML($content);
		$sValue = $doc->saveHTML();
		$data['detail'] = $sValue;

		return view('front.nationalevent.view', $data);
	}

	public function submitForm(Request $request, NationalEventComment $comment) {
		$data = $request->all();

		if ($request->event_id) {
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
			$student = new NationalEventComment();
			$student->event_id = $request->model_id;
			$student->comment = $request->comment;
			$student->user_id = Auth::user()->id;
			$student->reply_id = $comment->id ? $comment->id : 0;
			$student->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'National Enevt Ad',
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