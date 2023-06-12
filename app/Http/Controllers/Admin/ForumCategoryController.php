<?php

namespace App\Http\Controllers\Admin;

use App\ForumCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ForumCategoryController extends Controller {
	public function index() {
		$data['lists'] = ForumCategory::selectRaw('forums_categoires.*, p.name as parent_name')
			->leftJoin('forums_categoires as p', 'p.id', 'forums_categoires.parent_id')
			->paginate();
		return view('admin.forum.category.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['category'] = ForumCategory::findOrNew($id);

		return view('admin.forum.category.form', $data);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = ForumCategory::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$category = ForumCategory::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$matchingRecords = ForumCategory::where('url_slug', trim($this->clean($request->name)))->get();
			$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($request->name);
			} else {
				$new_title = $request->name;
			}

			if ($id > 0) {
				if (trim($request->name) != $category->name) {
					$category->name = $new_title;
					$category->url_slug = $this->clean($new_title);
				}} else {
				$category->name = $new_title;
				$category->url_slug = $this->clean($new_title);
			}
			$category->parent_id = (int) $data['parent_id'];
			$category->save();

			\Session::flash('success', 'Forum Category Data Saved Successfully.');
			$json['location'] = route('forum_category.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$category = ForumCategory::findOrNew($id);
		$category->remove();

		\Session::flash('success', 'Forum Category Deleted Successfully.');
		return redirect()->back();
	}
}
