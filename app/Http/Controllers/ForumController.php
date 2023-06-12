<?php

namespace App\Http\Controllers;

use App\ForumCategory;
use App\ForumParentCategory;
use App\ForumReply;
use App\ForumThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ForumController extends Controller {
	/*public function index2(Request $request){
	        set_time_limit(-1);
	        $json = json_decode('[{"forum_id":1,"cate":13}]',1);

	        foreach ($json as $key => $value) {

	            ForumThread::where('id', (int)$value['forum_id'])->update(array(
	                'sub_category_id' => (int)$value['cate'],
	            ));
	        }

	        echo 'done';
*/

	public $meta_tags = array(
		'title' => 'ForumThread',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our ForumThread and stay updated with the latest posts.',
		'twitter_title' => 'ForumThread',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);

	public function index(Request $request) {
		$data['category'] = ForumParentCategory::orderBy('name')->get();
		$data['forums'] = array();

		foreach ($data['category'] as $key => $category) {
			$data['forums'][$category->id] = ForumThread::selectRaw('
                forums_thread.*,
                forums_categoires.name as sub_cate,
                forums_categoires.image as sub_cate_img,
                CONCAT(users.first_name, " ", users.last_name) username,
                users.profile_photo,
                (SELECT COUNT(*) FROM forums_reply WHERE forums_reply.forum_thread_id = forums_thread.id) as total_reply
            ')
				->leftJoin('users', 'users.id', 'forums_thread.user_id')
				->leftJoin('forums_reply', 'forums_reply.forum_thread_id', 'forums_thread.id')
				->leftJoin('forums_categoires', 'forums_categoires.id', 'forums_thread.sub_category_id')
				->where('forums_categoires.parent_id', $category->id)
				->groupBy('forums_thread.sub_category_id')
				->orderBy('forums_thread.created_at', 'DESC')
				->limit(5)
				->get();
		}

		$data['meta_tags'] = $this->meta_tags;

		return view('front.forum.index', $data);
	}

	public function viewSubCate(Request $request, $enc_id) {
		$id = (int) base64_decode($enc_id);

		$category = ForumCategory::find($id);
		if ($category) {
			$parentCategory = ForumParentCategory::find($category->parent_id);

			$data['meta_tags'] = array(

				'title' => $category->name . " | Forum",
				'description' => 'An Indian community website for all NRI\'S residing in United States. Get information on local real estate, Indian movies, restaurants, visiting spots etc.',
				'twitter_title' => $category->name . " | Forum",
				'keywords' => 'Forums at NRIS have all the discussion threads based on Bollywood & Hollywood movies, Indian & Global news, sports including Cricket, Football and many more. NRI forum USA, Indian NRIS forum talk, best forum for Indian NRIS',
			);

			$query = ForumThread::selectRaw('
                forums_thread.*,
                CONCAT(users.first_name, " ", users.last_name) username,
                users.profile_photo')
				->with('comments')
				->leftJoin('users', 'users.id', 'forums_thread.user_id')
				->orderBy('forums_thread.total_views', 'DESC');
			$data['forums'] = $query->where('forums_thread.sub_category_id', $id)->paginate();

			$data['forums_recent'] = ForumThread::selectRaw('
                forums_thread.*,
                CONCAT(users.first_name, " ", users.last_name) username,
                users.profile_photo
            ')
				->with('comments')
				->leftJoin('users', 'users.id', 'forums_thread.user_id')
				->limit(3)
				->orderBy('forums_thread.created_at', 'DESC')
				->where('forums_thread.sub_category_id', $id)
				->get();

			$data['category'] = $category;
			$data['sub_category_id_encode'] = $enc_id;
			$data['parentCategory'] = $parentCategory;
		}

		return view('front.forum.thread_list', $data);
	}



	public function view(Request $request, $slug) {
		$explode = explode('-', $slug);
		$id = (int) end($explode);
		$data = $request->all();

		$data['forums'] = ForumThread::selectRaw('
            forums_thread.*,
            forums_categoires.name as sub_cate,
            fpc.name as parent_cat_name,
            CONCAT(users.first_name, " ", users.last_name) username,
            users.profile_photo,
            users.mobile,
            (SELECT COUNT(*) FROM forums_reply WHERE forums_reply.forum_thread_id = forums_thread.id) as total_reply
        ')
			->leftJoin('forums_reply', 'forums_reply.forum_thread_id', 'forums_thread.id')
			->leftJoin('users', 'users.id', 'forums_thread.user_id')
			->leftJoin('forums_categoires', 'forums_categoires.id', 'forums_thread.sub_category_id')
			->leftJoin('forums_parent_categoires as fpc', 'fpc.id', 'forums_categoires.parent_id')
			->groupBy('forums_thread.sub_category_id')
			->orderBy('forums_thread.created_at', 'DESC')
			->where('forums_thread.id', $id)
			->firstOrFail();

		$data['comments'] = ForumReply::selectRaw('forums_reply.*, users.profile_photo, users.first_name, users.last_name')->leftJoin("users", "users.id", "user_id")->where('forum_thread_id', $data['forums']->id)->where('reply_id', 0)->orderBy('created_at', 'desc')->paginate(5);

		ForumThread::find($id)->increment('total_views', 1);

		$data['meta_tags'] = array(
			'meta_title' => $data['forums']->meta_title,
			'meta_description' => $data['forums']->meta_description,
			'meta_keywords' => $data['forums']->meta_keywords,
			'title' => $data['forums']->title,
			'description' => $data['forums']['description'],
			'twitter_title' => $data['forums']['title'],
			'image_' => $data['forums']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		return view('front.forum.view', $data);
	}

	public function submitForm(Request $request, ForumReply $comment) {
		$data = $request->all();

		$rules = array(
			'comment' => 'required|min:2',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$ForumReplay = new ForumReply();
			$ForumReplay->comment = $request->comment;
			$ForumReplay->forum_thread_id = $request->model_id;
			$ForumReplay->user_id = Auth::user() ? Auth::user()->id : 0;
			$ForumReplay->reply_id = $comment->id ? $comment->id : 0;
			$ForumReplay->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => Auth::user()->email,
				'type' => 'Forum Ad',
				'name' => Auth::user()->name,
				'sub_type' => $comment->id ? 'Reply' : 'Comment',
			);
			sendCommentAlert($mail_data);

			\Session::flash('success', 'Comment Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}

	public function ThreadSearch(Request $request) {
		$data = $request->all();

		$query = ForumThread::selectRaw('
            forums_thread.*,
            CONCAT(users.first_name, " ", users.last_name) username
        ')
			->with('comments')
			->leftJoin('users', 'users.id', 'forums_thread.user_id')
			->orderBy('forums_thread.created_at', 'DESC');

		if ($request->filter_name) {
			$query->where('forums_thread.title', 'LIKE', '%' . $request->filter_name . '%');
		}
		$data['forums'] = $query->paginate();

		$data['meta_tags'] = $this->meta_tags;

		return view('front.forum.thread_search_list', $data);
	}

	public function CreateForum(Request $request, $enc_id) {
		$data = $request->all();
		$id = (int) base64_decode($enc_id);

		$category = ForumCategory::find($id);
		if ($category) {
			$data['parentCategory'] = ForumParentCategory::find($category->parent_id);
		}

		$data['sub_category_id'] = $enc_id;
		$data['user'] = Auth::user();
		$data['meta_tags'] = $this->meta_tags;

		return view('front.forum.create', $data);
	}

	public function SubmitForumData(Request $request) {
		$data = $request->all();

		$forum = new ForumThread();

		$rules = array(
			'title' => 'required|unique:forums_thread,title|min:5|regex:/^[a-zA-Z0-9 !@%$&#*_;\-:?><,"]+$/',
			'description' => 'required',
			'sub_category_id' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
		    $forum->title = $data['title'];
			$forum->description = $data['description'];
			$forum->sub_category_id = (int) base64_decode($data['sub_category_id']);
			$forum->status = 1;
			$forum->user_id = Auth::user()->id;

			$forum->save();

			\Session::flash('success', 'Forum Thread Saved Successfully.');
			$json['location'] = route('front.forum_subcate', $data['sub_category_id']);
		}

		return $json;
	}

}
