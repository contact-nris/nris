<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\NationalBatch;
use Illuminate\Http\Request;
use Validator;

class NationalBatchController extends Controller {
	public function index(Request $request) {
		$query = NationalBatch::selectRaw('national_batches.*,batches_categories.name as category_name')
			->leftJoin('batches_categories', 'batches_categories.id', 'national_batches.category')
			->where('national_batches.country', country_id());
		$data['lists'] = $query->orderBy('id', 'DESC')->paginate();
		return view('admin.national_batches.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['batch'] = NationalBatch::findOrNew($id);
		return view('admin.national_batches.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$batch = NationalBatch::findOrNew($id);
		$rules = array(
			'title' => 'required|max:120',
			'category' => 'required',
			'details' => 'required',
			'status' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$batch->title = $request->title;
			$batch->category = (int) $request->category;
			$batch->details = $request->details;
			$batch->expdate = date("Y-m-d", strtotime($request->expdate));
			$batch->status = (int) $request->status;

			if ($request->hasFile('image')) {
				$batch->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/national_batches'), $batch->image);
			}

			if ((int) $batch->id == 0) {
				$batch->country = country_id();
			}

			$batch->save();

			\Session::flash('success', 'National batch Data Saved Successfully.');
			$json['location'] = route('national_batches.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$batch = NationalBatch::findOrNew($id);
		$batch->remove();

		\Session::flash('success', 'National batch Deleted Successfully.');
		return redirect()->back();
	}
}
