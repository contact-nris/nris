<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class BlogController extends Controller {
	public function index() {
		$data['lists'] = Blog::selectRaw('blogs.*,blogs_categoires.name as category_name')
			->leftJoin('blogs_categoires', 'blogs_categoires.id', 'blogs.category_id')
			->paginate();
		return view('admin.blog.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['blog'] = Blog::findOrNew($id);

		return view('admin.blog.form', $data);
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

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$blog = Blog::findOrNew($id);
		$rules = array(
			'title' => 'required|min:2|max:120',
			'description' => 'required',
			'category_id' => 'required',
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
			$blog->url = $request->url;
			$blog->title_slug = \Str::slug($blog->title, '-');
			$blog->description = $request->description;
			$blog->category_id = $request->category_id;
			$blog->image = $request->image;
			$blog->status = (int) $request->status;
			$blog->visibility = $request->visibility;

			$blog->meta_title = $request->meta_title;
			$blog->meta_description = $request->meta_description;
			$blog->meta_keywords = $request->meta_keywords;

			if ($request->hasFile('image')) {
				$blog->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/blog'), $blog->image);
			}

			$blog->save();

			\Session::flash('success', 'Blog Data Saved Successfully.');
			$json['location'] = route('blog.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$blog = Blog::findOrNew($id);
		$blog->remove();

		\Session::flash('success', 'Blog Deleted Successfully.');
		return redirect()->back();
	}
}
