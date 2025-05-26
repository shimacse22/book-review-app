<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Helper\ResponseHelper;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\support\facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
   
   
    /**
     * Register new user
     * @param 
     */

    
    public function register(RegisterRequest $request)
    {
        
       // dd($request->all());

       try{
        $user= User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone_number'=>$request->phone_number
        ]);

        if($user){
            return ResponseHelper::success(message:'User has been registered successfully',data:$user,statusCode:201);
        }
        return ResponseHelper::error(message:'Unable to register user,please try again',statusCode:400);

       }
       catch(Exception $e ) {
        Log::error('Unable to register user: '.$e->getMessage().'-Line no. '.$e->getLine());
        return ResponseHelper::error(message:'Unable to register user,please try again.'.$e->getMessage(),statusCode:400);
       }
    }

    /**
     * Login User.
     */
   
    public function login(LoginRequest $request)
    {
        // dd($request->all());
        try{
           if(!Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return ResponseHelper::error(message:'Unable to login due to invalid credentials',statusCode:400);
           }

           $user=Auth::user();
           $token=$user->createToken('My API Token')->plainTextToken;
           $authUser=[
            'user'=>$user,
            'token'=>$token
           ];

           return ResponseHelper::success(message:'You are logged in successfully',data: $authUser,statusCode:200);

        }
        catch(Exception $e){
            Log::error('Unable to login: '.$e->getMessage().'-Line no. '.$e->getLine());
            return ResponseHelper::error(message:'Unable to login,please try again.'.$e->getMessage(),statusCode:400);
        }
    }

     /**
      * Function: Auth user data/profile data
      */

    //   public function userProfile(){
    //     //dd(Auth::user());
    //     try{
    //         $user=Auth::user();

    //         if($user){
    //             return ResponseHelper::success(message:'User profile fetch successfully',data: $user,statusCode:200);
    //         }

    //         return ResponseHelper::error(message:'Unable to fetch user data due to invalid token.',statusCode:400);

    //     }
    //     catch(Exception $e){
    //         Log::error('Unable to fetch user data: '.$e->getMessage().'-Line no. '.$e->getLine());
    //         return ResponseHelper::error(message:'Unable to fetch user data,please try again.'.$e->getMessage(),statusCode:400);
    //     }
    //   }
    // /**
    //  * Function:User profile logout.
    //  */
    // public function destroy()
    // {
    //     try{
    //         $user=Auth::user();

    //         if($user){
    //             $user->currentAccessToken()->delete();
    //             return ResponseHelper::success(message:'User logout successfully',statusCode:200);
    //         }

    //         return ResponseHelper::error(message:'Unable to logout due to invalid token.',statusCode:400);

    //     }
    //     catch(Exception $e){
    //         Log::error('Unable to logout due to some exception: '.$e->getMessage().'-Line no. '.$e->getLine());
    //         return ResponseHelper::error(message:'Unable to logout due to some exception .'.$e->getMessage(),statusCode:400);
    //     }
    // }
}
