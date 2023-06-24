<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\User;
use Auth;
use Exception;
use Hash;
use Socialite;
 
class TwitterController extends Controller {



    public function __construct()
    {
        $this->status                       = 'status';
        $this->message                      = 'message';
        $this->code                         = 'status_code';
        $this->data                         = 'data';        
        $this->medium                       = 'twitter';        

		$this->userService 					= new UserService();
    }
    


	public function redirectToTwitter() {
		return Socialite::driver($this->medium)->redirect();
	}

	public function handleCallback() {
		
		$user 								= Socialite::driver($this->medium)->user();

		try {
			$host 							= $_SERVER['HTTP_HOST'];

			$data 							= explode(".",$host);
			$url 							= $data[0];

			$redirected_url = '/';
			if(str_contains($url, 'canada'))
			{
				$redirected_url 			= 'https://canada.nris.com/';
			}
			else if(str_contains($url, 'australia'))
			{
				$redirected_url 			= 'https://australia.nris.com/';
			}			
			else if(str_contains($url, 'uk'))
			{
				$redirected_url			 	= 'https://uk.nris.com/';				
			}
			else if(str_contains($url, 'newzealand'))
			{
				$redirected_url 			= 'https://newzealand.nris.com/';
			}
			else
			{
				$redirected_url 			= '/';
			}

			$param['email']					= $user->email;
			$param['twitter_id']	     	= $user->id;
			
			$existingEmailUser				= $this->userService->getUserByEmailId($param);
			
			if(!$existingEmailUser[$this->status])
			{
				$existingUser 					= $this->userService->getUserByTwitterId($param);
				
				if(!$existingUser[$this->status])
				{
					$finalName = str_replace(' ', '', $user->user['nickname'] ?? $user->name);
					$newUser = new User();
								
					$newUser->first_name 		= $user->user['name'] ?? $user->name;
					$newUser->last_name 		= $user->user['nickname'] ?? $user->nickname;
					$newUser->email 			= $user->email;
					$newUser->password 			= Hash::make($finalName.'@'.$user->id);
					$newUser->dob 				= '0000-00-00';
					$newUser->is_verify 		= '1';
					$newUser->google_id 		= $user->id;

					$newUser->save();

					$mail_data 					= array(
						'email' => $user->email,
						'pass' => $finalName.'@'.$user->id,
						'type' => 'Creadentials',
						'name' => $user->user['name'] . $user->user['nickname'],
						'sub_type' => 'Creadentials || Register Email Address',
					);
					sendCreadentialsAlert($mail_data);

					Auth::login($newUser);
					\Session::flash('success', 'Successfully Profile Created.');
					return redirect($redirected_url);
				}

				Auth::login($existingUser[$this->data]);
				\Session::flash('success', 'Login Successfully.');
				return redirect($redirected_url);
			}
			else
			{
				if(!empty($existingEmailUser[$this->data]->twitter_id) || $existingEmailUser[$this->data]->twitter_id == '')
				{
					$param['id']				= $existingEmailUser[$this->data]->id;
					$updateGoogleId 			= $this->userService->updateUserTwitterIdById($param);
				}
			
				Auth::login($existingEmailUser[$this->data]);
				\Session::flash('success', 'Login Successfully.');

				return redirect($redirected_url);
			}

		} catch (Exception $e) {
			echo "CATCH";
			echo "<pre>";
			print_r($e->getMessage());
			echo "</pre>";
			dd($e->getMessage());
		}
	}
}
