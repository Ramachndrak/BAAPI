<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use URL;

class ProfileDetails extends Controller
{
    protected $rules = [
        'email' => "required"
    ];

    protected $messages = [

        'email.required' => 'PLease enter Email'

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
        $validator = Validator::make($request->all(), $this->rules,$this->messages);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()),200);
        } else { 
            $email = $request->email;
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
        $validator = Validator::make($request->all(), $this->pwdrules,$this->pwdmessages);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()),200);
        } else { 
            $email = $request->email;
            $password = $request->password;
            $cpassword = bcrypt($request->password_confirmation);
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

    public function PrivacyPolicy()
    {
        $filename = '/pdf/privacy_policy.pdf';
        $path = storage_path($filename);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }

    public function Terms()
    {
        $filename = '/pdf/termscondition.pdf';
        $path = storage_path($filename);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }
}
 