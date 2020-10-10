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
use App\ProfileScreen;
use App\EducationDetails;
use App\FamilyDetails;
use App\FaceFair;

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
        'maternal_gotram'  => 'required',
        'mother_tongue_id' => 'required',
        'city_of_birth'    => 'required',
        'rashi'            => 'required'
    ];

    protected $religion_messages = [
        'religion_id.required'       => 'Name is Required',
        'community_id.required'      => 'Email is Required',
        'sub_community_id.required'  => 'Mobile Number is Required',
        'gotram.required'            => 'Gotram is Required',
        'maternal_gotram.required'   => 'Meternal gotram is Required',
        'mother_tongue_id.required'  => 'Profile is Required',
        'city_of_birth.required'     => 'Gender is Required',
        'rashi.required'             => 'Gender is Required'
    ];

    protected $profile_rules = [
        'profiles_created_by_id'      => 'required',
        'date_of_birth'               => 'required',
        'martial_status'              => 'required',
        'height'                      => 'required',
        'weight'                      => 'required',
        'blood_group_id'              => 'required'
    ];

    protected $profile_messages = [
        'profiles_created_by_id.required'       => 'Profile Created By Required',
        'date_of_birth.required'                => 'Date of birth Required',
        'martial_status.required'               => 'Martial Status Required',
        'height.required'                       => 'Height is Required',
        'weight.required'                       => 'Weight is Required',
        'blood_group_id.required'               => 'Blood Group is Required'
    ];

    protected $education_rules = [
        'highest_qualification' => 'required',
        'college_attend'        => 'required',
        'working_as'            => 'required',
        'company'               => 'required',
        'annual_income'         => 'required'
    ];

    protected $education_messages = [

        'highest_qualification.required'   => 'Please Enter Education qualification',
        'college_attend.required'          => 'Please Enter Your College',
        'working_as.required'              => 'Please Enter Working As',
        'company.required'                 => 'Please Enter Your Company',
        'annual_income.required'           => 'Please Enter Your Income'
    ];

    protected $family_rules=[

        'father_name' => 'required',
        'father_profession' => 'required',
        'mother_name'   => 'required',
        'mother_profession' => 'required',
        'address'           => 'required'
    ];

    protected $family_messages = [
        'father_name.required'  => 'Please Enter Father Name',
        'father_profession.required' => 'Please Enter Fathter Profession',
        'mother_name.required'      => 'Please Enter Mother Name',
        'mother_profession.required' => 'Please Enter Mother Profession',
        'address.required'           => 'Please Enter Address'

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
        	$user_details = User::select('id','name','email','mobile_num','profile_for','flag')->where('status',1)->where('id',$user_id)->first();

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

    public function FaceFair()
    {
        $FaceFair = FaceFair::select('id','face_fair')->get();
        return $FaceFair;
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

    public function ProfileScreen(Request $request)
    {
         $validator = Validator::make(Input::all(), $this->profile_rules,$this->profile_messages);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()),449);
        } else {

            $user_id = $request->user_id;
            $ProfileScreen_check = ProfileScreen::where('user_id',$user_id)->first();
            if(count($ProfileScreen_check)>0)
            {
                $ProfileScreen_check->profiles_created_by_id  = $request->profiles_created_by_id;
                $ProfileScreen_check->date_of_birth           = $request->date_of_birth;
                $ProfileScreen_check->martial_status          = $request->martial_status;
                $height                                 = $request->height;
                $height_split = explode(' - ', $height);
                $ProfileScreen_check->height = $height_split[0];
                $ProfileScreen_check->inches = $height_split[1];
                $ProfileScreen_check->weight = $request->weight;
                $ProfileScreen_check->blood_group_id = $request->blood_group_id;
                $ProfileScreen_check->fair    = $request->fair;
                $ProfileScreen_check->save();

                $profile_info = User::select('id','flag')
                                 ->where('id',$request->user_id)
                                 ->first();

                return response()->json(['success'=>'true','message'=>'Profile Updated successfully','profile_info' => $profile_info], 200);
            }
            else
            {
                $profileScreen = new ProfileScreen();
                $profileScreen->user_id          = $request->user_id;
                $profileScreen->profiles_created_by_id  = $request->profiles_created_by_id;
                $profileScreen->date_of_birth           = $request->date_of_birth;
                $profileScreen->martial_status          = $request->martial_status;
                $height                                 = $request->height;
                $height_split = explode(' - ', $height);
                $profileScreen->height = $height_split[0];
                $profileScreen->inches = $height_split[1];
                $profileScreen->weight = $request->weight;
                $profileScreen->blood_group_id = $request->blood_group_id;
                $profileScreen->fair    = $request->fair;
                $profileScreen->save();
                $update_flag = User::where('id',$request->user_id)
                               ->update(['flag' => 2]);

                $profile_info = User::select('id','flag')
                                 ->where('id',$request->user_id)
                                 ->first();

                return response()->json(['success'=>'true','message'=>'Profile Screen Saved successfully','profile_info' => $profile_info], 200);
            }            
        }
    }

    public function ReligionBackground(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->religion_rules,$this->religion_messages);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()),449);
        } else {
                    
            $user_id =  $request->user_id;

            $ReligionBackground_check = ReligionBackground::where('user_id',$user_id)->first();
            if(count($ReligionBackground_check)>0)
            {
                $ReligionBackground_check->religion_id      = $request->religion_id;
                $ReligionBackground_check->community_id     = $request->community_id;
                $ReligionBackground_check->sub_community_id = $request->sub_community_id;
                $ReligionBackground_check->gotram           = $request->gotram;
                $ReligionBackground_check->maternal_gotram  = $request->maternal_gotram;            
                $ReligionBackground_check->mother_tongue_id = $request->mother_tongue_id;
                $ReligionBackground_check->city_of_birth    = $request->city_of_birth;
                $ReligionBackground_check->rashi            = $request->rashi;
                $ReligionBackground_check->save();
                $religion_info = User::select('id','flag')
                                 ->where('id',$request->user_id)
                                 ->first();
                return response()->json(['success'=>'true','message'=>'Religion Details Updated successfully','religion_info' => $religion_info], 200);
            }
            else
            {
                $ReligionBackground = new ReligionBackground();
                $ReligionBackground->user_id          = $request->user_id;
                $ReligionBackground->religion_id      = $request->religion_id;
                $ReligionBackground->community_id     = $request->community_id;
                $ReligionBackground->sub_community_id = $request->sub_community_id;
                $ReligionBackground->gotram           = $request->gotram;
                $ReligionBackground->maternal_gotram  = $request->maternal_gotram;            
                $ReligionBackground->mother_tongue_id = $request->mother_tongue_id;
                $ReligionBackground->city_of_birth    = $request->city_of_birth;
                $ReligionBackground->rashi            = $request->rashi;
                $ReligionBackground->save();
                $update_flag = User::where('id',$request->user_id)
                               ->update(['flag' => 3]);
                $religion_info = User::select('id','flag')
                                 ->where('id',$request->user_id)
                                 ->first();
                return response()->json(['success'=>'true','message'=>'Religion Background Saved successfully','religion_info' => $religion_info], 200);
            }
        }
    }

    public function EducationDetails(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->education_rules,$this->education_messages);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()),449);
        } else {

            $user_id = $request->user_id;
            $EducationDetails_check = EducationDetails::where('user_id',$user_id)->first();

            if(count($EducationDetails_check)>0)
            {
                $EducationDetails_check->highest_qualification = $request->highest_qualification;
                $EducationDetails_check->college_attend = $request->college_attend;
                $EducationDetails_check->working_as = $request->working_as;
                $EducationDetails_check->company = $request->company;
                $EducationDetails_check->annual_income = $request->annual_income;
                $EducationDetails_check->save();
                $education_info = User::select('id','flag')
                                 ->where('id',$request->user_id)
                                 ->first();

                return response()->json(['success'=>'true','message'=>'Education Details Updated successfully','education_info' => $education_info], 200);
            }
            else
            {
                $EducationDetails = new EducationDetails();
                $EducationDetails->user_id = $request->user_id;
                $EducationDetails->highest_qualification = $request->highest_qualification;
                $EducationDetails->college_attend = $request->college_attend;
                $EducationDetails->working_as = $request->working_as;
                $EducationDetails->company = $request->company;
                $EducationDetails->annual_income = $request->annual_income;
                $EducationDetails->save();

                $update_flag = User::where('id',$request->user_id)
                               ->update(['flag' => 4]);

                $education_info = User::select('id','flag')
                                 ->where('id',$request->user_id)
                                 ->first();

                return response()->json(['success'=>'true','message'=>'Education Details saved successfully','education_info' => $education_info], 200);
            }
        }
    }

    public function FamilyDetails(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->family_rules,$this->family_messages);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()),449);
        } else {
            $user_id = $request->user_id;
            $FamilyDetails_check = FamilyDetails::where('user_id',$user_id)->first();
            if(count($FamilyDetails_check)>0)
            {
                $FamilyDetails_check->father_name = $request->father_name;
                $FamilyDetails_check->father_profession = $request->father_profession;
                $FamilyDetails_check->mother_name = $request->mother_name;
                $FamilyDetails_check->mother_profession = $request->mother_profession;
                $FamilyDetails_check->no_of_brothers = $request->no_of_brothers;
                $FamilyDetails_check->brother_married = $request->brother_married;
                $FamilyDetails_check->brother_not_married = $request->brother_not_married;
                $FamilyDetails_check->no_of_sisters = $request->no_of_sisters;
                $FamilyDetails_check->sister_married = $request->sister_married;
                $FamilyDetails_check->sister_not_married = $request->sister_not_married;
                $FamilyDetails_check->address = $request->address;
                $FamilyDetails_check->save();
                 $family_info = User::select('id','flag')
                                 ->where('id',$request->user_id)
                                 ->first();

                return response()->json(['success'=>'true','message'=>'Family Details Updated successfully','family_info' => $family_info], 200);
            }
            else
            {
                $FamilyDetails = new FamilyDetails();
                $FamilyDetails->user_id = $request->user_id;
                $FamilyDetails->father_name = $request->father_name;
                $FamilyDetails->father_profession = $request->father_profession;
                $FamilyDetails->mother_name = $request->mother_name;
                $FamilyDetails->mother_profession = $request->mother_profession;
                $FamilyDetails->no_of_brothers = $request->no_of_brothers;
                $FamilyDetails->brother_married = $request->brother_married;
                $FamilyDetails->brother_not_married = $request->brother_not_married;
                $FamilyDetails->no_of_sisters = $request->no_of_sisters;
                $FamilyDetails->sister_married = $request->sister_married;
                $FamilyDetails->sister_not_married = $request->sister_not_married;
                $FamilyDetails->address = $request->address;
                $FamilyDetails->save();
                $update_flag = User::where('id',$request->user_id)
                               ->update(['flag' => 5]);

                $family_info = User::select('id','flag')
                                 ->where('id',$request->user_id)
                                 ->first();

                return response()->json(['success'=>'true','message'=>'Family Details saved successfully','family_info' => $family_info], 200);
            }            
        }
    }

    public function GetStatus(Request $request)
    {
        $user_id = $request->user_id;
        if(!empty($user_id))
        {
            $GetStatus = User::select('flag')
                         ->where('id',$user_id)
                         ->first();

            return response()->json(['success'=>'true','message'=>'Flag','status_flag' => $GetStatus], 200);              
        }
        else
        {
            return response()->json(['error'=>"false",'message'=>'Please Provide User Id'],400);
        }
    }


    public function ProfilePic(Request $request)
    {

    }
}
