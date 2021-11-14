<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\OtpForPwd;
use App\User;

class ProfileDetails extends Controller
{
    protected $rules = [
        'email' => "required"
    ];

    protected $messages = [

        'email.required' => 'PLease enter Email';

    ];


    protected $pwdrules = [
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required|min:6'
    ];

    protected $pwdmessages = [
        'password.required'  => 'Passowrd is Required',
        'password_confirmation.required' => 'Confirm Passowrd is Required'
    ];
    public function ForgotPwd(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->rules,$this->messages);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()),200);
        } else { 
            $email = $required->email;
            $check = User::where('email',$email)->exists();
            if(!empty($check))
            {
                return response()->json(['success'=>'true','message'=>'User Exists'], 200);
            }
            else
            {
                return response()->json(['error'=>'false','message'=>'User Not Exists'], 200);
            }
            
        }
    }

    public function UpdatePwd(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->pwdrules,$this->pwdmessages);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()),200);
        } else { 
            $email = $required->email;
            //$check = User::select('id')->where('email',$email)->first();
            $password = $request->password;
            $cpassword = $request->password_confirmation;
            $update_pwd = User::where('email',$email)
                          ->update(['password' => $cpassword]);
            if($update_pwd)
            {
                 return response()->json(['success'=>'true','message'=>'Password Updated successfully'], 200);
            }
            else
            {
                return response()->json(['error'=>'false','message'=>'Password Not Updated'], 200);
            }
        }
    }
}
 