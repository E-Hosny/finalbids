<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegistrationApiController;
use App\Http\Controllers\Api\ProductApiController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('downloadinvoice', [ProductApiController::class, 'downloadInvoice'])->name('download.invoice');

Route::group(['namespace' => 'API'], function () {
    // country list
    Route::get('termsconditions', [RegistrationApiController::class, 'termsconditions']);
    Route::get('privacypolicies', [RegistrationApiController::class, 'privacypolicies']);
    Route::get('countries', [RegistrationApiController::class, 'countries']);
    Route::get('currency', [RegistrationApiController::class, 'currency']);
    Route::post('currencyupdate', [RegistrationApiController::class, 'currencyupdate']);
    Route::get('language', [RegistrationApiController::class, 'language']);
    Route::post('langupdate', [RegistrationApiController::class, 'langupdate']);
    Route::post('statesliist', [RegistrationApiController::class, 'statesliist']);
    Route::post('citiesliist', [RegistrationApiController::class, 'citiesliist']);
    Route::post('registration', [RegistrationApiController::class, 'register']);
    Route::post('verifyOTP', [RegistrationApiController::class, 'verifyOTP']);
    // forgot verify otp
    Route::post('verifyOTPforgot', [RegistrationApiController::class, 'verifyOTPforgot']);
    // delete account
    Route::get('deleteaccount', [RegistrationApiController::class, 'deleteAccount']);

    Route::post('login', [RegistrationApiController::class, 'login']);
    Route::post('resendcode', [RegistrationApiController::class, 'resendcode']);
    Route::post('forgotpassword', [RegistrationApiController::class, 'forgotpassword']);
    Route::post('resendfromsignup', [RegistrationApiController::class, 'resendfromsignup']);

    Route::post('resetpassword', [RegistrationApiController::class,'resetpassword']);
    Route::post('changepassword', [RegistrationApiController::class, 'changepassword']);
    Route::post('logout', [RegistrationApiController::class, 'logout']);

    // add edit and delete user address
    Route::post('adduseraddress', [RegistrationApiController::class, 'adduseraddress']);
    Route::post('edituseraddress', [RegistrationApiController::class, 'editUserAddress']);
    Route::post('addressprimary', [RegistrationApiController::class, 'primaryAddress']);
    Route::post('removeuseraddrss', [RegistrationApiController::class, 'removeuseraddrss']);
    Route::get('myaddress', [RegistrationApiController::class, 'getUserAddresses']);

    Route::post('user/notify', [RegistrationApiController::class, 'toggleNotifyOn']);
    // profile update api.
    Route::post('profileupdate', [RegistrationApiController::class, 'profileupdate']);
    Route::get('profiledetail', [RegistrationApiController::class, 'profiledetail']);
    // homepage api.
    Route::post('homepage', [ProductApiController::class, 'homepage']);
    Route::post('categories', [ProductApiController::class, 'categories']);
    Route::post('productlistbasedproject', [ProductApiController::class, 'productlistbasedproject']);
    Route::post('projectlistbasedauction', [ProductApiController::class, 'projectlistbasedauction']);
    Route::post('projectlistbasedcategory', [ProductApiController::class, 'projectlistbasedcategory']);

    Route::post('productdetail', [ProductApiController::class, 'getProductDetail']);
    Route::get('bidvalue', [ProductApiController::class, 'bidvalue']);
    Route::post('/bidcreate', [ProductApiController::class, 'bidcreate']);
    Route::post('/bidupdate', [ProductApiController::class, 'bidupdate']);
    Route::post('generate', [ProductApiController::class, 'generate'])->name('generate');

     // wishlist related api 
    Route::post('addtowishlist', [ProductApiController::class,'addOrRemoveFromWishlist']);
    Route::post('myWishlist', [ProductApiController::class,'myWishlist']);
    // help support

    Route::post('help-support', [ProductApiController::class, 'helpsupport']);
    Route::post('bidrequest', [ProductApiController::class, 'bidrequest']);
    
    Route::get('notificationcount', [ProductApiController::class, 'notificationcount']);

    Route::get('notificationlist', [ProductApiController::class, 'notificationlist']);
    Route::post('markasread', [ProductApiController::class, 'markasread']);
    Route::get('mybid', [ProductApiController::class, 'mybid']);
    //PAST AUCTION

    Route::post('pastauction', [ProductApiController::class, 'pastauction']);
    // deeep linking
    

 
});

