<?php

namespace App\Http\Controllers;

use App\NRICard;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProfileController extends Controller {

	public function index(Request $request) {
		$data['user'] = Auth::user();
		$data['meta_tags'] = array(
			// 'meta_title' => $data['blog']->meta_title,
			// 'meta_description' => $data['blog']->meta_description,
			// 'meta_keywords' => $data['blog']->meta_keywords,
			'title' => 'My Profile',
			'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Profile and stay updated with the latest posts.',
			'twitter_title' => 'My Profile',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);
		return view('front.profile.profile', $data);
	}

	public function initForm(Request $request) {
		$data['meta_tags'] = array(
			// 'meta_title' => $data['blog']->meta_title,
			// 'meta_description' => $data['blog']->meta_description,
			// 'meta_keywords' => $data['blog']->meta_keywords,
			'title' => 'Edit Profile',
			'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Profile and stay updated with the latest posts.',
			'twitter_title' => 'Edit Profile',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);
		$data['user'] = Auth::user();
		return view('front.profile.profile_edit', $data);
	}

	public function nriCard(Request $request) {
		$data['meta_tags'] = array(
			'meta_title' => 'NRI_CARD',
			'meta_description' => 'NRI_CARD',
			'meta_keywords' => 'NRI_CARD',
			'title' => 'NRIs Card',
			'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Profile and stay updated with the latest posts.',
			'twitter_title' => 'NRIs Card',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);
		$data['user'] = Auth::user();
		$data['cards'] = NRICard::selectRaw('nris_card.*,paypal_payments.*,users.dob')
			->leftJoin("paypal_payments", "paypal_payments.id", "nris_card.payment_id")
			->leftJoin("users", "users.id", "nris_card.user_id")
			->where(['nris_card.status' => 1, 'nris_card.user_id' => Auth::user()->id])
			->get();
		return view('front.profile.nricard', $data);
	}

	public function verifaction(Request $request, $card_no) {
		$user = Auth::user();
		$card_decode = base64_decode($card_no);
		$card = NRICard::where(['status' => 0, 'card_no' => $card_decode])->first();

		if ($card) {
			if ($card->email == $user->email) {
				$data['text'] = 'To activate your card, Click on the button below.';
				$data['card_no'] = $card_no;
			} else {
				$data['text'] = 'You are not authorized to activate this card.';
				$data['card_no'] = '';
			}
		} else {
			$data['text'] = 'This Link is no longer available.';
			$data['card_no'] = '';
		}

		return view('front.profile.verification', $data);
	}

	public function cardActive(Request $request) {
		$user = Auth::user();
		$nricard = NRICard::where(['status' => 0, 'card_no' => base64_decode($request->code)])
			->first();

		if ($nricard && $user && ($nricard->email == $user->email)) {
			$nricard->status = 1;
			$nricard->user_id = $user->id;
			$nricard->save();
			return redirect(route('front.nricard'))->with('success', 'Your NRICard has been verified successfully.');
		}
		return redirect('home')->with('error', 'This link is not valid.');
	}

	public function initSubmit(Request $request) {
		$data = $request->all();
		$user = Auth::user();

		$rules = array(
			'first_name' => 'required|max:120',
			'last_name' => 'required|max:120',
			'email' => 'required|email|unique:users,email,' . $user->id,
			'dob' => 'required',
			'state' => 'required',
			'city' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			$user->email = $request->email;
			$user->dob = $request->dob;
			$user->mobile = $request->mobile;
			$user->address = $request->address;
			$user->state = $request->state;
			$user->city = $request->city;
			$user->zip_code = $request->zip_code;

			if ($request->hasFile('image')) {
				$user->profile_photo = uniqname() . '.' . $request->file('image')->guessExtension();
				// $user->profile_photo = uniqname() .'.'. $request->file('image')->getClientOriginalName();
				$request->file('image')->move(public_path('upload/users'), $user->profile_photo);
			}

			$user->save();

			\Session::flash('success', 'Profile Saved Successfully.');
			$json['location'] = route('front.profile');
		}

		return $json;
	}

	public function myAds(Request $request) {
		$data['meta_tags'] = array(
			'meta_title' => 'my adds',
			'meta_description' => 'my adds',
			'meta_keywords' => 'my adds',
			'title' => 'My Ads',
			'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Profile and stay updated with the latest posts.',
			'twitter_title' => 'MY Ads',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);
		$data['user'] = Auth::user();
		$user_id = $data['user']->id;
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$state_code = $request->req_state ? $request->req_state['code'] : '';
		$ads = $r_data = $recent_data = array();
		$view_routes = array(
			'post_free_baby_sitting' => ['view' => 'front.babysitting.view', 'edit' => 'front.babysitting.create_ad', 'delete' => 'front.babysitting.delete_ad', 'model' => 'BabySittingClassified'],
			'auto_classifieds' => ['view' => 'auto.view', 'edit' => 'front.national_autos.create_ad', 'delete' => 'front.national_autos.delete_ad', 'model' => 'AutoClassified'],
			'post_free_education' => ['view' => 'educationteaching.view', 'edit' => 'front.education.create_ad', 'delete' => 'front.education.delete_ad', 'model' => 'EducationTeachingClassified'],
			'post_free_electronics' => ['view' => 'electronics.view', 'edit' => 'front.electronics.create_ad', 'delete' => 'front.electronics.delete_ad', 'model' => 'ElectronicsClassifieds'],
			'post_free_garagesale' => ['view' => 'garagesale.view', 'edit' => 'front.garagesale.create_ad', 'delete' => 'front.garagesale.delete_ad', 'model' => 'GarageSale'],
			'post_free_job' => ['view' => 'job.view', 'edit' => 'front.job.create_ad', 'delete' => 'front.job.delete_ad', 'model' => 'JobClassifieds'],
			'post_free_roommates' => ['view' => 'room_mate.view', 'edit' => 'front.roommate.create_ad', 'delete' => 'front.roommate.delete_ad', 'model' => 'RoomMate'],
			'post_free_real_estate' => ['view' => 'realestate.view', 'edit' => 'front.realestate.create_ad', 'delete' => 'front.realestate.delete_ad', 'model' => 'RealEstate'],
			'post_free_other' => ['view' => 'other.view', 'edit' => 'front.other.create_ad', 'delete' => 'front.other.delete_ad', 'model' => 'Other'],
			'post_free_stuff' => ['view' => 'freestuff.view', 'edit' => 'front.freestuff.create_ad', 'delete' => 'front.freestuff.delete_ad', 'model' => 'FreeStuff'],
			'post_free_mypartner' => ['view' => 'front.desi_date.view', 'edit' => 'front.desidate.create_ad', 'delete' => 'front.desidate.delete_ad', 'model' => 'MyPartner'],
			// 'batches' => ['view' => 'nationalbatch.view', 'edit' => 'front.nationalbatch.create_ad', 'delete' => 'front.nationalbatch.delete_ad', 'model' => 'Batche'],
		);

		$ads['post_free_baby_sitting'] = \App\BabySittingClassified::selectRaw('title, id, created_at, total_views, display_status, isPayed,post_type');
		$ads['auto_classifieds'] = \App\AutoClassified::selectRaw('auto_classifieds.title, auto_classifieds.id, auto_classifieds.created_at, auto_classifieds.total_views, auto_classifieds.display_status, auto_classifieds.isPayed,post_type, auto_classifieds_bid.amount as amt')->leftJoin('auto_classifieds_bid', 'auto_classifieds_bid.auto_id', 'auto_classifieds.id');
		$ads['post_free_education'] = \App\EducationTeachingClassified::selectRaw('title, id, created_at, total_views, display_status, isPayed,post_type');
		$ads['post_free_electronics'] = \App\ElectronicsClassifieds::selectRaw('title, id, created_at, total_views, display_status, isPayed,post_type');
		$ads['post_free_garagesale'] = \App\GarageSale::selectRaw('title, id, created_at, total_views, display_status, isPayed,post_type');
		$ads['post_free_job'] = \App\JobClassifieds::selectRaw('title, id, created_at, total_views, display_status, isPayed,post_type');
		$ads['post_free_roommates'] = \App\RoomMate::selectRaw('post_free_roommates.title, post_free_roommates.id, post_free_roommates.created_at, post_free_roommates.total_views, post_free_roommates.display_status ,roommates_bid.amount as amt ,post_free_roommates.isPayed,post_type')->leftJoin('roommates_bid', 'roommates_bid.roommates_id', 'post_free_roommates.id');
		$ads['post_free_real_estate'] = \App\RealEstate::selectRaw('title, id, created_at, total_views, display_status, isPayed,post_type');
		$ads['post_free_other'] = \App\Other::selectRaw('title, id, created_at, total_views, display_status, isPayed,post_type');
		$ads['post_free_stuff'] = \App\FreeStuff::selectRaw('title, id, created_at, total_views, display_status, isPayed,post_type');
		$ads['post_free_mypartner'] = \App\MyPartner::selectRaw('title, id, created_at, total_views, display_status, isPayed,post_type');
		// $ads['batches'] = \App\Batche::selectRaw('title, id, created_at, total_views, display_status');

		foreach ($ads as $key => $value) {
			$value->where(array($key . '.user_id' => $user_id));
			$r_data = $value->latest()->get()->toArray();

			if ($r_data) {
				foreach ($r_data as $k => $val) {
					$r_data[$k]['type'] = $key;
					$r_data[$k]['slug'] = slug($val['title'] . '-' . $val['id']);
					if($r_data[$k]['type'] == 'post_free_job' || $r_data[$k]['type'] == 'post_free_real_estate')
					{
						$r_data[$k]['slug'] = slug($val['title']);
					}
					
					$r_data[$k]['view_route'] = $view_routes[$key]['view'];
					$r_data[$k]['edit_route'] = $view_routes[$key]['edit'];
					$r_data[$k]['delete_route'] = $view_routes[$key]['delete'];
					$r_data[$k]['table_model'] = $view_routes[$key]['model'];
					$recent_data[] = $r_data[$k];
				}
			}

		}
		$data['search_data'] = collect($recent_data)->paginate();
		// echo '<pre>';
		// print_r($data['search_data']);
		// echo '</pre>';
		// die();
		return view('front.profile.my_ads', $data);
	}

	public function myBid(Request $request) {
		// $user = Auth::id();
		// $data['search_data'] = \App\Autobiocomment::where('user_id',$user)->paginate(8);
		$data['user'] = Auth::user();
		$user_id = $data['user']->id;
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$state_code = $request->req_state ? $request->req_state['code'] : '';
		$ads = $r_data = $recent_data = array();
		$view_routes = array(
			'auto' => ['delete' => 'front.profile.auto_bid.delete', 'bid_type' => 'Auto Bid'],
			'roommate' => ['delete' => 'front.profile.roommate_bid.delete', 'bid_type' => 'RoomMate Bid'],
		);

		$ads['auto'] = \App\Autobiocomment::selectRaw('id, comment, amount, created_at');
		$ads['roommate'] = \App\RoomMateBid::selectRaw('id, comment, amount, created_at');

		foreach ($ads as $key => $value) {
			$value->where(array('user_id' => $user_id));
			$r_data = $value->latest()->get()->toArray();

			if ($r_data) {
				foreach ($r_data as $k => $val) {
					$r_data[$k]['comment'] = $val['comment'];
					$r_data[$k]['amount'] = $val['amount'];
					$r_data[$k]['delete_route'] = $view_routes[$key]['delete'];
					$r_data[$k]['type'] = $view_routes[$key]['bid_type'];
					$recent_data[] = $r_data[$k];
				}
			}

		}
		$data['search_data'] = collect($recent_data)->paginate();
		return view('front.profile.my_bid', $data);
	}

	public function BidDeleteauto(Request $request, $id) {
		$bid = \App\Autobiocomment::findOrFail(base64_decode($id));
		$bid->delete();
		return redirect()->back();
	}

	public function BidDeleteroommate(Request $request, $id) {
		$bid = \App\RoomMateBid::findOrFail(base64_decode($id));
		$bid->delete();
		return redirect()->back();
	}

}