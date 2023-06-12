<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\NRICard;
use App\User;
use Illuminate\Http\Request;
use Validator;

class NRICardController extends Controller {
	public function index() {
		$data['lists'] = NRICard::selectRaw('nris_card.*,CONCAT(users.first_name," ",users.last_name) as user_name')
			->leftJoin('users', 'users.id', 'nris_card.user_id')
			->orderBy('nris_card.id', 'desc')
			->paginate();
		return view('admin.nricard.index', $data);
	}

	public function getForm(Request $request, $id = 0) {
		$data = $request->all();
		$data['users'] = User::all();
		$data['nricard'] = NRICard::findOrNew($id);
		$data['countries'] = \App\Country::all();

		return view('admin.nricard.form', $data);
	}

	public function GenrateCode() {
		//genrate 16 digit number
		$code = '';
		for ($i = 0; $i < 16; $i++) {
			$code .= rand(0, 9);
		}
		$nricard = NRICard::where('card_no', $code)->first();
		if ($nricard) {
			$this->GenrateCode();
		}
		return response()->json(['code' => $code]);
	}

	function get_uniq_slug($title) {
		$num = 1;
		$a = 1;
		while ($num > 0) {
			$txt = $this->clean($title . $a++);
			$num = NRICard::where('url_slug', $txt)->count();
		}
		$a = $a - 1;
		return $title . '-' . $a;
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();
		$nricard = NRICard::findOrNew($id);
		$rules = array(
			'card_type' => 'required',
			'card_no' => 'required|unique:nris_card,card_no|digits:16',
			'fname' => 'required',
			'lname' => 'required',
			'dob' => 'required|date',
			// 'email' => 'required|email|unique:nris_card,email',
			'address' => 'required',
			'country' => 'required',
			'status' => 'required',
			'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		);

		if ($data['card_type'] == '1') {
			$rules['expiry_date'] = 'required|date';
		}

		if ((int) $nricard->id > 0) {
			$rules['card_no'] = 'required|unique:nris_card,card_no,' . $nricard->id;
			// $rules['email'] = 'required|email|unique:nris_card,email,'. $nricard->id;
		}

		$content = route('front.nricard.verifaction', ['card_no' => base64_encode($request->card_no)]);

		if (!$request->status) {
			\App\Mails::send(array(
				'to' => $request->email,
				'subject' => 'Nris Card Activation',
				'content' => 'Click this link for verify your card: <a href="' . $content . '">' . $content . '</a>',
			));
		}

		$json = array();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			// $matchingRecords = NationalEvent::where('url_slug', trim($this->clean($request->title)))->get();
			// $matchingCount = $matchingRecords->count();
			// if ($matchingCount > 0) {
			// 	$new_title = $this->get_uniq_slug($request->title);
			// } else {
			// 	$new_title = $request->title;
			// }

			// if ($id > 0) {
			// 	if (trim($request->title) != $event->title) {
			// 		$event->title = $new_title;
			// 		$event->url_slug = $this->clean($new_title);
			// 	}} else {
			// 	$event->title = $new_title;
			// 	$event->url_slug = $this->clean($new_title);
			// }
			$nricard->card_no = $request->card_no;
			$nricard->card_type = $request->card_type;
			$nricard->user_id = $request->user_id;
			$nricard->fname = $request->fname;
			$nricard->lname = $request->lname;
			$nricard->dob = $request->dob;
			$nricard->email = $request->email;
			$nricard->address = $request->address;
			$nricard->country = $request->country;
			$nricard->status = (int) $request->status;
			$nricard->expiry_date = $request->expiry_date;

			if ($request->hasFile('image')) {
				$nricard->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/nricard'), $nricard->image);
			}

			$nricard->save();

			\Session::flash('success', 'NRI Card Data Saved Successfully.');
			$json['location'] = route('nricard.index');
		}

		return $json;
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$nricard = NRICard::findOrNew($id);
		$nricard->remove();

		\Session::flash('success', 'NRI Card Deleted Successfully.');
		return redirect()->back();
	}
}
