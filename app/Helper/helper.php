<?php
 
function count_data()
{	
	$auto = \App\AutoClassified::where(['display_status'=>'0'])->count();
	$job = \App\JobClassifieds::where(['display_status'=>'0'])->count();
	$babysitting = \App\BabySittingClassified::where(['display_status'=>'0'])->count();
	$mypartner = \App\MyPartner::where(['display_status'=>'0'])->count();
	$real_estate = \App\RealEstate::where(['display_status'=>'0'])->count();
	$rommmate = \App\RoomMate::where(['display_status'=>'0'])->count();
	$garagesale = \App\GarageSale::where(['display_status'=>'0'])->count();
	$free_stuff = \App\FreeStuff::where(['display_status'=>'0'])->count();
	$other = \App\Other::where(['display_status'=>'0'])->count();
	$edutech = \App\EducationTeachingClassified::where(['display_status'=>'0'])->count();
	$electronics = \App\ElectronicsClassifieds::where(['display_status'=>'0'])->count();
	
	echo $auto+$job+$babysitting+$mypartner+$real_estate+$rommmate+$garagesale+$free_stuff+$other+$edutech+$electronics;

}

function sendNotification($title, $body){
}

function userPhoto($obj, $test = 0){
	if(isset($obj['profile_photo']) ){
		if(trim($obj['profile_photo']) != '' && file_exists(public_path('upload/users/').$obj['profile_photo']) ){
            return assets_url("upload/users/".$obj['profile_photo']);
        } else {
        	$alpha = strtolower(isset($obj['first_name']) ? $obj['first_name'][0] : 'N');
        	$colors = array(
			    'a' => '00bfa5',
			    'b' => '6200ea',
			    'c' => 'ffd600',
			    'd' => '64dd17',
			    'e' => 'aa00ff',
			    'f' => 'c51162',
			    'g' => '2962ff',
			    'h' => '00c853',
			    'i' => 'ffab00',
			    'j' => '0091ea',
			    'k' => 'ffffff',
			    'l' => '304ffe',
			    'm' => 'd50000',
			    'n' => 'aeea00',
			    'o' => '263238',
			    'p' => 'dd2c00',
			    'q' => '212121',
			    'r' => '00b8d4',
			    's' => '00b8d4',
			    't' => '00bfa5',
			    'u' => '6200ea',
			    'v' => 'ffd600',
			    'w' => '64dd17',
			    'x' => 'aa00ff',
			    'y' => 'c51162',
			    'z' => '2962ff',
			);
            return 'https://eu.ui-avatars.com/api/?background='. (isset($colors[$alpha]) ? $colors[$alpha] : '') .'&name='. $alpha . '+' . (isset($obj['last_name']) ? $obj['last_name'][0] : 'A');
        }
	}

	return null;
}

function fc($string){
	return isset($string[0]) ? $string[0] : '';
}
function likeDislike($totals){
	$json_totals = array('0' => 0,'1' => 0);
	 
    if($totals){
        foreach ($totals as $key => $value) {
            $json_totals[$value->status] = $value->total;
        }
    }

    return $json_totals;
}

function amount($amount){
	return  '$'. number_format((float)$amount);
}
function na($string){
	return  trim($string) ? $string : 'NA';
}

function slug($string){
	return \Illuminate\Support\Str::slug($string);
}

function format_dp($date, $type=''){
	if($date){
		if($type == 'front'){
			return date("d-m-Y", strtotime($date));
		}
		return date("Y-m-d", strtotime($date));
	}
}

function date_full($date){
	if($date){
		return date("M d Y h:i A", strtotime($date));
	}
}

function date_f($date){
	if($date){
		return date("M d Y", strtotime($date));
	}
}

function date_with_month($date){
	if($date){
		return date("d M, Y", strtotime($date));
	}
}

function assets_url($path){
	if($path){
		return url($path);
		//return 'https://nris.com/stuff/'.$path;
		// return 'https://nris.com/sumd2014/'.$path;
		return 'https://nris.com/'.$path;
	}
}

function old_get($input,$default = ''){
	return isset($_GET[$input]) ? $_GET[$input] : $default;
}


function status_text($status){
	return (int)$status == 1 ? '<span class="badge bg-green">Active</span>' : '<span class="badge bg-danger">InActive</span>';
}
function status_text_text($status){
	return $status == 'Active' ? '<span class="badge bg-green">Active</span>' : '<span class="badge bg-danger">InActive</span>';
}


function selected_country(){
	return 1;
}

function states($skipCountry = false){
	if($skipCountry) return \App\State::all();

	$selected_country = country_id();
	return \App\State::where('country_id',$selected_country)->get();
}


function get_states(){

    
	$a=  \App\State::select(DB::raw('group_concat(code) as codes'))->where('country_id',country_id())->get();
//	return '['. $a[0]->codes .']';
		return   (array)$a[0]->codes ;
		//return $a[0];
}

function get_states_id($id){

    
	$a=  \App\State::select(DB::raw('group_concat(code) as codes'))->where('country_id',$id)->get();
//	return '['. $a[0]->codes .']';


		return  (array) $a[0]->codes ;

		//return $a[0];
}



function get_city($id){
   
    
	$a=  \App\City::select('name')->where('id',$id)->get();
//	return '['. $a[0]->codes .']';
	if(isset($a[0]->name )){
		return   $a[0]->name ;
	}
		//return $a[0];
}


function countries($skipCountry = false){
	return \App\Country::all();
}
function get_categories(){
	return \App\Categories::all();
}

function country_id($obj = false){
	$selected_country = session('country_id');

	if((int)$selected_country == 0){
        session(['country_id' => 1]);
        $selected_country = 1;
    }

    if($obj){
    	return \App\Country::find($selected_country);
    }

	return $selected_country;
}

function api_error_format($errors){
	$data = array();
	foreach ($errors as $key => $value) {
		$data[$key] = $value[0];
	}

	return $data;
}

function numberformat($_ , $_color = false){
	$negative = false;
	$color = 'text-success';
	if((int)$_ < 0){
		$negative = true;
		$color = 'text-danger';
		$_ = str_replace('-', '', $_);
	}

	$_ = round($_);
	$len = strlen($_);
	switch ($len) {
		case 7:
			$_ = substr_replace($_, ',', 2, 0);
			$_ = substr_replace($_, ',', 5, 0);
			break;
		case 6:
			$_ = substr_replace($_, ',', 1, 0);
			$_ = substr_replace($_, ',', 4, 0);
			break;
		case 5:
			$_ = substr_replace($_, ',', 2, 0);
			break;
		case 4:
			$_ = substr_replace($_, ',', 1, 0);
			break;
		default:
			break;
	}
	if($negative) $_ = '-'.$_;
	elseif((int)$_ == 0) $_ = '';

	if($_color) return "<span class='{$color}'> {$_} </span>";

	return $_;

}

function api_response($json,$status = 200){
	$json['code'] = isset($json['code']) ? $json['code'] : 0;
	return response()->json($json);
}

function rupees($amount){
	return (float)$amount;
}
function partner($id){
	switch ($id) {
		case 1: return "JD"; break;
		case 2: return "Bhavik"; break;
		case 3: return "KC"; break;
		default:  break;
	}
}

function uniqname(){
	return uniqid (rand (),true);
}

function settings($key)
{
    static $settings;

    if(is_null($settings))
    {
        $settings = Cache::remember('settings', 24*60, function() {
            return array_pluck(App\Setting::all()->toArray(), 'value', 'key');
        });
    }

    return (is_array($key)) ? array_only($settings, $key) : $settings[$key];
}

function dashesToCamelCase($string, $capitalizeFirstCharacter = false){

	$str = str_replace(' ', ' ', ucwords(str_replace('_', ' ', $string)));

	if (!$capitalizeFirstCharacter) {
		$str[0] = strtolower($str[0]);
	}

	return $str;
}
function user_profile($img,$username, $color = ''){
	$img_path = assets_url('upload/users/' . $img);
	$img_check = file_exists($img_path);
	// remove #from color
	$color = $color ? str_replace('#', '', $color) : '696969';
	return $img_check ? assets_url('upload/users/' . $img) : 'https://eu.ui-avatars.com/api/?name=' . urlencode($username) .  '&background=' . $color . '&color=fff&size=128';
}

function sendCommentAlert($data){
    // dd($data);
	$sub_type = isset($data['sub_type']) ? $data['sub_type'] : 'Comment';
	$name = isset($data['name']) ? $data['name'] : '';

	if (isset($data['link']) && isset($data['type']) && $data['email'] ) {
		if ($data['type'] == 'Verification') {
			$content = "<html><body>Hello ". $name ." ,\n<br>If you click the Verify Email Address your account will get verified.". $data['link'] . "</body></html>" ;
			$subject = "You have a Register on your " . $data['type'] . " Email Address";
		}
		elseif ($data['type'] == 'Advertise') {
			$content = "<html><body>Hello ". $name ." ,\n<br>You have a ". $sub_type ." on your " . $data['type'] . " post. \n\n<br><br>  " . $sub_type . "</body></html>" ;
			$subject = $sub_type . " on your " . $data['type'] . " post";
		} elseif ($data['type'] == 'Advertise-nris') {

			$content = "<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<title>Contact Form Email</title>
		<style>
			body {
				font-family: Arial, sans-serif;
				font-size: 16px;
				line-height: 1.5;
				color: #333333;
				background-color: #f8f8f8;
				margin: 0;
				padding: 0;
			}
			.container {
				width: 100%;
				max-width: 600px;
				margin: 0 auto;
				padding: 40px;
				background-color: #ffffff;
			}
			.logo {
				display: block;
				margin-bottom: 20px;
				text-align: center;
			}
			.logo img {
				height: 80px;
			}
			h1 {
				font-size: 24px;
				font-weight: bold;
				margin-top: 0;
				margin-bottom: 20px;
				text-align: center;
			}
			p {
				margin-top: 0;
				margin-bottom: 20px;
			}
			.label {
				font-weight: bold;
				margin-bottom: 10px;
				display: block;
			}
			.value {
				margin-bottom: 20px;
			}
			.button {
				display: inline-block;
				background-color: #007bff;
				color: #ffffff;
				padding: 10px 20px;
				border-radius: 5px;
				text-decoration: none;
			}
			.button:hover {
				background-color: #0056b3;
			}
			.footer {
				margin-top: 40px;
				padding-top: 20px;
				border-top: 1px solid #dddddd;
				text-align: center;
			}
			.footer p {
				margin-top: 0;
				margin-bottom: 10px;
				font-size: 14px;
				color: #888888;
			}
		</style>
	</head>
	<body>
		<div class='container'>
			<div class='logo'>
				<img src='https://nris.com/logo_head.png' alt='Logo'>
			</div>
			<h1>Contact Form Submission</h1>
			<p>A new message has been submitted through the Advertise form:</p>
			<div>
				<span class='label'>First Name:</span>
				<span class='value'> ". $data['first_name'] . " </span>
			</div>
			<div>
				<span class='label'>Last Name:</span>
				<span class='value'>". $data['last_name'] . "  </span>
			</div>
			<div>
				<span class='label'>Business Name:</span>
				<span class='value'>". $data['business_name'] . "  </span>
			</div>
			<div>
				<span class='label'>Email:</span>
				<span class='value'>". $data['email2'] . "  </span>
			</div>
			<div>
				<span class='label'>Website Link:</span>
				<span class='value'>". $data['web_link'] . "  </span>
			</div>
			<div>
				<span class='label'>Phone Number:</span>
				<span class='value'>". $data['phone_number'] . "  </span>
			</div>
			<div>
				<span class='label'>Description:</span>
				<span class='value'>". $data['description']  . " </span>
			</div>
			<div>
				<span class='label'>Attached File:</span>
				<span class='value'>
				<img src='". $data['file_path'] . "' alt='Girl in a jacket' width='500' height='600'> </span>
			</div>
			<div class='footer'>
				<p>This message was sent by the contact form on nris.com</p>
				<p>© 2023 Example Inc. All rights reserved.</p>
			</div>
		</div>
	</body>
</html>";
			$subject = $sub_type . " on your " . $data['type'] . " post";
		}
		else{			
			$content = "<html><body>Hello ". $name ." ,\n<br>You have a ". $sub_type ." on your " . $data['type'] . " post. \n\n<br><br>Click on this link to view the  " . $sub_type . ' '. $data['link'] . "</body></html>" ;
			$subject = "You have a " . $sub_type . " on your " . $data['type'] . " post";
		}
		try {
		    /*
			\App\Mails::send(array(
				'to' => $data['email'],
				'subject' => '$subject',
				'content' => $content,
			));
			*/
			
			
			$headers = "From: info@nris.com\r\n";
			$headers .= "MIME-Version: 1.0" . "\r\n"; 
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

            mail($data['email'], $subject, $content, $headers );
    
			return true;
		} catch (\Exception $e) {
		    dd($e);
			return $e->getMessage();
		}
	}
	return false;
}

function verifyTransaction($data) {
	global $paypalUrl;

	$req = 'cmd=_notify-validate';
	foreach ($data as $key => $value) {
		$value = urlencode(stripslashes($value));
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
		$req .= "&$key=$value";
	}

	$ch = curl_init($paypalUrl);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt($ch, CURLOPT_SSLVERSION, 6);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
	$res = curl_exec($ch);

	if (!$res) {
		$errno = curl_errno($ch);
		$errstr = curl_error($ch);
		curl_close($ch);
		throw new Exception("cURL error: [$errno] $errstr");
	}

	$info = curl_getinfo($ch);

	// Check the http response
	$httpCode = $info['http_code'];
	if ($httpCode != 200) {
		throw new Exception("PayPal responded with http code $httpCode");
	}

	curl_close($ch);

	return $res === 'VERIFIED';
}

/**
 * Check we've not already processed a transaction
 *
 * @param string $txnid Transaction ID
 * @return bool True if the transaction ID has not been seen before, false if already processed
 */
function checkTxnid($txnid) {
	global $db;

	$txnid = $db->real_escape_string($txnid);
	$results = $db->query('SELECT * FROM `payments` WHERE txnid = \'' . $txnid . '\'');

	return ! $results->num_rows;
}

/**
 * Add payment to database
 *
 * @param array $data Payment data
 * @return int|bool ID of new payment or false if failed
 */
function addPayment($data) {
	global $db;

	if (is_array($data)) {
		$stmt = $db->prepare('INSERT INTO `payments` (txnid, payment_amount, payment_status, itemid, createdtime) VALUES(?, ?, ?, ?, ?)');
		$stmt->bind_param(
			'sdsss',
			$data['txn_id'],
			$data['payment_amount'],
			$data['payment_status'],
			$data['item_number'],
			date('Y-m-d H:i:s')
		);
		$stmt->execute();
		$stmt->close();

		return $db->insert_id;
	}

	return false;
}

function get_state_name($state_id = false){
	if($state_id == 0){
		return '-';
	}

	$a  = App\State::select('name')->where('id',$state_id)->first();
	if($a){
		return $a->name;
	}else{
		return 'not found with ' .$state_id;
	}

}


function get_state_name_by_code($code = false){
	

	$a  = App\State::select('domain')->where('code',$code)->first();
	if($a){
		return $a->domain;
	}else{
		return 'not found with ' .$code;
	}

}





