<?php

namespace App\Http\Controllers;

use App\AdvertisementWithUs;
use Auth;
use Illuminate\Http\Request;
use Validator;

class AdvertisingController extends Controller {

	private $meta_tags = array(
		'title' => 'Advertisement With Us %s',
		'description' => 'Get the latest updates and information from the portal of NRIs community in USA. Read our AdvertisementWithUs and stay updated with the latest posts.',
		'twitter_title' => 'Advertisement With Us',
		'image_' => '',
		'keywords' => 'Indian websites in %s, NRI websites, Indian community websites, classified website for NRIS in %s, free ads website',
	);
	public function index(Request $request) {

		$country_id = $request->req_country ? $request->req_country['id'] : 1;
		$place_name = $request->req_country ? $request->req_country['name'] : 'USA';

		$data['meta_tags'] = $this->meta_tags;
		$data['meta_tags']['title'] = sprintf($data['meta_tags']['title'], $place_name);
		$data['meta_tags']['keywords'] = str_replace('%s', $place_name, $data['meta_tags']['keywords']);

		return view('front.advertising', $data);
	}

	public function submitForm(Request $request, $id = 0) {
		$data = $request->all();

		$rules = array(
			'first_name' => 'required| min:2 | max:100',
			'last_name' => 'required | min:2 | max:100',
			'business_name' => 'required | min:2 | max:1000',
			'email' => 'required|email | min:2 | max:100',
			// 'web_link'  => 'url | min:2 | max:100',
			// 'phone_number'  => 'required|digits:10',
			// 'image'  => 'required|mimes:jpeg,jpg,png,gif|max:1024',
			'description' => 'required',
		);

		$json = array();

		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$advertising = new AdvertisementWithUs();
			$advertising->fname = $request->first_name;
			$advertising->lname = $request->last_name;
			$advertising->business = $request->business_name;
			$advertising->email = $request->email;
			$advertising->website = $request->web_link;
			$advertising->phone = $request->phone_number;
			$advertising->image = $request->image;
			$advertising->message = $request->description;

			if ($request->hasFile('image')) {
				$advertising->image = uniqname() . '.' . $request->file('image')->guessExtension();
				$request->file('image')->move(public_path('upload/img'), $advertising->image);
			}
//	'email' => 'contact@nris.com',
//venky@skyhitmedia.com
//durganaveenz@gmail.com
			$advertising->save();
			$mail_data = array(
				'link' => $request->web_link,
				'email' => 'venky@skyhitmedia.com',
				'type' => 'Advertise-nris',
				'name' => 'Venky',
				'sub_type' => "Add New Advertise added in NRIS.COM",
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'business_name' => $request->business_name,
			'email2' => $request->email,
			'web_link' => $request->web_link,
			'phone_number' => $request->phone_number,
			'file_path' => 'https://nris.com/upload/img/' . $advertising->image,
			'description' => $request->description,
			);
			
// 			echo "af";
// 			print_r($mail_data);
			sendCommentAlert($mail_data);
			
// 			exit;
		 if(isset(Auth::user()->name)){
		     $name = Auth::user()->name;
		 }else{
		     $name = "";
		 }
			$mail_data = array(
				'link' => $request->web_link,
				'email' => 'contact@nris.com',
				'type' => 'Advertise-nris',
				'name' => $name,
					'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'business_name' => $request->business_name,
			'email2' => $request->email,
			'web_link' => $request->web_link,
			'phone_number' => $request->phone_number,
			'file_path' => 'https://nris.com/upload/img/' . $advertising->image,
			'description' => $request->description,
			
				'sub_type' => "Add New Advertise added in NRIS.COM",
			);
			sendCommentAlert($mail_data);
			
if(isset(Auth::user()->name )){
  	$content = "<html><body>Hello " . Auth::user()->name . " ,\n<br>You have a Add New Advertise added in NRIS.COM on your Advertise post. \n\n<br><br> Add New Advertise added in NRIS.COM</body></html>";


	$mail_data = array(
				'link' => $request->web_link,
				'email' => Auth::user()->email,
				'type' => 'Advertise',
				'name' => $request->user ? $request->user : Auth::user()->name,
				'sub_type' => "Add New Advertise added in NRIS.COM",
			);
			sendCommentAlert($mail_data);
}else{
    	$content = "<html><body>Hello  ,\n<br>You have a Add New Advertise added in NRIS.COM on your Advertise post. \n\n<br><br> Add New Advertise added in NRIS.COM</body></html>";
		
}
// 			$subject = "Add New Advertise added in NRIS.COM on your Advertise post";

// 			\App\Mails::send(array(
// 				'to' => Auth::user()->email,
// 				'subject' => $subject,
// 				'content' => $content,
// 				'cc' => array('nrisnetwork@gmail.com'),
// 			));

			\Session::flash('success', 'Your Information Saved Successfully.');
			$json['location'] = route('front.advertising');
		}

		return $json;
	}

}
