<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecommentedAndRecentController extends Controller
{
    public function RecommentedProfiles(Request $request)
    {
    	$user_id = $request->user_id;

    	$get_gender = DB::table('users')
    				  ->select('gender')
    				  ->where('id',$user_id)
    				  ->first();
    	$gender = (int)$get_gender->gender;

    	if($gender == 1)
    	{
    		$get_user_info = DB::table('users as u')
    						 ->leftjoin('profiles_screen as ps','ps.user_id','=','u.id')
    						 ->leftjoin('religions_background as rb','rb.user_id','=','u.id')
    						 ->leftjoin('community as c','c.id','=','rb.community_id')
    						 ->select('ps.height','rb.community_id','rb.religion_id')
    						 ->first();

    		$another_profiles = DB::table('users')
    					       ->whereNotIn('gender',[$gender])
    					       ->get();
			
			$recommended_profiles = [];
    		foreach ($another_profiles as $key => $value) {
    			$recommended = DB::table('users as u')
    			               ->leftjoin('profiles_screen as ps','ps.user_id','=','u.id')
    			               ->leftjoin('religions_background as rb','rb.user_id','=','u.id')
    						 ->leftjoin('community as c','c.id','=','rb.community_id')
    						 ->leftjoin('religions as r','r.id','=','rb.religion_id')
    						 ->select('u.*','ps.date_of_birth','rb.gotram','rb.maternal_gotram','rb.city_of_birth','rb.rashi','c.community','r.religion')
    						 ->whereBetween('ps.height',$get_user_info->height)
    						 ->whereBetween('rb.community_id',$get_user_info->community_id)
    						 ->whereBetween('rb.religion_id',$get_user_info->religion_id)
    						 ->first();

                $user_id = $value->id;             

                $profile_path = DB::table('profile_pics')->select('user_id','profile_pic')->where('user_id',$user_id)->get();

                $thumbnails_path = URL::to('/public/thumbnails/0_'.$user_id.'jpg');
                $main_path = [];
                foreach ($profile_path as $key => $value) {
                    $path = URL::to('/public/main_profiles/'.$key.'_'.$user_id.'jpg');
                    array_push($main_path, $path);
                }             

    			array_push($recommended_profiles, $recommended);


                return response()->json(['success'=>'true','message'=>'Recommented Profiles','recommended_profiles' =>$recommended_profiles,'main_pics'=>$main_path], 200);


    		}

    	}
        else
        {

            $get_user_info = DB::table('users as u')
                             ->leftjoin('profiles_screen as ps','ps.user_id','=','u.id')
                             ->leftjoin('religions_background as rb','rb.user_id','=','u.id')
                             ->leftjoin('community as c','c.id','=','rb.community_id')
                             ->select('ps.height','rb.community_id','rb.religion_id')
                             ->first();

            $another_profiles = DB::table('users')
                               ->whereNotIn('gender',[$gender])
                               ->get();
            
            $recommended_profiles = [];
            foreach ($another_profiles as $key => $value) {
                $recommended = DB::table('users as u')
                               ->leftjoin('profiles_screen as ps','ps.user_id','=','u.id')
                               ->leftjoin('religions_background as rb','rb.user_id','=','u.id')
                             ->leftjoin('community as c','c.id','=','rb.community_id')
                             ->leftjoin('religions as r','r.id','=','rb.religion_id')
                             ->select('u.*','ps.date_of_birth','rb.gotram','rb.maternal_gotram','rb.city_of_birth','rb.rashi','c.community','r.religion')
                             ->whereBetween('ps.height',$get_user_info->height)
                             ->whereBetween('rb.community_id',$get_user_info->community_id)
                             ->whereBetween('rb.religion_id',$get_user_info->religion_id)
                             ->first();

                $user_id = $value->id;             

                $profile_path = DB::table('profile_pics')->select('user_id','profile_pic')->where('user_id',$user_id)->get();

                $thumbnails_path = URL::to('/public/thumbnails/0_'.$user_id.'jpg');
                $main_path = [];
                foreach ($profile_path as $key => $value) {
                    $path = URL::to('/public/main_profiles/'.$key.'_'.$user_id.'jpg');
                    array_push($main_path, $path);
                }             

                array_push($recommended_profiles, $recommended);

                return response()->json(['success'=>'true','message'=>'Recommented Profiles','recommended_profiles' =>$recommended_profiles,'main_pics'=>$main_path], 200);


            }
        }
    }
}
