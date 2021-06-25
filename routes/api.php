<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TechFileController;
use App\Http\Controllers\TechnicalController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('sendotp', 'App\Http\Controllers\AuthenticateController@fn_sendotp');
Route::post('verifyotp', 'App\Http\Controllers\AuthenticateController@fn_verifyotp');
Route::post('forgetpwd', 'App\Http\Controllers\AuthenticateController@fn_forgetpwd');



//Route::post('upload',[TechFileController::class,'upload']);
//Route::post('technical/add',[TechnicalController::class,'store']);


Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('register','AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::get('profile','AuthController@profile');
    Route::post('refresh', 'AuthController@refresh');
    
    Route::post('personal_details', 'UsersDetailsController@fn_personal_details');
    Route::post('technical/add', 'TechnicalController@store');
    //Route::post('sendPasswordResetLink', 'PasswordResetRequestController@sendEmail');
    //Route::post('resetPassword', 'ChangePasswordController@passwordResetProcess');


});



//Route::post('sendEmail', 'App\Http\Controllers\MailController@sendEmail');


Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
  

], function ($router) {

    Route::resource('todos','TodoController');

   

});