<?php

namespace App\Http\Controllers;

use App\BatchCategory;
use App\Batche;
use App\Batchescategory;
use App\NationalBatch;
use App\NationalBatchesComment;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class NationalBeatchsController extends Controller {

	public $meta_tags = array(
		'title' => 'National Batch',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our National Batch and stay updated with the latest posts.',
		'twitter_title' => 'National Batch',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);

	public function index(Request $request, $slug = 0) {
		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
		if ($request->req_state) {

			if ($slug) {
				$category = Batchescategory::where('id', 'like', base64_decode($slug))->firstOrFail();
			}
			$query = Batche::selectRaw('batches.*')
				->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', batches.state_code)");

			if ($slug) {
				$query->where('category', base64_decode($slug));
			}

			if ($slug) {
				$data['cat'] = Batchescategory::where('id', base64_decode($slug))->firstOrFail();
			}

			$data['batches'] = $query->orderBy('total_views', 'desc')->paginate(15);
		} else {
			if ($slug) {
				$category = BatchCategory::where('id', 'like', base64_decode($slug))->firstOrFail();
			}

			$query = NationalBatch::selectRaw('national_batches.*');
			// ->where('national_batches.category', $category->id)

			$country_id = $request->req_country ? $request->req_country['id'] : 1;
			$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
			$query->where('national_batches.country', $country_id);

			if ($slug) {
				$data['cat'] = BatchCategory::where('id', base64_decode($slug))->first();
			}
			$data['batches'] = $query->orderBy('total_views', 'desc')->paginate(15);
		}

		$data['meta_tags'] = $this->meta_tags;

		$data['slug'] = $slug;
		return view('front.nationalbatch.list', $data);
	}

	public function view(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		if ($request->req_state) {

			$query = Batche::selectRaw('batches.*,states.country_id, batches_categories.name as category_name, batches_categories.id as category_id')
				->leftJoin('states', 'states.code', 'batches.state_code')
				->leftJoin('batches_categories', 'batches_categories.id', 'batches.category')
				->where('batches.display_status', 1)
				->where('batches.state_code', $request->req_state['code'])
				->where('batches.id', $id);

			$country_id = $request->req_country ? $request->req_country['id'] : 1;
			$place_name = $request->req_country ? $request->req_country['name'] : 'USA';

			// if ($request->req_state) {
			//     $query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', Batche.state_code)");
			//     $place_name = $request->req_state['name'];
			// }

			$data['batch'] = $query->firstOrFail();
			Batche::find($id)->increment('total_views', 1);

		} else {

			$query = NationalBatch::selectRaw('national_batches.*,states.country_id, batches_categories.name as category_name, batches_categories.id as category_id')
				->leftJoin('states', 'states.code', 'national_batches.status')
				->leftJoin('batches_categories', 'batches_categories.id', 'national_batches.category')
				->where('national_batches.id', $id);

			$country_id = $request->req_country ? $request->req_country['id'] : 1;
			$place_name = $request->req_country ? $request->req_country['name'] : 'USA';
			$query->where('national_batches.country', $country_id);

			// if ($request->req_state) {
			//     $query->whereRaw("FIND_IN_SET('" . $request->req_state['code'] . "', national_batches.state_code)");
			//     $place_name = $request->req_state['name'];
			// }

			$data['batch'] = $query->firstOrFail();
			NationalBatch::find($id)->increment('total_views', 1);

		}

		/// $data['comments'] = NationalBatchesComment::selectRaw('national_batches_comment.*, users.profile_photo, CONCAT(users.first_name," ", users.last_name) AS user')->leftJoin("users","users.id","national_batches_comment.user_id")->where('national_event_id', $data['batch']->id)->where('reply_id', 0)->paginate(5);
		$data['comments'] = NationalBatchesComment::selectRaw('national_batches_comment.*, users.profile_photo, CONCAT(users.first_name," ", users.last_name) AS user')->leftJoin("users", "users.id", "user")->where('national_event_id', $data['batch']->id)->where('reply_id', 0)->paginate(5);
		$data['meta_tags'] = array(
			'meta_title' => $data['batch']->meta_title,
			'meta_description' => $data['batch']->meta_description,
			'meta_keywords' => $data['batch']->meta_keywords,
			'title' => $data['batch']->title,
			'description' => $data['batch']['details'],
			'twitter_title' => $data['batch']['title'],
			'image_' => $data['batch']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.nationalbatch.view', $data);
	}

	public function submitForm(Request $request, NationalBatchesComment $comment) {
		$data = $request->all();

		$rules = array(
			'comment' => 'required|min:2|max:120',
			'model_id' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$batch_cmnt = new NationalBatchesComment();
			$batch_cmnt->reply_id = $comment->id ? $comment->id : 0;
			$batch_cmnt->comment = $request->comment;
			$batch_cmnt->national_event_id = $request->model_id;
			$batch_cmnt->user = Auth::user() ? Auth::user()->id : 0;
			$batch_cmnt->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'National Beatch Ad',
				'name' => Auth::user()->name,
				'sub_type' => $comment->id ? 'Reply' : 'Comment',
			);
			sendCommentAlert($mail_data);

			\Session::flash('success', 'Comment Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}

	public function createAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();
		// $ad_types = $this->ad_types;

		$data['categories'] = Batchescategory::all();

		$data['ad'] = Batche::findOrNew($id ? base64_decode($id) : 0);
		if ($data['ad'] && $id) {
			if ($data['ad']->user_id != Auth::user()->id) {
				return abort(404);
			}
			$ad_types['update_ad'] = 'Update Ad';
		}

		$data['id'] = $id;

		// if (!array_key_exists($ad_type, $ad_types)) {
		//     return abort(404);
		// }
		// $data['ad_type'] = $ad_type;
		// $data['ad_type_text'] = $ad_types[$ad_type];

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

		// $data['categories'] = MyPartnerCategory::all();

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $country_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $country_name, $data['meta_tags']['keywords']);

		return view('front.nationalbatch.create_post', $data);
	}

	public function sumbitAd(Request $request, $ad_type, $id = null) {
		$data = $request->all();
		$success_text = $ad_type == 'update_ad' ? 'Update Ad' : ($ad_type == 'create_free_ad' ? 'Free Ad' : 'Premium Ad');

		$batch = Batche::findOrNew($id ? base64_decode($id) : 0);
		// $adtype = $desi->id ? "updated" : "created";
		$rules = array(
			'title' => 'required|min:5',
			// 'images' => 'image|mimes:jpeg,png,jpg|max:200',
			'description' => 'required|min:5',
			// 'details' => 'required',
			'category' => 'required',
			'email' => 'required|email',
			'state_id' => 'required',
			'expiry_date' => 'required|date',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$batch->state_code = $data['state_id'];
			$batch->title = $data['title'];
			$batch->category = $data['category'];
			$batch->details = $data['description'];
			$batch->email_id = $data['email'];
			$batch->expdate = date('Y-m-d', strtotime($data['expiry_date']));
			$batch->other_details = $data['otherdetails'];
			$batch->user_id = Auth::user()->id;

			if ($request->file('images')) {
				$image = $request->file('images');
				$image_name = uniqname() . '.' . $image->getClientOriginalExtension();
				$image->move(public_path('upload/batches'), $image_name);
				$batch->image = $image_name;
			}
			$batch->save();
			$getid = $batch->id;
			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'National Batch',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $success_text,
			);
			sendCommentAlert($mail_data);

			sendNotification("Batche", array(
				"type" => 'Batche',
				"username" => Auth::user()->name,
				"id" => $getid,
			));

			\Session::flash('success', 'your national batch ad will be reviewed and live soon hang tight … thank you');
			$json['location'] = route('nationalbatch.index', ['id' => base64_encode($data['category'])]);
		}
		return $json;
	}

	public function deleteAd(Request $request, $id) {
		$partner = Batche::findOrFail(base64_decode($id));
		if ($partner->user_id == Auth::user()->id) {
			$partner->delete();
			\Session::flash('success', 'My partner Ad Deleted Successfully.');
		} else {
			\Session::flash('error', 'You are not authorized to delete this Batche Ad.');
		}
		return redirect()->back();
	}
}