<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Validator,Input,Response,Auth;
use App\ProfileFor;
use App\User;

class UserController extends Controller
{

	protected $rules = [
		'name'       => 'required',
		'email'      => 'required|unique:users,email',
		'mobile_num' => 'required|unique:users,mobile_num',
		'password'   => 'required',
		'profile_for'=> 'required',
		'gender'     => 'required'
	];

	protected $messages = [
		'name.required'  => 'Name is Required',
		'email.required' => 'Email is Required',
		'mobile_num.required'  => 'Mobile Number is Required',
		'password.required'  => 'Passowrd is Required',
		'profile_for.required'  => 'Profile is Required',
		'gender.required'  => 'Gender is Required'
	];
    public function ProfileFor()
    {
    	$profile = ProfileFor::select('id','profile_for')->get();
    	return $profile;
    }

    public function Register(Request $request)
    {

    	$validator = Validator::make(Input::all(), $this->rules,$this->messages);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()),449);
        } else { 

	        $user = User::create([
	            'name' 	        => $request->name,
	            'email' 	    => $request->email,
	            'mobile_num'    => $request->mobile_num,
	            'password' 	    => bcrypt($request->password),
	            'profile_for' 	=> $request->profile_for,
	            'gender' 	    => $request->gender,
	            'status'        => 1,
	            'flag'          => 1
	        ]);
	 
	        $token = $user->createToken('BAToken')->accessToken;
	        if($user)
	        {
	        	return response()->json(['success'=>'true','message'=>'Registered successfully','token' => $token], 200);
	        }
	        else
	        {
	        	return response()->json(['error'=>'false','message'=>'Something went Wrong'], 400);
	        }	        
       }
    }

    public function Login(Request $request)
    {
    	$credentials = [
            'email' 	=> strtolower($request->email),
            'password' 	=> $request->password
        ];
        if (auth()->attempt($credentials)) {
        	$user_id     =  auth()->user()->id;
        	$flag        =  auth()->user()->flag;
        	$token       =  auth()->user()->createToken('BAToken')->accessToken;

        	return Response::json(['success'=>'true','message'=>'User logged in successfully','token' => $token,'user_id'=>$user_id,'flag'=>$flag], 200);
        }
        else {

            return Response::json(['error'=>'false','message'=>'Invalid Credentials'], 401);
        }
    }





}
