<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller {
	public function index(Request $request) {
		//$data['totals']= $this->getCount($request);
		$data['auto_app'] = \App\AutoClassified::where(['display_status' => '1'])->get();
		$data['auto_pen'] = \App\AutoClassified::where(['display_status' => '0'])->get();
		// // dd($data);
		// $data['job_app'] = \App\JobClassifieds::where(['display_status'=>'1'])->get();
		// $data['job_pen'] = \App\JobClassifieds::where(['display_status'=>'0'])->get();
		$data['babysitting_app'] = \App\BabySittingClassified::where(['display_status' => '1'])->get();
		$data['babysitting_pen'] = \App\BabySittingClassified::where(['display_status' => '0'])->get();
		$data['mypartner_app'] = \App\MyPartner::where(['display_status' => '1'])->get();
		$data['mypartner_pen'] = \App\MyPartner::where(['display_status' => '0'])->get();
		$data['realestate_app'] = \App\RealEstate::where(['display_status' => '1'])->get();
		$data['realestate_pen'] = \App\RealEstate::where(['display_status' => '0'])->get();
		$data['roommate_app'] = \App\RoomMate::where(['display_status' => '1'])->get();
		$data['roommate_pen'] = \App\RoomMate::where(['display_status' => '0'])->get();
		$data['garagesale_app'] = \App\GarageSale::where(['display_status' => '1'])->get();
		$data['garagesale_pen'] = \App\GarageSale::where(['display_status' => '0'])->get();
		$data['freestuff_app'] = \App\FreeStuff::where(['display_status' => '1'])->get();
		$data['freestuff_pen'] = \App\FreeStuff::where(['display_status' => '0'])->get();
		$data['other_app'] = \App\Other::where(['display_status' => '1'])->get();
		$data['other_pen'] = \App\Other::where(['display_status' => '0'])->get();
		$data['education_app'] = \App\EducationTeachingClassified::where(['display_status' => '1'])->get();
		$data['education_pen'] = \App\EducationTeachingClassified::where(['display_status' => '0'])->get();
		$data['electronic_app'] = \App\ElectronicsClassifieds::where(['display_status' => '1'])->get();
		$data['electronic_pen'] = \App\ElectronicsClassifieds::where(['display_status' => '0'])->get();

		return view('admin.dashboard', $data);
	}

	public function changeState(Request $request, $country_id) {
		session(['country_id' => (int) $country_id]);
		\Session::flash('success', 'Country Changes Succesfully!');
		return redirect()->back();
	}

	public function getCount(Request $request) {

		$json = array();
		if ($request->date_from && $request->date_to) {
			$filter = array(
				'status' => 1,
			);
		} else {
			$filter = array(
				'status' => 1,
			);
		}
		// 'date_from' => date("Y-m-d"),
		// 'date_to' => date("Y-m-d"),

		//         'date_from' => date('Y-m-d', strtotime($request->date_from)),
		// 'date_to' => date('Y-m-d', strtotime($request->date_to)),

		$json['total_app_temple'] = \App\Temple::count_c($filter);
		$json['total_app_restaurant'] = \App\Restaurant::count_c($filter);
		$json['total_app_sport'] = \App\Sport::count_c($filter);
		$json['total_app_pub'] = \App\Pub::count_c($filter);
		$json['total_app_theater'] = \App\Theater::count_c($filter);
		$json['total_app_grocery'] = \App\Grocery::count_c($filter);
		$json['total_app_casino'] = \App\Casino::count_c($filter);
		$json['total_app_event'] = \App\Event::count_c($filter);
		$json['total_app_autoclassified'] = \App\AutoClassified::count_c($filter);
		$json['total_app_jobclassifieds'] = \App\JobClassifieds::count_c($filter);
		$json['total_app_babysittingclassified'] = \App\BabySittingClassified::count_c($filter);
		$json['total_app_blog'] = \App\Blog::count_c($filter);
		$json['total_app_forumthread'] = \App\ForumThread::count_c($filter);
		$json['total_app_nritalk'] = \App\NRITalk::count_c($filter);
		$json['total_app_newsvideo'] = \App\NewsVideo::count_c($filter);
		$json['total_app_businesses'] = \App\Businesses::count_c($filter);
		$json['total_user'] = \App\User::count_c($filter);
		$json['total_nri_card'] = \App\NRICard::count_c($filter);
		$json['total_admin'] = \App\Admin::count_c($filter);
		$json['total_home_advertise'] = \App\HomeAdvertisement::count_c($filter);

		// $json['total_app_nationalevents'] = \App\NationalEvents::count_c($filter);
		// $json['total_app_home_advertisement'] = \App\HomeAdvertisement::count_c($filter);
		// $json['total_app_blog'] = \App\Blog::count_c($filter);
		// $json['total_app_nritalk'] = \App\NRITalk::count_c($filter);
		// $json['total_app_newsvideo'] = \App\NewsVideo::count_c($filter);
		// $json['total_app_businesses'] = \App\Businesses::count_c($filter);

		return $json;
	}

}