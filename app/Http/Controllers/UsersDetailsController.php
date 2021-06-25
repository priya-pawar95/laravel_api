<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Personal_details;
use App\Models\tech_details;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','sendOtp','personal_details']]);

    }//end __construct()

    public function fn_personal_details(Request $request)
    {
        try{
        $validator = Validator::make(
            $request->all(),
            [
                'address'     => 'required|string|between:2,100',
                'district'    => 'required|string|between:2,50',
                'pin_code'    => 'required|integer|min:6',
                'place'       => 'required|string|between:2,50',
                'state'       => 'required|string|between:2,50',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [$validator->errors()],
                422
            );
        }

        $personal_details = Personal_details::create(
            array_merge(
                $validator->validated(),
                
            )
        );

    } 

    catch(Exception $exception)
        {
        return response()->json(['message' => 'Add Personal Details successfully', 'personal_details' => $personal_details]);
        }
    }//end personal_details()

    

    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'User logged out successfully']);

    }//end logout()


    public function profile()
    {
        return response()->json($this->guard()->user());

    }//end profile()


    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());

    }//end refresh()


    protected function respondWithToken($token)
    {
        return response()->json(
            [
                'token'          => $token,
                'token_type'     => 'bearer',
                'token_validity' => ($this->guard()->factory()->getTTL() * 60),
            ]
        );

    }//end respondWithToken()


   

    protected function guard()
    {
        return Auth::guard();

    }//end guard()



}
