<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Slider;
use Illuminate\Http\Request;
use Validator;

class SliderController extends Controller {
	public function index(Request $request) {
		$query = Slider::selectRaw('sliders.*');
		$data['lists'] = $query->paginate();
		return view('admin.slider.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['slider'] = Slider::findOrNew($id);
		return view('admin.slider.form', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$slider = Slider::findOrNew($id);
		$rules = array(
			'name' => 'required|min:2|max:120',
		);

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$slider->name = $data['name'];

			$slides = [];

			if ($request->hasFile('slide1')) {
				$name = uniqname() . '.' . $request->file('slide1')->guessExtension();
				$request->file('slide1')->move(public_path('upload/sliders'), $name);
				$slides[] = $name;
			} else if ($request->default_slide1) {
				$slides[] = $request->default_slide1;
			}

			if ($request->hasFile('slide2')) {
				$name = uniqname() . '.' . $request->file('slide2')->guessExtension();
				$request->file('slide2')->move(public_path('upload/sliders'), $name);
				$slides[] = $name;
			} else if ($request->default_slide2) {
				$slides[] = $request->default_slide2;
			}

			if ($request->hasFile('slide3')) {
				$name = uniqname() . '.' . $request->file('slide3')->guessExtension();
				$request->file('slide3')->move(public_path('upload/sliders'), $name);
				$slides[] = $name;
			} else if ($request->default_slide3) {
				$slides[] = $request->default_slide3;
			}

			$slider->slides = $slides;
			$slider->save();

			\Session::flash('success', 'Slider Data Saved Successfully.');
			$json['location'] = route('slider.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$slider = Slider::findOrNew($id);
		$slider->remove();

		\Session::flash('success', 'slider Deleted Successfully.');
		return redirect()->back();
	}
}
