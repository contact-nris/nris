<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use Log;

class UserService
{

    public function __construct()
    {
        $this->status                       = 'status';
        $this->message                      = 'message';
        $this->code                         = 'status_code';
        $this->data                         = 'data';        
    }
    
    public function getUserByGoogleId($param)
    {
        $return[$this->status]              = false;
        $return[$this->message]             = 'Oops, something went wrong...';
        $return[$this->code]                = 201;
        $return[$this->data]                = [];

        if($param['google_id'] != '' && !empty($param['google_id']))
        {

            $getUser                        = User::where('google_id', $param['google_id'])->first();

            if($getUser)
            {

                
                $return[$this->status]      = true;
                $return[$this->message]     = 'Successfully user found...';
                $return[$this->code]        = 200;
                $return[$this->data]        = $getUser;

            }
            else
            {
                $return[$this->status]      = false;
                $return[$this->message]     = 'User not found...';
                $return[$this->code]        = 404;
            }
        }
       
        return $return;
        
    }


    public function getUserByEmailId($param)
    {
        $return[$this->status]              = false;
        $return[$this->message]             = 'Oops, something went wrong...';
        $return[$this->code]                = 201;
        $return[$this->data]                = [];

        if($param['email'] != '' && !empty($param['email']))
        {
            $getUser                        = User::where('email', $param['email'])->first();
            if($getUser)
            {
                $return[$this->status]      = true;
                $return[$this->message]     = 'Successfully user found...';
                $return[$this->code]        = 200;
                $return[$this->data]        = $getUser;
            }
            else
            {
                $return[$this->status]      = false;
                $return[$this->message]     = 'User not found...';
                $return[$this->code]        = 404;
            }
        }
       
        return $return;        
        
    }




    public function updateUserGoogleIdById($param)
    {
        $return[$this->status]              = false;
        $return[$this->message]             = 'Oops, something went wrong...';
        $return[$this->code]                = 201;
        $return[$this->data]                = [];

        if($param['id'] != '' && !empty($param['id']))
        {

            $updateSt                       = User::where('id',$param['id'])
                    ->take(1)
                    ->update(['google_id' => $param['google_id']]);
        
            if($updateSt)
            {
                $return[$this->status]      = true;
                $return[$this->message]     = 'Successfully google id updated...';
                $return[$this->code]        = 200;
                $return[$this->data]        = [];
                
            }
            else
            {
                $return[$this->status]      = false;
                $return[$this->message]     = 'Oops, some problem occure while update, Please try again...';
                $return[$this->code]        = 201;
                $return[$this->data]        = [];
            }
        }
       
        return $return;        
        
    }



}
