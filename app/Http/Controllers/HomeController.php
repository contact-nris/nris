<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Citymovie;
use App\Country;
use App\Event;
use App\EventCategory;
use App\HomeAdvertisement;
use App\NationalEvent;
use App\NRITalk;
use App\Restaurant;
use App\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Cache;

class HomeController extends Controller {
	public $meta_tags = array(

		'title' => '%s',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Temple and stay updated with the latest posts.',
		'twitter_title' => 'Home',
		'image_' => '',
		'keywords' => 'Indian websites in %s, NRI websites, Indian community websites, classified website for NRIS in %s, free ads website',
	);
	public $ad_types = ['create_free_ad' => 'Create Free Add', 'create_premium_ad' => 'Create Premium Add'];

	public function index(Request $request) {
// $re = $request->req_country;
// dd($re);
		$data['country_name'] = $request->req_country ? $request->req_country['name'] : 'USA';
		$place_name = $request->req_state ? $request->req_state['name'] : $data['country_name'];
		$data['page_type'] = $request->req_state ? 'state' : 'country';
		$data['place_name'] = $place_name;
		$country_id = $request->req_country ? $request->req_country['id'] : '1';
		session(['country_id' => $country_id]);
		$data['current_country_id'] = $country_id;

//     echo $country_id. $data['page_type'];
//   exit;
		$type = $data['page_type'];
// echo "<h1>'home_data' . $country_id. $type  $place_name </h1>";
		$c = 1;
		if (isset($GET['clearCache'])) {
			$c = 0;
		}

		$c = 0;
// && $c
		if (Cache::has('home_data' . $country_id . $data['page_type'] . $place_name) && $c == 1) {
			echo "<script>console.log('from cahce')</script>";
			// echo "asdf";
			// exit;
			$data = Cache::get('home_data' . $country_id . $data['page_type'] . $place_name);
		} else {
			echo "<script>console.log('no cahce')</script>";
			$data['search'] = [];
			//  $data['search'][] =DB::select("select GROUP_CONCAT(COALESCE(title,'') SEPARATOR '@@') as a  from  post_free_baby_sitting where country = ?",      [$country_id]);
			//  $data['search'][] =DB::select("select GROUP_CONCAT(COALESCE(title,'') SEPARATOR '@@') as a  from  post_free_education where country = ?",      [$country_id]);
			//  $data['search'][] =DB::select("select GROUP_CONCAT(COALESCE(title,'') SEPARATOR '@@') as a  from  post_free_electronics where country = ?",      [$country_id]);
			//  $data['search'][] =DB::select("select GROUP_CONCAT(COALESCE(title,'') SEPARATOR '@@') as a  from  post_free_garagesale where country = ?",      [$country_id]);
			//  $data['search'][] =DB::select("select GROUP_CONCAT(COALESCE(title,'') SEPARATOR '@@') as a  from  post_free_job where country = ?",      [$country_id]);
			//  $data['search'][] =DB::select("select GROUP_CONCAT(COALESCE(title,'') SEPARATOR '@@') as a  from  post_free_mypartner where country = ?",      [$country_id]);
			//  $data['search'][] =DB::select("select GROUP_CONCAT(COALESCE(title,'') SEPARATOR '@@') as a  from  post_free_other where country = ?",      [$country_id]);
			//  $data['search'][] =DB::select("select GROUP_CONCAT(COALESCE(title,'') SEPARATOR '@@') as a  from  post_free_real_estate where country = ?",      [$country_id]);
			//  $data['search'][] =DB::select("select GROUP_CONCAT(COALESCE(title,'') SEPARATOR '@@') as a  from  post_free_roommates where country = ?",      [$country_id]);
			//  $data['search'][] =DB::select("select GROUP_CONCAT(COALESCE(title,'') SEPARATOR '@@') as a  from  post_free_stuff where country = ?",      [$country_id]);
			$data['search_new'] = [];
			// foreach ($data['search'] as $k => $v) {
			//     //  print_R($v[0]->a);
			//     $a = explode('@@', $v[0]->a);
			//     $data['search_new'] = array_merge($data['search_new'], $a);
			// }
			// $data['search_new'] = array_flip($data['search_new']);
			// $data['search_new'] = array_values(array_flip($data['search_new']));
			//   unset($data['search']);
			// echo "<pre>";
			// print_R($data['search_new']);
			// exit;
			$expiresAt = Carbon::now()->addMinutes(10);
			// Cache::put('search_new',   $data['search_new'],   $expiresAt);
			// }
			// $data['states'] = State::where('country_id', $country_id)->get();
			// $data['categories'] = Categories::where('status', 1)->get();
			$state = $request->req_state ? $request->req_state['code'] : '';
			$data['state_name'] = $state;

			// if($request->req_country){
			//     echo "country images";die;
			// }else{
			//     echo "state Images";die;
			// }
			// $bg_image = $request->req_country ? $request->req_country['image'] : Country::selectRaw('image')->where('id', $country_id)->first()->image;
			// $bg_image = $request->req_state ? State::selectRaw('header_image')->where('country_id', $country_id)->first()->header_image : Country::selectRaw('image')->where('id', $country_id)->first()->image;
			// echo '<pre>';
			// print_r($bg_image);
			// echo '</pre>';
			// die;
			// $data['bg_image'] = $request->req_state ? assets_url('upload/state/' . $bg_image) : assets_url('upload/country/' . $bg_image);
			// $country = Country::selectRaw('image')->where('id', $country_id)->first()->image;
			// if ($request->req_state) {
			//     $state = State::selectRaw('header_image')->where('code', $state)->first()->header_image;
			//     if ($state !== "") {
			//         $data['bg_image'] = assets_url('upload/state/' . $state);
			//     } else {
			//         $data['bg_image'] = assets_url('upload/country/' . $country);
			//     }
			// } else {
			//     $data['bg_image'] = assets_url('upload/country/' . $country);
			// }
			// $qur_data = HomeAdvertisement::where('status', 1)->orderby('ad_position_no')->where('sdate', '<=', Carbon::today());
			// if ($request->req_state) {
			//     // echo $request->req_state['id'];
			//     // exit;
			//     $qur_data1 = clone $qur_data;
			//     $qur_data->whereRaw("FIND_IN_SET('" . $request->req_state['id'] . "', home_advertisements.state_id)");
			//     //      $data['top_ads'] = $qur_data3->where('home_advertisements.ad_position','State Top')->where('sdate','<=', Carbon::today())->orderBy('home_advertisements.ad_position_no', 'ASC')->limit(6)->get();
			//     // $data['right_ads'] = $qur_data4->where('home_advertisements.ad_position','State Right')->where('sdate','<=', Carbon::today())->orderBy('home_advertisements.ad_position_no', 'ASC')->limit(3)->get();
			//     $gif_data = $qur_data1->whereIn('ad_position', ['State Top', 'State Right', 'State Left'])->get();
			// } else {
			//     $qur_data1 = clone $qur_data;
			//     $qur_data->where("country_id", $country_id);
			//     // $data['right_ads'] = $qur_data1->where('home_advertisements.ad_position','Right')->where('sdate','<=', Carbon::today())->orderBy('home_advertisements.ad_position_no', 'ASC')->limit(3)->get();
			//     //  $a =  DB::getQueryLog();
			//     //       print_R($a);
			//     // $data['left_ads'] = $qur_data2->where('home_advertisements.ad_position','Left')->where('state_id',0)->where('sdate','<=', Carbon::today())->orderBy('home_advertisements.ad_position_no', 'ASC')->limit(3)->get();
			//     //$data['right_ads'] = $qur_data1->where('home_advertisements.ad_position','Right')->where('state_id',0)->where('sdate','<=', Carbon::today())->orderBy('home_advertisements.ad_position_no', 'ASC')->limit(3)->get();
			//     $gif_data = $qur_data1->whereIn('ad_position', ['Top', 'Right', 'Left', 'State Left', 'State Top', 'State Right'])->get();
			//     // DB::enableQueryLog();
			//     //  echo "aa";
			//     // $data['top_ads'] = $qur_data3->where('home_advertisements.ad_position','Top')->where('state_id',0)->where('sdate','<=', Carbon::today())->orderBy('home_advertisements.ad_position_no', 'ASC')->limit(6)->get();
			//     //     print_R( $data['top_ads']);
			//     //         $a =  DB::getQueryLog();
			//     //  print_R($a);

			// }
			// //   echo "Asdf";
			// // echo "<pre>";
			// // print_R($gif_data );
			// // exit;
			// // $gif_data = array();
			// $data['gif_data'] = array();
			// $data['gif_data']['Left'] = array();
			// $data['gif_data']['Right'] = array();
			// $data['gif_data']['Top'] = array();
			// foreach ($gif_data as $k => $v) {
			//     if (((strpos($v->ad_position, "ht")) || (strpos($v->ad_position, "ft"))) && $v->ad_position_no > 3) {
			//         $data['gif_data']['remvoed'][str_replace('State ', '', $v->ad_position) ][$v->ad_position_no][] = $v->image;
			//     } else {
			//         if (!$v->url) {
			//             $v->url = 'https://nris.com/';
			//         }
			//         $data['gif_data'][str_replace('State ', '', $v->ad_position) ][$v->ad_position_no][] = $v->image . '@3&TdY*!fMKnN#nj=4_E@' . $v->url . '@3&TdY*!fMKnN#nj=4_E@' . $v->id;
			//         //

			//     }
			// }
			// if (isset($_GET['debug'])) {
			//     echo "<pre>";
			//     print_R($data['gif_data']);
			//     exit;
			// }
			// echo "<pre>";
			//  ksort($data['gif_data']['Left']);
			//  ksort($data['gif_data']['Top']);
			//  ksort($data['gif_data']['Right']);
			// print_r($data['gif_data']);
			// exit;
			$data['ads'] = array();
			// $data['ads'] = $qur_data->orderBy('home_advertisements.ad_position_no', 'DESC')->get();
			//$data['top_ads'] =   $qur_data6->where('home_advertisements.ad_position','Top')->where('sdate','<=', Carbon::today())->orderBy('home_advertisements.ad_position_no', 'ASC')->limit(5)->get();
			//$a =  DB::getQueryLog();
			//print_R($a);
			//  DB::enableQueryLog();
			// $data['right_ads'] = $qur_data1->where('home_advertisements.ad_position','Right')->where('sdate','<', Carbon::yesterday())->orderBy('home_advertisements.ad_position_no', 'ASC')->limit(3)->get();
			//  $a =  DB::getQueryLog();
			//       print_R($a);
			//   $data['left_ads'] = $qur_data2->where('home_advertisements.ad_position','Left')->where('sdate','<', Carbon::yesterday())->orderBy('home_advertisements.ad_position_no', 'ASC')->limit(3)->get();
			//    $data['state_top_ads'] = $qur_data3->where('home_advertisements.ad_position','State Top')->where('sdate','<', Carbon::yesterday())->orderBy('home_advertisements.ad_position_no', 'ASC')->limit(5)->get();
			//  $data['state_right_ads'] = $qur_data4->where('home_advertisements.ad_position','State Right')->where('sdate','<', Carbon::yesterday())->orderBy('home_advertisements.ad_position_no', 'ASC')->limit(3)->get();
			//  $data['state_left_ads'] = $qur_data5->where('home_advertisements.ad_position','State Left')->where('sdate','<', Carbon::yesterday())->orderBy('home_advertisements.ad_position_no', 'ASC')->limit(3)->get();
			// echo "<pre>";
			//     print_R($data['right_ads']);
			//         echo "</pre>";
			//  exit;
			// $query = NRITalk::with('comments', 'like_nris')->selectRaw('nris_talk.*')
			// // (SELECT COUNT(nris_talk_reply.id) FROM nris_talk_reply WHERE nris_talk_reply.talk_id = nris_talk.id) as reply_count,
			// // (SELECT COUNT(nris_like.id) FROM nris_like WHERE nris_like.talk_id = nris_talk.id) as like_count ')
			// ->leftJoin('nris_talk_reply', 'nris_talk_reply.talk_id', 'nris_talk.id')->leftJoin('nris_like', 'nris_like.talk_id', 'nris_talk.id')->where('nris_talk.status', '1')->orderBy('nris_talk.id', 'desc');
			// if ($request->req_state) {
			//     $query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', nris_talk.state_code)");
			// }
			// $data['nri_talks'] = $query->limit(8)->get();
			if ($request->req_state) {} else {
				//if(isset($data['gif_data']['Left']) && $data['gif_data']['Left'] !=''){
				//ksort($data['gif_data']['Left']);
				// }

			}
			// ksort($data['gif_data']['Top']);
			// ksort($data['gif_data']['Right']);

			$data['blog_carousal'] = \App\Blog::BlogData(9);
			$data['groceries_carousal'] = \App\Grocery::GroceryData(9, $request->req_state);
			$data['newsvideo_carousal'] = \App\NewsVideo::NewsVideoData(9);
			$data['forums'] = \App\ForumThread::ForumData(10);
			$data['student'] = \App\Uni_Studenttalk::StuTalk(10, $request->req_state);
			$data['movie_rating'] = \App\MovieExternalRating::MovieExternalRatingData(10);
			if ($request->req_state) {
				$data['training_placement'] = \App\Batche::BatchesData(10, $request->req_state);
			} else {
				$data['training_placement'] = \App\NationalBatch::BatcheData(10, $country_id);
			}
			// $data = $this->getstaticdata($place_name);

			// $data['restaturant_category'] = \App\RestaurantType::all();
			// $data['job_category'] = \App\JobCategory::all();
			// $data['temples_category'] = \App\TempleType::all();
			// $data['pubs_category'] = \App\PubType::all();
			// $data['theater_category'] = \App\TheaterType::all();
			$data['meta_tags'] = $this->meta_tags;
			$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
			$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
			$expiresAt = Carbon::now()->addMinutes(1000);

			if ($request->req_state) {
				// print_r( $request->req_state);

				// exit;
				$data['s_info'] = State::select('s_meta_title as meta_title', 's_meta_description as meta_description', 's_meta_keywords as meta_keywords')->where('domain', $request->req_state['domain'])->firstOrFail();
				$data['meta_tags'] = array(
					'meta_title' => $data['s_info']->meta_title,
					'meta_description' => $data['s_info']->meta_description,
					'meta_keywords' => $data['s_info']->meta_keywords,

				);
				$data['gif_data']['Left'] = array();
			} else {
				$data['s_info'] = Country::select('c_meta_title as meta_title', 'c_meta_description as meta_description', 'c_meta_keywords as meta_keywords')->where('id', $country_id)->firstOrFail();
				//  print_r($data['s_info']);
				//  exit;
				$data['meta_tags'] = array(
					'meta_title' => $data['s_info']->meta_title,
					'meta_description' => $data['s_info']->meta_description,
					'meta_keywords' => $data['s_info']->meta_keywords,

				);

			}
			$expiresAt = Carbon::now()->addMinutes(1000);
			Cache::put('home_data' . $country_id . $data['page_type'] . $place_name, $data, $expiresAt);
		}
		if (isset($_GET['test'])) {

			echo "<pre>";
			//   echo  $request->req_state;
			//   echo $request->req_state['id'];
			print_R($data['gif_data']);
			exit;
		}
		return view('front.home', $data);

	}

	public function gifdata(Request $request) {

		// $re = $request->req_country;
// dd($re);

		$c_id = $_POST['c_id'];
		$s_code = $_POST['s_code'];
		$data['sd'] = 1;

// dd($re);
		$data['country_name'] = $request->req_country ? $request->req_country['name'] : 'USA';
		$place_name = $request->req_state ? $request->req_state['name'] : $data['country_name'];
		$data['page_type'] = $request->req_state ? 'state' : 'country';
		$data['place_name'] = $place_name;
		$country_id = $request->req_country ? $request->req_country['id'] : '1';
		session(['country_id' => $country_id]);
		$data['current_country_id'] = $country_id;

		$type = $data['page_type'];

		$data['search'] = [];

		$data['search_new'] = [];

		$data['states'] = State::where('country_id', $country_id)->get();
		$data['categories'] = Categories::where('status', 1)->get();
		$state = $request->req_state ? $request->req_state['code'] : '';
		$data['state_name'] = $state;

		$bg_image = $request->req_country ? $request->req_country['image'] : Country::selectRaw('image')->where('id', $country_id)->first()->image;

		$data['bg_image'] = $request->req_state ? assets_url('upload/state/' . $bg_image) : assets_url('upload/country/' . $bg_image);
		$country = Country::selectRaw('image')->where('id', $country_id)->first()->image;
		if ($request->req_state) {
			$state = State::selectRaw('header_image')->where('code', $state)->first()->header_image;
			if ($state !== "") {
				$data['bg_image'] = assets_url('upload/state/' . $state);
			} else {
				$data['bg_image'] = assets_url('upload/country/' . $country);
			}
		} else {
			$data['bg_image'] = assets_url('upload/country/' . $country);
		}

		$qur_data = HomeAdvertisement::where('status', 1)->orderby('ad_position_no')->where('sdate', '<=', Carbon::today())
			->where("country_id", $c_id);
		$data['search_new'] = [];
		if ($s_code) {
			$data['sd'] = 0;
			$qur_data1 = clone $qur_data;
			// $qur_data->whereRaw("FIND_IN_SET('" .$s_code . "', home_advertisements.state_id)");
			$gif_data = $qur_data1->whereIn('ad_position', ['State Top', 'State Right', 'State Left'])->get();
		} else {
			$qur_data1 = clone $qur_data;

			$gif_data = $qur_data1->whereIn('ad_position', ['Top', 'Right', 'Left', 'State Left', 'State Top', 'State Right'])->get();

		}

		$data['gif_data'] = array();
		$data['gif_data']['Left'] = array();
		$data['gif_data']['Right'] = array();
		$data['gif_data']['Top'] = array();
		foreach ($gif_data as $k => $v) {
			if (((strpos($v->ad_position, "ht")) || (strpos($v->ad_position, "ft"))) && $v->ad_position_no > 3) {
				$data['gif_data']['remvoed'][str_replace('State ', '', $v->ad_position)][$v->ad_position_no][] = $v->image;
			} else {
				if (!$v->url) {
					$v->url = 'https://nris.com/';
				}
				// echo "https://www.nris.com/upload/us_ads/$v->image";
				// echo "<br>";
				$width = $height = $type = $attr = 0;
				// if(file_exists ("https://nris.com/upload/us_ads/$v->image")){
				//       list($width, $height, $type, $attr)= getimagesize("https://nris.com/upload/us_ads/$v->image");
				// }

				if ((strpos($v->ad_position, "op"))) {
					if ($width == 130 && $height == 60 || 1) {
						$data['gif_data'][str_replace('State ', '', $v->ad_position)][$v->ad_position_no][] = $v->image . '@3&TdY*!fMKnN#nj=4_E@' . $v->url . '@3&TdY*!fMKnN#nj=4_E@' . $v->id;
					}
				} else {
					if ($width == 150 && $height == 100 || 1) {
						$data['gif_data'][str_replace('State ', '', $v->ad_position)][$v->ad_position_no][] = $v->image . '@3&TdY*!fMKnN#nj=4_E@' . $v->url . '@3&TdY*!fMKnN#nj=4_E@' . $v->id;

					}
				}

			}
		}

		$data['restaturant_category'] = \App\RestaurantType::all();
		$data['job_category'] = \App\JobCategory::all();
		$data['temples_category'] = \App\TempleType::all();
		$data['pubs_category'] = \App\PubType::all();
		$data['theater_category'] = \App\TheaterType::all();

		if ($s_code) {
			$data['gif_data']['Left'] = array();
		}

		ksort($data['gif_data']['Top']);
		ksort($data['gif_data']['Right']);

// echo "<pre>";
// print_R($data['gif_data']);
// echo "</pre>";
		return view('front.center', $data);
	}

	public function getstaticdata($place_name) {
		if (1 || !Cache::has('static_data')) {
			$data['restaturant_category'] = \App\RestaurantType::all();
			$data['job_category'] = \App\JobCategory::all();
			$data['temples_category'] = \App\TempleType::all();
			$data['pubs_category'] = \App\PubType::all();
			$data['theater_category'] = \App\TheaterType::all();
			$data['meta_tags'] = $this->meta_tags;
			$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
			$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);
			$expiresAt = Carbon::now()->addMinutes(1000);
			Cache::put('static_data', $data, $expiresAt);
		} else {
			$data = Cache::get('static_data');
		}

		return $data;
	}

	public function vistingsports() {
		$c_id = $_POST['c_id'];
		$s_code['code'] = $_POST['s_code'];

		if (1 || !Cache::has('visiting_sports' . $c_id . $s_code['code'])) {
			$data['visiting_sports'] = array('restaurant' => \App\Restaurant::RestaurantData(8, $s_code['code'],$c_id),
				'pubs' => \App\Pub::PubData(8, $s_code['code'],$c_id),
				'temples' => \App\Temple::TempleData(8, $s_code['code'],$c_id),
				'casinos' => \App\Casino::CasinoData(8, $s_code['code'],$c_id));
			$expiresAt = Carbon::now()->addMinutes(1000);
			Cache::put('visiting_sports' . $c_id . $s_code['code'], $data, $expiresAt);
		} else {
			$data = Cache::get('visiting_sports' . $c_id . $s_code['code']);
		}

		return view('front.home.vistingsports', $data);
	}

	public function dmoviesandnational() {
		$c_id = $_POST['c_id'];
		$s_code = $_POST['s_code'];

		if (1 || !Cache::has('dmoviesandnational' . $c_id . $s_code)) {
			$category = EventCategory::all();
			foreach ($category as $key => $cate) {
				if ($s_code) {
					$query = Event::where('status', 1)->where('category', $cate->id)->orderBy("id", "Desc");
					$query->whereRaw("FIND_IN_SET('" . $s_code . "', events.state_code)");
					$data['national_events'][$cate->id] = $query->limit(9)->get();
					// echo "<pre>";print_r($data['national_events'][$cate->id]);die;echo "</pre>";

				} else {
					$query = NationalEvent::where('status', 1)->where('category', $cate->id)->orderBy("id", "Desc");

					$query->where('national_events.country', $c_id);
					if ($s_code) {
						$query->whereRaw("FIND_IN_SET('" . $s_code . "', national_events.state_code)");
					}
					//     else{
					//     $a= get_states();
					//   $query->whereIn('national_events.state_code',explode(",", $a[0]));
					// }
					$data['national_events'][$cate->id] = $query->limit(9)->get();
				}
			}
			$data['national_category'] = $category;

			$movies_city = Citymovie::selectRaw('city_movies.*, cities.name as city_name, cities.id as citys_id')->leftJoin('cities', 'cities.id', 'city_movies.city_id')
				->where('city_movies.state_code', $s_code)->orderby('id', 'desc')->limit(3)->get();
			// print_R(  $movies_city );
			// exit;
			foreach ($movies_city as $key => $value) {
				$query = Citymovie::where("city_movies.status", 1)->where("city_movies.city_id", $value->city_id);
				$data['desi_movies'][$value->citys_id] = $query->limit(5)->orderby('id', 'desc')->get();
				$data['desi_movies_img'] = $data['desi_movies'][$value->citys_id]->first();
			}
			$data['movie_city'] = $movies_city;

			$expiresAt = Carbon::now()->addMinutes(1000);
			Cache::put('dmoviesandnational' . $c_id . $s_code, $data, $expiresAt);

		} else {
			$data = Cache::get('dmoviesandnational' . $c_id . $s_code);
		}

		return view('front.home.dmoviesandnational', $data);

	}

	public function nristalk() {
		$c_id = $_POST['c_id'];
		$s_code = $_POST['s_code'];

		if (1 || !Cache::has('nristalk' . $c_id . $s_code)) {

			$data['sd'] = 1;
			$query = NRITalk::with('comments', 'like_nris')->selectRaw('nris_talk.*')
			// (SELECT COUNT(nris_talk_reply.id) FROM nris_talk_reply WHERE nris_talk_reply.talk_id = nris_talk.id) as reply_count,
			// (SELECT COUNT(nris_like.id) FROM nris_like WHERE nris_like.talk_id = nris_talk.id) as like_count ')
				->leftJoin('nris_talk_reply', 'nris_talk_reply.talk_id', 'nris_talk.id')->leftJoin('nris_like', 'nris_like.talk_id', 'nris_talk.id')->where('nris_talk.status', '1')->orderBy('nris_talk.id', 'desc');
			if ($s_code) {
				$query->whereRaw("FIND_IN_SET('" . $s_code . "', nris_talk.state_code)");
				$data['sd'] = 0;
			}
			$data['nri_talks'] = $query->limit(7)->groupby('nris_talk.id')->get();
			$data['hotlist'] = $this->recentAdss($c_id, $s_code, 'hotlist');
			$expiresAt = Carbon::now()->addMinutes(1000);
			Cache::put('nristalk' . $c_id . $s_code, $data, $expiresAt);

		} else {
			$data = Cache::get('nristalk' . $c_id . $s_code);
		}

// print_r($data);
// exit;
		return view('front.home.nristalk', $data);
	}

	public function recent() {
		$c_id = $_POST['c_id'];
		$s_code = $_POST['s_code'];

		$data['recent_ads']['recent'] = $this->recentAdss($c_id, $s_code, 'recent');
		$data['recent_ads']['popular'] = $this->recentAdss($c_id, $s_code, 'popular');
		return view('front.home.recent', $data);

	}

	public static function getSideAds($id) {
		// $qur_data1 = HomeAdvertisement::where('status', 1);
		$qur_data1 = HomeAdvertisement::where('id', '>', 1);
		// $qur_data1->where('country_id', country_id());
		// ->where('home_advertisements.ad_position','Category Right')
		// $gif_data =  $qur_data1->where('categories_id', $id)->where('sdate','<=', Carbon::today())->orderBy('home_advertisements.ad_position_no', 'ASC')->get();
		// $qur_data1->whereIn('ad_position',['State Top','State Right','State Left'])->get();
		$gif_data = $qur_data1->get();

		// print_r($gif_data);
		// exit;
		$data['adv']['Top'] = array();
		$data['adv']['Right'] = array();
		foreach ($gif_data as $k => $v) {
			if ($v->ad_position == 'Left' || $v->ad_position == 'State Left' || $v->ad_position == 'State Right') {
				$v->ad_position = "Right";
			}
			$data['adv'][str_replace('State ', '', $v->ad_position)][$v->ad_position_no][] = $v->image . '@3&TdY*!fMKnN#nj=4_E@' . $v->url . '@3&TdY*!fMKnN#nj=4_E@' . $v->id;

		}
		ksort($data['adv']['Top']);
		ksort($data['adv']['Right']);
// print_r($data);
// echo " <pre> ";
// print_r($data);
// exit;
		return $data;
	}

	private function recentAds(Request $request, $type = 'recent', $limit = 1) {
		// type: recent, popular,
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$state_code = $request->req_state ? $request->req_state['code'] : '';
		$recent = $recent_data = $r_data = array();
		$view_routes = array(
			'baby_sitting' => 'front.babysitting.view',
			'auto' => 'auto.view',
			'education' => 'educationteaching.view',
			'electronics' => 'electronics.view',
			'garage' => 'garagesale.view',
			'job' => 'job.view',
			'room_mate' => 'room_mate.view',
			'realestate' => 'realestate.view',
			'other' => 'other.view',
			'free_stuff' => 'freestuff.view',
			'desi_date' => 'front.desi_date.view',
		);

		$recent['baby_sitting'] = \App\BabySittingClassified::selectRaw('post_free_baby_sitting.title, post_free_baby_sitting.id, post_free_baby_sitting.created_at, post_free_baby_sitting.total_views, post_free_baby_sitting.payment_id, post_free_baby_sitting.isPayed,baby_sitting_categories.color,post_free_baby_sitting.state as state, city')
			->leftJoin('baby_sitting_categories', 'baby_sitting_categories.id', 'post_free_baby_sitting.category')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['auto'] = \App\AutoClassified::selectRaw('auto_classifieds.title, auto_classifieds.id, auto_classifieds.created_at, auto_classifieds.total_views, auto_classifieds.payment_id, auto_classifieds.isPayed,auto_makes.color,auto_classifieds.states as state, city')
			->leftJoin('auto_makes', 'auto_makes.id', 'auto_classifieds.make')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['education'] = \App\EducationTeachingClassified::selectRaw('post_free_education.title, post_free_education.id, post_free_education.created_at, post_free_education.total_views, post_free_education.payment_id, post_free_education.isPayed,education_teaching_categories.color,post_free_education.states as state, city')
			->leftJoin('education_teaching_categories', 'education_teaching_categories.id', 'post_free_education.category')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['electronics'] = \App\ElectronicsClassifieds::selectRaw('post_free_electronics.title, post_free_electronics.id, post_free_electronics.created_at, post_free_electronics.total_views, post_free_electronics.payment_id, post_free_electronics.isPayed,electronic_categories.color,post_free_electronics.states as state, city')
			->leftJoin('electronic_categories', 'electronic_categories.id', 'post_free_electronics.category')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['garage'] = \App\GarageSale::selectRaw('post_free_garagesale.title, post_free_garagesale.id, post_free_garagesale.created_at, post_free_garagesale.total_views, post_free_garagesale.payment_id, post_free_garagesale.isPayed, garagesale_categoires.color,post_free_garagesale.states as state, city')
			->leftJoin('garagesale_categoires', 'garagesale_categoires.id', 'post_free_garagesale.items')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['job'] = \App\JobClassifieds::selectRaw('post_free_job.title, post_free_job.id, post_free_job.created_at, post_free_job.total_views, post_free_job.payment_id, post_free_job.isPayed,job_categories.color,post_free_job.states as state, city')
			->leftJoin('job_categories', 'job_categories.id', 'post_free_job.category')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		// DB::enableQueryLog();

		$recent['room_mate'] = \App\RoomMate::selectRaw('post_free_roommates.title, post_free_roommates.id, post_free_roommates.created_at, post_free_roommates.total_views, post_free_roommates.payment_id, post_free_roommates.isPayed,room_mate_categoires.color,post_free_roommates.states as state, city')
			->leftJoin('room_mate_categoires', 'room_mate_categoires.id', 'post_free_roommates.category')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);
		$a = DB::getQueryLog();
		// echo "<pre>";
		// print_R( $a );
		// exit;

		$recent['realestate'] = \App\RealEstate::selectRaw('post_free_real_estate.title, post_free_real_estate.id, post_free_real_estate.created_at, post_free_real_estate.total_views, post_free_real_estate.payment_id, post_free_real_estate.isPayed,realestate_categoires.color,post_free_real_estate.states as state, city')
			->leftJoin('realestate_categoires', 'realestate_categoires.id', 'post_free_real_estate.category_id')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['other'] = \App\Other::selectRaw('title, id, created_at, total_views, payment_id, isPayed, "#14274E" as color,states as state, city')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['free_stuff'] = \App\FreeStuff::selectRaw('title, id, created_at, total_views, payment_id, isPayed, "#14274E" as color,state as state, city')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['desi_date'] = \App\MyPartner::selectRaw('post_free_mypartner.title, post_free_mypartner.id, post_free_mypartner.created_at, post_free_mypartner.total_views, post_free_mypartner.payment_id, post_free_mypartner.isPayed, mypartner_categories.color,post_free_mypartner.states as state, city')
			->leftJoin('mypartner_categories', 'mypartner_categories.id', 'post_free_mypartner.category')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		// $recent['desi_date'] = \App\MyPartner::selectRaw('post_free_mypartner.title, desi_pages.id, desi_pages.created_at, desi_pages.total_views')->leftJoin('states', 'states.code', 'desi_pages.state_code')->where(array('status' => 1, 'states.country_id' => $country_id))->limit($limit);

		foreach ($recent as $key => $value) {
			if ($state_code) {
				if (in_array($key, ['baby_sitting', 'free_stuff'])) {
					// $value->select($key.'.state as state, city');
					$value->whereRaw("FIND_IN_SET('" . $state_code . "', state)");
				} else {
					// $value->select($key.'.states as state, city');
					$value->whereRaw("FIND_IN_SET('" . $state_code . "', states)");
				}
			} else {
				if (in_array($key, ['baby_sitting', 'free_stuff'])) {
					//   $value->select($key.'.state as state, city');
					// $value->where("state", "");
				} else {
					// $value->select($key.'.states as state, city');

					// $value->where("states", "");
				}
				// $value->select($key.'.states as state, city');
			}

			if ($type == 'recent') {
				$r_data = $value->latest()->get()->toArray();
			} else if ($type == 'popular') {
				$r_data = $value->orderBy('total_views', 'desc')->get()->toArray();
			} else if ($type == 'hotlist') {
				$r_data = $value->where(['isPayed' => 'Y', 'post_type' => 2])->orderBy('total_views', 'desc')->get()->toArray();
			} else if ($type == 'search' && $request->filter_name) {
				$value->where(function ($q) use ($request, $key) {
					$q->where('title', 'like', '%' . $request->filter_name . '%');
					$q->orWhere('message', 'like', '%' . $request->filter_name . '%');
				});
				$r_data = $value->orderBy('total_views', 'desc')->get()->toArray();
			}

			if ($r_data) {
				foreach ($r_data as $k => $val) {
					$r_data[$k]['type'] = $key;
					$r_data[$k]['slug'] = slug($val['title'] . '-' . $val['id']);
					$r_data[$k]['view_route'] = $view_routes[$key];
					$recent_data[] = $r_data[$k];
				}
			}

		}

		if ($type == 'recent') {
			$sort_by = 'created_at';
		} else {
			$sort_by = 'total_views';
		}

		if ($type == 'search') {
			return collect($recent_data)->sortByDesc($sort_by)->paginate();
		}

		return collect($recent_data)->sortByDesc($sort_by)->values()->all();
	}

	private function recentAdss($country_id, $state_code, $type = 'recent', $limit = 1) {
		// type: recent, popular,
		// $country_id = $request->req_country ? $request->req_country['id'] : 1;
		// $state_code = $request->req_state ? $request->req_state['code'] : '';
		// $country_id = $c_id;
		// $state_code = $c_id;

		$recent = $recent_data = $r_data = array();
		$view_routes = array(
			'baby_sitting' => 'front.babysitting.view',
			'auto' => 'auto.view',
			'education' => 'educationteaching.view',
			'electronics' => 'electronics.view',
			'garage' => 'garagesale.view',
			'job' => 'job.view',
			'room_mate' => 'room_mate.view',
			'realestate' => 'realestate.view',
			'other' => 'other.view',
			'free_stuff' => 'freestuff.view',
			'desi_date' => 'front.desi_date.view',
		);

		$recent['baby_sitting'] = \App\BabySittingClassified::selectRaw('post_free_baby_sitting.title, post_free_baby_sitting.id, post_free_baby_sitting.created_at, post_free_baby_sitting.total_views, post_free_baby_sitting.payment_id, post_free_baby_sitting.isPayed,baby_sitting_categories.color,post_free_baby_sitting.state as state, city')
			->leftJoin('baby_sitting_categories', 'baby_sitting_categories.id', 'post_free_baby_sitting.category')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['auto'] = \App\AutoClassified::selectRaw('auto_classifieds.title, auto_classifieds.id, auto_classifieds.created_at, auto_classifieds.total_views, auto_classifieds.payment_id, auto_classifieds.isPayed,auto_makes.color,auto_classifieds.states as state, city')
			->leftJoin('auto_makes', 'auto_makes.id', 'auto_classifieds.make')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['education'] = \App\EducationTeachingClassified::selectRaw('post_free_education.title, post_free_education.id, post_free_education.created_at, post_free_education.total_views, post_free_education.payment_id, post_free_education.isPayed,education_teaching_categories.color,post_free_education.states as state, city')
			->leftJoin('education_teaching_categories', 'education_teaching_categories.id', 'post_free_education.category')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['electronics'] = \App\ElectronicsClassifieds::selectRaw('post_free_electronics.title, post_free_electronics.id, post_free_electronics.created_at, post_free_electronics.total_views, post_free_electronics.payment_id, post_free_electronics.isPayed,electronic_categories.color,post_free_electronics.states as state, city')
			->leftJoin('electronic_categories', 'electronic_categories.id', 'post_free_electronics.category')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['garage'] = \App\GarageSale::selectRaw('post_free_garagesale.title, post_free_garagesale.id, post_free_garagesale.created_at, post_free_garagesale.total_views, post_free_garagesale.payment_id, post_free_garagesale.isPayed, garagesale_categoires.color,post_free_garagesale.states as state, city')
			->leftJoin('garagesale_categoires', 'garagesale_categoires.id', 'post_free_garagesale.items')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['job'] = \App\JobClassifieds::selectRaw('post_free_job.title, post_free_job.id, post_free_job.created_at, post_free_job.total_views, post_free_job.payment_id, post_free_job.isPayed,job_categories.color,post_free_job.states as state, city')
			->leftJoin('job_categories', 'job_categories.id', 'post_free_job.category')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		// DB::enableQueryLog();

		$recent['room_mate'] = \App\RoomMate::selectRaw('post_free_roommates.title, post_free_roommates.id, post_free_roommates.created_at, post_free_roommates.total_views, post_free_roommates.payment_id, post_free_roommates.isPayed,room_mate_categoires.color,post_free_roommates.states as state, city')
			->leftJoin('room_mate_categoires', 'room_mate_categoires.id', 'post_free_roommates.category')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);
		$a = DB::getQueryLog();
		// echo "<pre>";
		// print_R( $a );
		// exit;

		$recent['realestate'] = \App\RealEstate::selectRaw('post_free_real_estate.title, post_free_real_estate.id, post_free_real_estate.created_at, post_free_real_estate.total_views, post_free_real_estate.payment_id, post_free_real_estate.isPayed,realestate_categoires.color,post_free_real_estate.states as state, city')
			->leftJoin('realestate_categoires', 'realestate_categoires.id', 'post_free_real_estate.category_id')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['other'] = \App\Other::selectRaw('title, id, created_at, total_views, payment_id, isPayed, "#14274E" as color,states as state, city')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['free_stuff'] = \App\FreeStuff::selectRaw('title, id, created_at, total_views, payment_id, isPayed, "#14274E" as color,state as state, city')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		$recent['desi_date'] = \App\MyPartner::selectRaw('post_free_mypartner.title, post_free_mypartner.id, post_free_mypartner.created_at, post_free_mypartner.total_views, post_free_mypartner.payment_id, post_free_mypartner.isPayed, mypartner_categories.color,post_free_mypartner.states as state, city')
			->leftJoin('mypartner_categories', 'mypartner_categories.id', 'post_free_mypartner.category')
			->where(array('display_status' => 1, 'country' => $country_id))->limit($limit);

		// $recent['desi_date'] = \App\MyPartner::selectRaw('post_free_mypartner.title, desi_pages.id, desi_pages.created_at, desi_pages.total_views')->leftJoin('states', 'states.code', 'desi_pages.state_code')->where(array('status' => 1, 'states.country_id' => $country_id))->limit($limit);

		foreach ($recent as $key => $value) {
			if ($state_code) {
				if (in_array($key, ['baby_sitting', 'free_stuff'])) {
					// $value->select($key.'.state as state, city');
					$value->whereRaw("FIND_IN_SET('" . $state_code . "', state)");
				} else {
					// $value->select($key.'.states as state, city');
					$value->whereRaw("FIND_IN_SET('" . $state_code . "', states)");
				}
			} else {
				if (in_array($key, ['baby_sitting', 'free_stuff'])) {
					//   $value->select($key.'.state as state, city');
					// $value->where("state", "");
				} else {
					// $value->select($key.'.states as state, city');

					// $value->where("states", "");
				}
				// $value->select($key.'.states as state, city');
			}

			if ($type == 'recent') {
				$r_data = $value->latest()->get()->toArray();
			} else if ($type == 'popular') {
				$r_data = $value->orderBy('total_views', 'desc')->get()->toArray();
			} else if ($type == 'hotlist') {
				$r_data = $value->where(['isPayed' => 'Y', 'post_type' => 2])->orderBy('total_views', 'desc')->get()->toArray();
			} else if ($type == 'search' && $request->filter_name) {
				$value->where(function ($q) use ($request, $key) {
					$q->where('title', 'like', '%' . $request->filter_name . '%');
					$q->orWhere('message', 'like', '%' . $request->filter_name . '%');
				});
				$r_data = $value->orderBy('total_views', 'desc')->get()->toArray();
			}

			if ($r_data) {
				foreach ($r_data as $k => $val) {
					$r_data[$k]['type'] = $key;
					if($key == 'desi_date'){
					    	$r_data[$k]['slug'] = slug($val['title']);
					}else{
					    	$r_data[$k]['slug'] = slug($val['title'] . '-' . $val['id']);
					}
				
					$r_data[$k]['view_route'] = $view_routes[$key];
					$recent_data[] = $r_data[$k];
				}
			}

		}

		if ($type == 'recent') {
			$sort_by = 'created_at';
		} else {
			$sort_by = 'total_views';
		}

		if ($type == 'search') {
			return collect($recent_data)->sortByDesc($sort_by)->paginate();
		}

		return collect($recent_data)->sortByDesc($sort_by)->values()->all();
	}

	public function search(Request $request) {

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$state_code = $request->req_state ? $request->req_state['code'] : '';

		$data['country_name'] = $request->req_country ? $request->req_country['name'] : 'USA';
		$place_name = $request->req_state ? $request->req_state['name'] : $data['country_name'];

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);

		//$request->filter_name word contain restaurent, pub, etc

		if (strpos($request->filter_name, 'rest') !== false) {
			$query = Restaurant::selectRaw('restaurants.name as title, restaurants.id, restaurants.created_at, total_views')->where(array('status' => 1))
				->leftJoin('states', 'states.code', 'restaurants.state_code')
				->where('states.country_id', $country_id)
				->orderBy('total_views', 'desc');

			if ($request->req_state) {
				$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', restaurants.state_code)");
				$place_name = $request->req_state['name'];
			}

			$restaurant_data = $query->get()->toArray();

			foreach ($restaurant_data as $key => &$value) {
				$value['type'] = 'restaurant';
				$value['slug'] = slug($value['title'] . '-' . $value['id']);
				$value['view_route'] = 'restaurants.view';
			}

			$data['search_data'] = collect($restaurant_data)->paginate();
			return view('front.search', $data);
		}
		if (strpos($request->filter_name, 'pub') !== false) {
			$query = \App\Pub::selectRaw('pub_name as title, pubs.id, pubs.created_at, total_views')->where(array('status' => 1))->orderBy('total_views', 'desc')
				->leftJoin('states', 'states.code', 'pubs.state_code')
				->where('states.country_id', $country_id);

			if ($request->req_state) {
				$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', pubs.state_code)");
				$place_name = $request->req_state['name'];
			}

			$pub_data = $query->get()->toArray();

			foreach ($pub_data as $key => &$value) {
				$pub_data[$key]['type'] = 'pub';
				$pub_data[$key]['slug'] = slug($value['title'] . '-' . $value['id']);
				$pub_data[$key]['view_route'] = 'front.pubs.view';
			}

			$data['search_data'] = collect($pub_data)->paginate();
			return view('front.search', $data);
		}
		if (strpos($request->filter_name, 'casino') !== false) {
			$query = \App\Casino::selectRaw('casinos.name as title, casinos.id, casinos.created_at, total_views')->where(array('status' => 1))->orderBy('total_views', 'desc')
				->leftJoin('states', 'states.code', 'casinos.state_code')
				->where('states.country_id', $country_id);

			if ($request->req_state) {
				$query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', casinos.state_code)");
				$place_name = $request->req_state['name'];
			}

			$casino_data = $query->get()->toArray();

			foreach ($casino_data as $key => $value) {
				$casino_data[$key]['type'] = 'casino';
				$casino_data[$key]['slug'] = slug($value['title'] . '-' . $value['id']);
				$casino_data[$key]['view_route'] = 'casinos.view';
			}

			$data['search_data'] = collect($casino_data)->paginate();
			return view('front.search', $data);
		}

		$data['filter_name'] = $request->filter_name;
		$data['search_data'] = $this->recentAds($request, 'search', 10);

		return view('front.search', $data);
	}

	public function getCreateAdUrl($add_type, $absolute = true, $json = false) {
		if (!array_key_exists($add_type, $this->ad_types)) {
			return abort(404);
		}

		$urls = [
			'national-autos' => ['title' => 'National Auto', 'link' => route('front.national_autos.create_ad', $add_type, $absolute), 'image' => 'https://www.nris.com/stuff/images/auto.png'],
			'baby_sitting' => ['title' => 'Baby Sitting', 'link' => route('front.babysitting.create_ad', $add_type, $absolute), 'image' => 'https://www.nris.com/stuff/images/baby_sitting.jpg'],
			'education' => ['title' => 'Education', 'link' => route('front.education.create_ad', $add_type, $absolute), 'image' => 'https://www.nris.com/stuff/images/education.png'],
			'electronics' => ['title' => 'Electronics', 'link' => route('front.electronics.create_ad', $add_type, $absolute), 'image' => 'https://www.nris.com/stuff/images/electronics.jpg'],
			'free_stuff' => ['title' => 'Free Stuff', 'link' => route('front.freestuff.create_ad', $add_type, $absolute), 'image' => 'https://www.nris.com/stuff/images/free_stuff.jpg'],
			'garagesale' => ['title' => 'Garage sale', 'link' => route('front.garagesale.create_ad', $add_type, $absolute), 'image' => 'https://www.nris.com/stuff/images/garagesale.jpg'],
			'job' => ['title' => 'Job', 'link' => route('front.job.create_ad', $add_type, $absolute), 'image' => 'https://www.nris.com/stuff/images/jobs.jpg'],
			'roommates' => ['title' => 'Room-mates', 'link' => route('front.roommate.create_ad', $add_type, $absolute), 'image' => 'https://www.nris.com/stuff/images/roommates.jpg'],
			'desi-date' => ['title' => 'Desi Date', 'link' => route('front.desidate.create_ad', $add_type, $absolute), 'image' => 'https://www.nris.com/stuff/images/mypartner.jpg'],
			'realestate' => ['title' => 'Real-estate', 'link' => route('front.realestate.create_ad', $add_type, $absolute), 'image' => 'https://www.nris.com/stuff/images/realestate.jpg'],
			'other' => ['title' => 'Other', 'link' => route('front.other.create_ad', $add_type, $absolute), 'image' => 'https://www.nris.com/stuff/images/other.png'],
		];

		if ($json) {
			return response()->json(['urls' => $urls]);
		}
		return $urls;
	}

	public function setStateAdd(Request $request) {
		$country_id = $request->req_country ? $request->req_country['id'] : '1';
		$state_data = State::where('country_id', $country_id)->get();
		$hrefs = [];
		if ($request->add_name) {
			$add_name = $request->add_name;
		} else if ($request->url) {
			$uri_path = parse_url($request->url, PHP_URL_PATH);
			$uri_segments = explode('/', $uri_path);
			$add_name = $uri_segments[1];
		} else {
			$add_name = '';
		}

		if ($add_name == 'add_university-form') {
			foreach ($state_data as $state) {
				$hrefs[] = [
					'link' => str_replace('__NAME__', $state->domain, env('APP_URL_SLUG')) . route('adduniversity.form', false, false),
					'state_name' => $state->description,
				];
			}
			return response()->json(['hrefs' => $hrefs]);
		} else

		if ($add_name == 'add_university-Topic') {
			foreach ($state_data as $state) {
				$hrefs[] = [
					'link' => str_replace('__NAME__', $state->domain, env('APP_URL_SLUG')) . route('adduniversity.topic_form', false, false),
					'state_name' => $state->description,
				];
			}
			return response()->json(['hrefs' => $hrefs]);
		} else if ($add_name == 'discussion-room') {
			foreach ($state_data as $state) {
				$hrefs[] = [
					'link' => str_replace('__NAME__', $state->domain, env('APP_URL_SLUG')) . route('front.nristalk.create', false, false),
					'state_name' => $state->description,
				];
			}
			return response()->json(['hrefs' => $hrefs]);
		} else if ($add_name == 'batches') {
			foreach ($state_data as $state) {
				$hrefs[] = [
					'link' => str_replace('__NAME__', $state->domain, env('APP_URL_SLUG')) . route('front.nationalbatch.create_ad', false, false),
					'state_name' => $state->description,
				];
			}
			return response()->json(['hrefs' => $hrefs]);
		} else if ($add_name == 'add_carpool-form') {
			foreach ($state_data as $state) {
				$hrefs[] = [
					'link' => str_replace('__NAME__', $state->domain, env('APP_URL_SLUG')) . route('addcarpool.form', false, false),
					'state_name' => $state->description,
				];
			}
			return response()->json(['hrefs' => $hrefs]);
		} else if ($add_name == 'electronics') {
			foreach ($state_data as $state) {
				$hrefs[] = [
					'link' => str_replace('__NAME__', $state->domain, env('APP_URL_SLUG')) . route('front.electronics.create_ad', false, false),
					'state_name' => $state->description,
				];
			}
			return response()->json(['hrefs' => $hrefs]);
		}

		$urls = $this->getCreateAdUrl($request->type, false);

		if ($add_name && array_key_exists($add_name, $urls)) {
			foreach ($state_data as $state) {
				$hrefs[] = ['link' => str_replace('__NAME__', $state->domain, env('APP_URL_SLUG')) . $urls[$add_name]['link'],
					'state_name' => $state->description,
				];
			}
		}

		return response()->json(['hrefs' => $hrefs, 'add_name' => $add_name]);
	}
}