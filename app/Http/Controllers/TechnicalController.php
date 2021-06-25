<?php

namespace App\Http\Controllers;
use Auth;
use Exception;
use App\Models\UserTechnicalDetails;
use Illuminate\Http\Request;

class TechnicalController extends Controller
{

    public function store(Request $req)
    {
        try{
        //dd($req);
        $userObj = Auth::user();
        // request()->merge(['user_id'=>$user_id]);
        $file = $req->file('file'); 
        
        //Move Uploaded File
        $destinationPath = storage_path('app/apiDocs/');
        $filename = $file->getClientOriginalName();
        $response = $file->move($destinationPath,$filename);
               
        request()->merge(['available_format'=>$filename]);
       // dd($req->all());
        $response = $userObj->fn_user_technical_details()->updateOrCreate(['user_id'=>$userObj->id],$req->all());
       //dd($response);
        
    } 
    catch(Exception $exception)
        {
       return response()->json(['message' => 'Add Users Technical Details successfully'], 200);
        }
    }


}
