<?php

namespace App\Http\Controllers\Admin;

use App\AutoModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AutoModelController extends Controller {
	public function index(Request $request) {
		$query = AutoModel::selectRaw('auto_models.*,auto_makes.name as auto_make')
			->leftJoin('auto_makes', 'auto_makes.id', 'auto_models.auto_make_id');

		if ($request->filter_name) {
			$query->where('auto_models.name', 'like', '%' . $request->filter_name . '%');
		}
		if ($request->auto_make_id) {
			$query->where('auto_models.auto_make_id', (int) $request->auto_make_id);
		}

		$data['lists'] = $query->paginate();

		return view('admin.automodel.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['automodel'] = AutoModel::findOrNew($id);

		return view('admin.automodel.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$automodel = AutoModel::findOrNew($id);
		$rules = array(
			'model_name' => 'required|min:2|max:120',
			'auto_make_id' => 'required',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$automodel->model_name = $data['model_name'];
			$automodel->auto_make_id = (int) $data['auto_make_id'];
			$automodel->save();

			\Session::flash('success', 'Auto Model Data Saved Successfully.');
			$json['location'] = route('automodel.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$automodel = AutoModel::findOrNew($id);
		$automodel->remove();

		\Session::flash('success', 'Auto Model Deleted Successfully.');
		return redirect()->back();
	}
}
