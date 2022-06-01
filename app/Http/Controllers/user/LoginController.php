<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\user\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Response;
use Validator;
use Auth;

class LoginController extends Controller
{

    public function login(Request $request)
    {

        $rules = [
            'username' => 'required|exists:users,username',
            //'email'    => 'required',
            'password' => 'required',
        ];

        $input = $request->only('username', 'password');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $auth_user=User::where('username','=',$request->username)->first();
        $hash_check= Hash::check($request->password,$auth_user->password);

       if($hash_check){
        $rand = Str::random(64);
        $token= hash('sha256', $rand);

        $user=User::find($auth_user->id);

        $user_data=[
            'id'=>$auth_user->id,
            'username'=>$auth_user->username,
            'phone_number'=>$auth_user->phone_number,
            'dial_code'=>$auth_user->dial_code,
            'is_verified'=>$auth_user->longitude,
            "email"=>$auth_user->email,
            "first_name"=> $auth_user->first_name,
            "last_name"=>$auth_user->last_name
            ]  ;

        $data = User::where("id",$user->id)->first();
        $token = $data->createToken('API Token')->accessToken;
        $data->token = $token;

        return Response::json([
                                'message' => "Loggedin Successfully.",
                                'data' => $data,
                                "success" => true
                            ],200);
    }else{
        return Response::json([
                                'message' => "Incorrect Credentials.",
                                'data' => NULL,
                                "success" => false
                            ],200);
        }
    }


    public static function auth(Request $request){

        if(isset($request->token) && $request->session()->has($request->token)){
            return true;
        }else{
            $user=User::where('token','=',$request->token)->first();
            if (isset($user->token) && $user->token == $request->token){
                return true;
            }else{
                return false;
            }
        }

    }


    public function register(Request $request){

        $rules = [
            'username' => 'required|unique:users,username',
            'email' => 'required|email:rfc,dns,filter|unique:users,email,NULL,id',
            'phone_number' => 'required',
            'password' => 'required',
        ];

        $input = $request->only('username', 'email', 'phone_number','password');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $rand = Str::random(64);
        $token= hash('sha256', $rand);

       /* $check = User::where('phone_number', $request->phone_number)->where('is_verified',1)->first();
        if($check){
            $rules = [
                'phone_number' => 'unique:users|required'
            ];

            $input = $request->only('phone_number');
            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->messages()]);
            }            
        }*/

        $user_data = User::create([

            //'first_name' => $request->first_name,
            //'last_name' => $request->last_name,
            //'dial_code' => $request->dial_code,
            'email' => $request->email ?? "",
            'phone_number' => $request->phone_number ?? "",
            //'dob' => $request->dob ?? "",
            'password' => Hash::make($request->password),
            'status' => 1,
            'is_verified' => 0,
            "username" => $request->username
        ]);
        $token = $user_data->createToken('API Token')->accessToken;
        $user_data["token"] = $token;
        return Response::json([
                                'message' => "User Registered Successfully.",
                                'data' => $user_data,
                                "success" => true,
                            ],200);
    }

    public function verifyOtp(Request $request){
        $rules = [
            'otp' => 'required',
        ];

        $input = $request->only('otp');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }        
        //echo "hello";die;
        $user = Auth::user();
       
        if($user->otp == $request->otp){
            $user->is_verified = 1;
            $user->save();
            return Response::json([
                                    'success' => true,
                                    'message' => "User Verified."
                                ],200);
        }else{
            return Response::json([
                                    'success' => false,
                                    'message' => "Wrong Otp."
                                ],400);
        }
    }

    public function logout(Request $request){
        $token = User::where('id', Auth::user()->id)->update(['device_token' => ""]);
        $user = Auth::user()->token();
        $user->revoke();
        return Response::json([
                                'success' => true,
                                'message' => "User Loggedout Successfully."
                            ],200);
    }


    public function update_token(Request $request){
        $rules = [
            'device_type' => 'required',
            'device_token' => 'required'
        ];
        $input = $request->only('device_type','device_token');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $user = Auth::user();
        $user->device_type =$request->device_type ;
        $user->device_token =$request->device_token ;

        if($user->save()){
            return Response::json([
                                    'success' => true,
                                    'message' => "User token updated.",
                                    'data' => $user
                                ],200);
        }else{
             return Response::json([
                                    'success' => false,
                                    'message' => "Something went wrong."
                                ],400);
        }
    }


    public function update_location(Request $request){
        $rules = [
            'address' => 'required',
            'lat' => 'required',
            'lng' => 'required'
        ];
        $input = $request->only('address','lat','lng');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        $user = Auth::user();
        $user->address =$request->address ;
        $user->lat =$request->lat ;
        $user->lng =$request->lng ;

        if($user->save()){
            return Response::json([
                                'success' => true,
                                'message' => "User location updated.",
                                'data' => $user
                            ],200);
        }else{
             return Response::json([
                                    'success' => false,
                                    'message' => "Something went wrong."
                                ],400);
        }



    }

    public function getProfile(){
        $user = Auth::user();
        if($user){
            return Response::json([
                                'success' => true,
                                'message' => "User updated Successfully.",
                                'data' => $user
                            ],200);
        }else{
             return Response::json([
                                    'success' => false,
                                    'message' => "No User Found."
                                ],400);
        }
    }

    public function updateNotificationStatus(Request $request){
        $rules = [
            'status' => 'required|in:1,0'
        ];
        $input = $request->only('status');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $user = Auth::user();
        $user->notification_status = $request->status;
        $user->save();
        return Response::json([
                                'success' => true,
                                'message' => "Notification status updated."
                            ],200);
    }

    public function changePassword(Request $request){
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required',
        ];

        $input = $request->only('current_password', 'new_password');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }        

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => "Your current password does not matches with the password."]);
            }
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => "New Password cannot be same as your current password."]);
            }
        }

        $user = Auth::user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();
        return Response::json([
                                'success' => true,
                                'message' => "Password Changed Successfully."
                            ],200);
    }

    public function update_profile(Request $request){
        $user=User::where('id',$request->user()->id)->first();
        if($user){
            if($request->has("first_name") && !empty($request->first_name)){
                $user->first_name =$request->first_name ;
            }
            if($request->has("last_name") && !empty($request->last_name)){
                $user->last_name =$request->last_name ;    
            }
            if($request->has("email") && !empty($request->email)){
                $user->email =$request->email ;    
            }
            if($request->has("dob") && !empty($request->dob)){
                $user->dob =$request->dob ;
            }
            if($request->has("gender") && !empty($request->gender)){
                $user->gender =$request->gender ;
            }
            
            $user->save();
            return Response::json([
                                'success' => true,
                                'message' => "User updated Successfully.",
                                'data' => $user
                            ],200);
        }else{
             return Response::json([
                                    'success' => false,
                                    'message' => "No User Found."
                                ],400);
        }

    }

}
