<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\User;
use Auth;
use Exception;
use Hash;
use Socialite;
 
class GoogleController extends Controller {


    public function __construct()
    {
        $this->status                       = 'status';
        $this->message                      = 'message';
        $this->code                         = 'status_code';
        $this->data                         = 'data';        

		$this->userService 					= new UserService();
    }
    


	public function redirectToGoogle() {
		return Socialite::driver('google')->redirect();
	}

	public function handleGoogleCallback() {
		try {
			$host 							= $_SERVER['HTTP_HOST'];

			$data 							= explode(".",$host);
			$url 							= $data[0];

			$redirected_url = '/';
			if(str_contains($url, 'canada'))
			{
				$redirected_url = 'https://canada.nris.com/';
			}
			else if(str_contains($url, 'australia'))
			{
				$redirected_url = 'https://australia.nris.com/';
			}			
			else if(str_contains($url, 'uk'))
			{
				$redirected_url = 'https://uk.nris.com/';				
			}
			else if(str_contains($url, 'newzealand'))
			{
				$redirected_url = 'https://newzealand.nris.com/';
			}
			else
			{
				$redirected_url = '/';
			}

			$user 							= Socialite::driver('google')->stateless()->user();
			$param['email']					= $user->email;
			$param['google_id']				= $user->id;
			
			$existingEmailUser				= $this->userService->getUserByEmailId($param);
			
			if(!$existingEmailUser[$this->status])
			{
				$existingUser 					= $this->userService->getUserByGoogleId($param);
				
				if(!$existingUser[$this->status])
				{
					$finalName = str_replace(' ', '', $user->user['given_name'] ?? $user->name);
					$newUser = new User();
								
					$newUser->first_name 		= $user->user['given_name'] ?? $user->name;
					$newUser->last_name 		= $user->user['family_name'] ?? $user->name;
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
						'name' => $user->user['given_name'] . $user->user['family_name'],
						'sub_type' => 'Creadentials || Register Email Address',
					);
					sendCreadentialsAlert($mail_data);

					Auth::login($newUser);
					\Session::flash('success', 'Successfully Profile Created.');
					// return redirect('/');
					return redirect($redirected_url);
				}

				Auth::login($existingUser[$this->data]);
				\Session::flash('success', 'Login Successfully.');
				return redirect($redirected_url);
			}
			else
			{
				if(!empty($existingEmailUser[$this->data]->google_id) || $existingEmailUser[$this->data]->google_id == '')
				{
					$param['id']				= $existingEmailUser[$this->data]->id;
					$updateGoogleId 			= $this->userService->updateUserGoogleIdById($param);
				}
			
				Auth::login($existingEmailUser[$this->data]);
				\Session::flash('success', 'Login Successfully.');

				return redirect($redirected_url);
			}

		} catch (Exception $e) {
			echo "CATCH";
			echo "<pre>";
			print_r($e);
			echo "</pre>";
			dd($e->getMessage());
		}
	}
}
