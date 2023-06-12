<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class PendingAdsController extends Controller {
	public function index(Request $request) {
		$baby = DB::table('post_free_baby_sitting')->selectRaw('id,title,display_status,"babysitting-classified" as ad_type,created_at')->where('display_status', 0);
		$education = DB::table('post_free_education')->selectRaw('id,title,display_status,"educationteaching-classified" as ad_type,created_at')->where('display_status', 0);
		$electronics = DB::table('post_free_electronics')->selectRaw('id,title,display_status,"electronics-classified" as ad_type,created_at')->where('display_status', 0);
		$garagesale = DB::table('post_free_garagesale')->selectRaw('id,title,display_status,"garagesale-classified" as ad_type,created_at')->where('display_status', 0);
		$job = DB::table('post_free_job')->selectRaw('id,title,display_status,"jobs-classified" as ad_type,created_at')->where('display_status', 0);
		$mypartner = DB::table('post_free_mypartner')->selectRaw('id,title,display_status,"my-partner-classified" as ad_type,created_at')->where('display_status', 0);
		$other = DB::table('post_free_other')->selectRaw('id,title,display_status,"other-classified" as ad_type,created_at')->where('display_status', 0);
		$real_estate = DB::table('post_free_real_estate')->selectRaw('id,title,display_status,"realestate-classified" as ad_type,created_at')->where('display_status', 0);
		$roommates = DB::table('post_free_roommates')->selectRaw('id,title,display_status,"roommate-classified" as ad_type,created_at')->where('display_status', 0);
		$free_stuff = DB::table('post_free_stuff')->selectRaw('id,title,display_status,"freestuff-classified" as ad_type,created_at')->where('display_status', 0);
		$auto = DB::table('auto_classifieds')->selectRaw('id,title,display_status,"auto-classified" as ad_type,created_at')->where('display_status', 0);

		$data['union'] = $baby->union($education)->union($electronics)->union($garagesale)->union($job)->union($mypartner)->union($other)->union($real_estate)->union($roommates)->union($free_stuff)->union($auto)->orderBy('created_at', 'desc')->paginate(18);

		return view('admin.pendingads.adsData', $data);
	}
}