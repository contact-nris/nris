<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogCategory;
use App\BlogComment;
use App\BlogLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class BlogController extends Controller {

	public $meta_tags = array(
		'title' => 'Blog',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our Blog and stay updated with the latest posts.',
		'twitter_title' => 'Blog',
		'image_' => '',
		'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
	);

	public function index(Request $request) {
		$query = Blog::selectRaw('blogs.*,blogs_categoires.name as category_name')
			->withCount('blog_like')
			->leftJoin('blogs_categoires', 'blogs_categoires.id', 'blogs.category_id');

		if ($request->category_id) {
			$query->where('blogs.category_id', (int) $request->category_id);
		}

		if ($request->filter_name) {
			$query->where('blogs.title', 'like', '%' . $request->filter_name . '%');
		}

		$query->where(array('blogs.visibility' => 'Public'));
		$data['lists'] = $query->orderBy('blogs.id', 'desc')->paginate(16);

		if (auth()->user()) {
			foreach ($data['lists'] as $key => $val) {
				$val->like_status = BlogLike::selectRaw('status')->where(array('blog_id' => $val->id, 'user_id' => auth()->user()->id))->orWhereNull('status')->value('status');
			}
		}

		$data['categories'] = BlogCategory::all();
		$data['meta_tags'] = $this->meta_tags;

		// echo "<pre>";
		// print_R($data);
		// exit;

		return view('front.blog.list', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = Blog::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function view(Request $request, $slug) {

		$data = $request->all();

		$explode = explode('-', $slug);
		$id = (int) end($explode);

		if (isset($_GET['test'])) {
			dd($explode, $id);
		};

		$data['blog'] = Blog::selectRaw('blogs.*,blogs_categoires.name as category_name')
			->leftJoin('blogs_categoires', 'blogs_categoires.id', 'blogs.category_id')
			->orderBy('blogs.id', 'desc')
			->where(array('blogs.visibility' => 'Public', 'blogs.id' => $id))
			->firstOrFail();

		$data['comments'] = BlogComment::selectRaw('blogs_comment.*, users.profile_photo, CONCAT(users.first_name," ", users.last_name) AS user')->leftJoin("users", "users.id", "user_id")->where('blog_id', $data['blog']->id)->where('reply_id', 0)->orderBy('created_at', 'desc')->paginate(5);

		if (auth()->check()) {
			$data['likeModel'] = BlogLike::where([
				'blog_id' => $data['blog']->id,
				'user_id' => auth()->user()->id,
			])->first();

			$data['likeTotal'] = likeDislike(BlogLike::selectRaw('COUNT(status) as total, status')->where('blog_id', $data['blog']->id)->where('status', '>=', 0)->groupBy('status')->get());
		}

		$data['meta_tags'] = array(
			'meta_title' => $data['blog']->meta_title,
			'meta_description' => $data['blog']->meta_description,
			'meta_keywords' => $data['blog']->meta_keywords,
			'title' => $data['blog']->title,
			'description' => $data['blog']->description,
			'twitter_title' => $data['blog']->title,
			'image_' => $data['blog']->image_url,
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',

		);
		return view('front.blog.view', $data);
	}

	public function submitForm(Request $request, BlogComment $comment) {
		$json = array();
		$data = $request->all();
		$rules = array(
			'comment' => 'required|min:2|max:120',
			'model_id' => 'required',
		);

		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$BlogComment = new BlogComment();
			$BlogComment->comment = $request->comment;
			$BlogComment->reply_id = $comment->id ? $comment->id : 0;
			$BlogComment->blog_id = (int) $request->model_id;
			$BlogComment->user_id = Auth::user()->id;
			$BlogComment->save();

			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Blog Ad',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => $comment->id ? 'Reply' : 'Comment',
			);
			sendCommentAlert($mail_data);

			\Session::flash('success', 'Comment Saved Successfully.');
			$json['reload'] = true;
		}

		return $json;
	}

	public function createAd(Request $request, $id = null) {
		$data = $request->all();

		$data['ad'] = Blog::findOrNew($id ? base64_decode($id) : 0);
		$data['category'] = BlogCategory::all();
		$data['id'] = $id;

		$country_id = $data['ad']->country_id ?: ($request->req_country ? $request->req_country['id'] : '1');
		$country_name = $request->req_country ? $request->req_country['name'] : 'USA';

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $country_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $country_name, $data['meta_tags']['keywords']);

		return view('front.blog.create', $data);

	}

	public function sumbitAd(Request $request, $id = null) {
		$data = $request->all();

		$blog = Blog::findOrNew($id ? base64_decode($id) : 0);

		$rules = array(
			'title' => 'required|min:5', //|unique:post_free_real_estate,title,'.$blog->id,
			'description' => 'required',
			'category' => 'required',
			'visibility' => 'required',
			// 'blog_img' => 'mimes:jpeg,png,jpg|max:200',
		);

		$json = array();
		$validator = Validator::make($data, $rules);

		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = Blog::where('url_slug', trim($this->clean($request->title)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->title);
			} else {
				$new_title = $request->title;
			}

			if ($id > 0) {
				if (trim($request->title) != $blog->title) {
					$blog->title = $new_title;
					$blog->url_slug = $this->clean($new_title);
				}} else {
				$blog->title = $new_title;
				$blog->url_slug = $this->clean($new_title);
			}

			if ($request->file('blog_img')) {
				$file = $request->file('blog_img');
				$filename = time() . '.' . $file->guessExtension();
				$file->move(public_path('upload/blog'), $filename);
				$data['image'] = $filename;
			}

			$blog->title_slug = \Str::slug($blog->title, '-');
			$blog->description = $data['description'];
			$blog->category_id = $data['category'];
			$blog->visibility = $data['visibility'];
			$blog->image = $data['image'] ? $data['image'] : "";
			$blog->save();
			$getid = $blog->id;

			$mail_data = array(
				'link' => $request->current_url,
				'email' => $request->email ? $request->email : Auth::user()->email,
				'type' => 'Blog',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => 'Create A Blog',
			);
			sendCommentAlert($mail_data);
			sendNotification("Blog", array(
				"type" => 'Create A Blog',
				"username" => Auth::user()->name,
				"id" => $getid,
			));

			\Session::flash('success', 'your Blog will be reviewed and live soon hang tight … thank you');
			$json['location'] = route('front.blog');
		}

		return $json;
	}
}
