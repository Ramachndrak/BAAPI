<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Validator,Input,Response,Auth;
use App\ProfileFor;
use App\User;
use App\ProfileCreatedBy;
use App\BloodGroup;
use App\Religion;
use App\Community;
use App\SubCommunity;
use App\MotherTongue;
use App\HighQualification;
use App\ReligionBackground;

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


    protected $religion_rules = [
        'religion_id'      => 'required',
        'community_id'     => 'required',
        'sub_community_id' => 'required',
        'gotram'           => 'required',
        'mother_tongue_id' => 'required',
        'city_of_birth'    => 'required',
        'rashi'            => 'required'
    ];

    protected $religion_messages = [
        'religion_id.required'       => 'Name is Required',
        'community_id.required'      => 'Email is Required',
        'sub_community_id.required'  => 'Mobile Number is Required',
        'gotram.required'            => 'Passowrd is Required',
        'mother_tongue_id.required'  => 'Profile is Required',
        'city_of_birth.required'     => 'Gender is Required',
        'rashi.required'             => 'Gender is Required'
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
        	$user_details = User::select('id','name','email','mobile_num','profile_for','flag')
        					->where('status',1)->where('id',$user_id)->first();

        	return Response::json(['success'=>'true','message'=>'User logged in successfully','token' => $token,'user_id'=>$user_details,'flag'=>$flag], 200);
        }
        else {

            return Response::json(['error'=>'false','message'=>'Invalid Credentials'], 401);
        }
    }


    public function ProfileCreated()
    {
    	$created_for = ProfileCreatedBy::select('id','profiles_created_by')->get();
    	return $created_for;
    }

    public function BloodGroup()
    {
    	$BloodGroup = BloodGroup::select('id','blood_group')->get();
    	return $BloodGroup;
    }

    public function Religion()
    {
    	$Religion = Religion::select('id','religion')->get();
    	return $Religion;
    }

    public function Community()
    {
        $Community = Community::select('id','community')->get();
        return $Community;
    }

    public function SubCommunity(Request $request)
    {
        $community_id = $request->community_id;
        $sub_community = SubCommunity::select('id','sub_community')
                         ->where('community_id',$community_id)
                         ->get();

        if(count($sub_community)>0)
        {
            return response()->json(['success'=>'true','message'=>'Sub Community','SubCommunity' => $sub_community], 200);
        }
        else
        {
            return Response::json(['error'=>'false','message'=>'No Data'], 400);
        }
    }

    public function MotherTongue()
    {
        $MotherTongue = MotherTongue::select('id','mother_tongue')->get();
        return $MotherTongue;
    }

    public function HighQualification()
    {
        $HighQualification = HighQualification::select('id','qualification')->get();
        return $HighQualification;
    }

    public function ReligionBackground(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->religion_rules,$this->religion_messages);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()),449);
        } else {
                    
            $ReligionBackground = new ReligionBackground();
            $ReligionBackground->user_id          = $request->user_id;            
            $ReligionBackground->religion_id      = $request->religion_id;
            $ReligionBackground->community_id     = $request->community_id;
            $ReligionBackground->sub_community_id = $request->sub_community_id;
            $ReligionBackground->gotram           = $request->gotram;
            $ReligionBackground->mother_tongue_id = $request->mother_tongue_id;
            $ReligionBackground->city_of_birth    = $request->city_of_birth;
            $ReligionBackground->rashi            = $request->rashi;
            $ReligionBackground->save();
            $update_flag = User::where('id',$user_id)
                           ->update(['flag' => 2]);

            $religion_info = ReligionBackground::select('religion_id','community_id','sub_community_id','gotram','mother_tongue_id','city_of_birth','rashi')
                ->where('user_id',$request->user_id)->first();       

            return response()->json(['success'=>'true','message'=>'Religion Background Saved successfully','religion_info' => $religion_info], 200);              
        }
    }


}
