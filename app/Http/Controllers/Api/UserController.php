<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Validator,Input,Response,Auth,Image,URL;
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
use App\ProfilePic;

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

            $random = rand (00000,99999);
            $check_random = User::select('random_id')->where('random_id',$random)->first();
            if(count($check_random)>0)
            {
                $random = rand (00000,99999);
                $random_string = 'BAB'.$random;
            }
            else
            {
                $random_string = 'BAB'.$random;
            }
	        $user = User::create([
                'random_id'     => $random_string,
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
        	$user_details = User::select('id','random_id','name','email','mobile_num','profile_for','flag')->where('status',1)->where('id',$user_id)->first();

        	return Response::json(['success'=>'true','message'=>'User logged in successfully','token' => $token,'user_id'=>$user_details,'flag'=>$flag], 200);
        }
        else {

            return Response::json(['error'=>'false','message'=>'Invalid Credentials'], 200);
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
                $profileScreen->page_title          = $request->page_title;
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
                $ReligionBackground->page_title          = $request->page_title;
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
                $EducationDetails->page_title = $request->page_title;
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
                $FamilyDetails->page_title = $request->page_title;
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
        $croppie_images = $request->image;
        $user_id  = $request->user_id;
        foreach ($croppie_images as $key => $croppie_code) 
        {
            if($key == 0)
            {
                if (preg_match('/^data:image\/(\w+);base64,/', $croppie_code, $type)) 
                {
                    $encoded_base64_image = substr($croppie_code, strpos($croppie_code, ',') + 1);
                    $type = strtolower($type[$key]);
                    $decoded_image = base64_decode($encoded_base64_image);
                    $resized_image = Image::make($decoded_image)->resize(128, 128);
                    $resized_image->save('public/profiles/thumbnails/'.$key.'_'.$user_id.'.jpg');
                }
            }
            
            if (preg_match('/^data:image\/(\w+);base64,/', $croppie_code, $type)) 
            {
                $encoded_base64_image = substr($croppie_code, strpos($croppie_code, ',') + 1);
                $type = strtolower($type[$key]);
                $decoded_image = base64_decode($encoded_base64_image);
                $resized_image = Image::make($decoded_image)->resize(400, 400);
                $image_name = $key.'_'.$user_id.'.jpg';
                $resized_image->save('public/profiles/main_profiles/'.$image_name);
            }

            DB::table('profile_pics')->insert(
                ['user_id' => $user_id, 'profile_pic' => $image_name]
            );
        }   

        $profile_path = DB::table('profile_pics')->select('user_id','profile_pic')->where('user_id',$user_id)->get();

        $thumbnails_path = URL::to('/public/thumbnails/0_'.$user_id.'jpg');
        $main_path = [];
        foreach ($profile_path as $key => $value) {
            $path = URL::to('/public/main_profiles/'.$key.'_'.$user_id.'jpg');
            array_push($main_path, $path);
        }

        return response()->json(['success'=>'true','message'=>'Profile Pics','thumbnail' =>$thumbnails_path,'main_pics'=>$main_path], 200);
    }

    public function ProfileInfo(Request $request)
    {
        $user_id = $request->user_id;


        $user = DB::table('users')->select('random_id','name','email','gender','mobile_num')->where('id',$user_id)->first();


        $profiles_screen = DB::table('profiles_screen as ps')
                    ->leftjoin('profiles_created_by as pcb','pcb.id','=','ps.profiles_created_by_id')
                    ->leftjoin('blood_group as bg','bg.id','=','ps.blood_group_id')
                    ->leftjoin('face_fair as f','f.id','=','ps.fair')
                    ->select('pcb.profiles_created_by','ps.date_of_birth','ps.martial_status','ps.height','ps.inches','ps.weight','bg.blood_group','f.face_fair')
                    ->where('ps.user_id',$user_id)
                    ->first();

        $religion = DB::table('religions_background as rb')
                    ->leftjoin('religions as r','rb.religion_id','=','r.id')
                    ->leftjoin('community as c','rb.community_id','=','r.id')
                    ->leftjoin('sub_community as sc','sc.id','=','c.community_id')
                    ->leftjoin('mother_tongue as mt','mt.id','=','rb.mother_tongue_id')
                    ->select('rb.*','r.religion','c.community','sc.sub_community','mt.mother_tongue')
                    ->where('rb.user_id',$user_id)
                    ->first();


        $education = DB::table('educations_details')->select('highest_qualification','college_attend','working_as','company','annual_income')->where('user_id',$user_id)->first();
        

        $Family =  DB::table('family_details')->where('user_id',$user_id)->first();

        $profile_pic = DB::table('profile_pics')->where('user_id',$user_id)->first();

        return response()->json(['success'=>'true','message'=>'Detailed Info','Basic Details' => $user,'Profile Screen Details' => $profiles_screen,'Education Details' => $education,'Family Details' => $Family,'profile_pic'=>$profile_pic,'religion'=>$religion],200);
    }

    public function PreviousData(Request $request)
    {
        $user_id = $request->user_id;
        $page_type    = $request->page_type;
        if($page_type == 'profile_screen')
        {
            $BasicDetails = DB::table('profiles_screen as ps')
                            ->leftjoin('profiles_created_by as pcb','pcb.id','=','ps.profiles_created_by_id')
                            ->leftjoin('blood_group as bg','bg.id','=','ps.blood_group_id')
                            ->leftjoin('face_fair as ff','ff.id','=','ps.fair')
                            ->select('pcb.profiles_created_by','bg.blood_group','ps.date_of_birth','ps.martial_status','ps.height','ps.weight','ps.inches','ff.face_fair')
                            ->where('user_id',$user_id)
                            ->first();

            return response()->json(['success' => 'true','message' => 'Profile Screen Info','profile_screen' => $BasicDetails],200);
        }
        else if($page_type == 'religion')
        {
            $religion = DB::table('religions_background as rb')
                        ->leftjoin('religions as r','r.id','=','rb.religion_id')
                        ->leftjoin('community as c','c.id','=','rb.community_id')
                        ->leftjoin('sub_community as sc','sc.id','=','rb.sub_community_id')
                        ->leftjoin('mother_tongue as mt','mt.id','=','rb.mother_tongue_id')
                        ->select('r.religion','mt.mother_tongue','c.community','sc.sub_community','rb.gotram','rb.maternal_gotram','rb.city_of_birth','rb.rashi')
                        ->first();

            return response()->json(['success' => 'true','message' => 'Religion Screen Info','religion' => $religion],200);


        }
        else if($page_type == 'education')
        {
            $education = EducationDetails::select('highest_qualification','college_attend','working_as','company','annual_income')
                ->where('user_id',$user_id)
                ->first();
            return response()->json(['success' => 'true','message' => 'education Screen Info','education' => $education],200);    

        }
        else if($page_type == 'family')
        {
            $family_details = FamilyDetails::where('user_id',$user_id)->first();
            return response()->json(['success' => 'true','message' => 'Family  Screen Info','family_details' => $family_details],200);
        }
    }
}
