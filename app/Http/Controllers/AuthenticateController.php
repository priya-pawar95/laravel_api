<?php


namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Exception;

class AuthenticateController extends Controller
{
    

    public function fn_sendotp()
    {
        try{
        $requestdata=request()->all();
        // dd($requestdata);
        $userObj = User::where('email',$requestdata['email'])->first();
        $otp = mt_rand(1000, 9999);
        $userObj->otp = $otp;
        $response = $userObj->save();
        // dd($userObj,$response);

        
                 
         
        
            return response()->json(['message' => 'OTP Send Successfully']);
            } 
        catch(Exception $exception)
            {
                // dd($exception);
                return response()->json(['error' => $exception->getMessage()]);
            }
        
       
    }

    public function fn_verifyotp()
    {
        try {
        $input  = request()->all();
        ##Check Validation true or false
        $validator = Validator::make($input, [
            'otp' => 'required',
            'email' => 'email|required|regex:/^[A-z][A-z0-9_.-]+[@][A-z0-9_-]+([.][A-z0-9_-]+)+[A-z]{1,4}$/',
           ]);
        
        if ($validator->fails())
            return response()->json(['error' => $validator->errors()]);
        

        $email  =  (isset($input['email']) &&  !empty($input['email'])) ? $input['email'] : '' ;

        ## Get user details to check mobile and otp
        $arr_user   = User::where('email',$email)->first();
      
        ## Check otp and return response
        if($input['otp'] == $arr_user->otp)
        {
           
            return response()->json(['success' => 'OTP verification done']);
        }
        return response()->json(['error' => 'Invalid  OTP']);
        }
        catch(Exception $exception)
        {
            // dd($exception);
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
    public function fn_forgetpwd()
    {       
        try{ 
        $input  = request()->all();
        ##Check Validation true or false
        $validator = Validator::make($input, [
            'password' => 'required|min:6|max:20',
            'email' => 'email|required|regex:/^[A-z][A-z0-9_.-]+[@][A-z0-9_-]+([.][A-z0-9_-]+)+[A-z]{1,4}$/',
           ]);
        
        if ($validator->fails())
            return response()->json(['error' => $validator->errors()]);

        ## validation for password and email required
        $email  =  (isset($input['email']) &&  !empty($input['email'])) ? $input['email'] : '' ;
        $arr_user   = User::where('email',$email)->first();
        if(empty($arr_user)){
            ##return user not found response
            return response()->json(['error' =>'Invalid Email']);
        }

        $arr_user->password = bcrypt($input['password']);
        $response = $arr_user->save();
        ##return  success response
        if($response)
        {
            $arr_user->otp = null;
            $arr_user->save();
            return response()->json(['success' => 'Changed Password Successfully']);
            
        }
       
        return response()->json(['error' =>'Something went Wrong...']);
        }catch(Exception $exception)
        {
            // dd($exception);
            return response()->json(['error' => $exception->getMessage()]);
        }

    }

}


