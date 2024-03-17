<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register','ApiController@register');
Route::get('/show_privacy_policy','ApiController@showPrivacyPolicy');
Route::get('/slide/images','ApiController@Slider');
Route::get('/user/data/{id}','ApiController@userData');
Route::post('/verify/email','ApiController@verify_email');
Route::post('/login', 'ApiController@login');
Route::get('/region', 'ApiController@region');
Route::get('/cities/{region_id}', 'ApiController@cities');
Route::get('/area/{city_id}', 'ApiController@area');
Route::get('/role', 'ApiController@roles');
Route::get('/sub_role/{role_id}', 'ApiController@sub_roles');
Route::post('/password_change/{id}', 'ApiController@password_change');
Route::post('forget_password_send_otp', 'ApiController@forget_password_send_otp');
Route::post('/reset_password/{id}', 'ApiController@reset_password');
Route::post('/EditProfile/{id}', 'ApiController@EditProfile');
Route::post('/logout', 'ApiController@logout');
Route::get('/product_detail', 'ApiController@product_detail');
Route::get('/product_detailV2', 'ApiController@product_detailV2');
Route::post('/spinReward', 'ApiController@spinReward');
Route::get('get/bank/data', 'ApiController@get_bank_data');




Route::post('insert/walltet', 'ApiController@insertWalltet');
Route::get('walltet/delete/{id}', 'ApiController@deleteWallet');
Route::get('walltet/history/{user_id}', 'ApiController@Wallethistory');
Route::post('coin/request/{user_id}', 'ApiController@coinRequest');

Route::get('category/coins/{id}', 'ApiController@categoryCoins');
Route::get('coinHistory/{user_id}', 'ApiController@coinHistory');
Route::get('totalCoins/{user_id}', 'ApiController@totalCoins');
Route::get('withdraw/amount/{user_id}', 'ApiController@withdrawAmount');
Route::get('wallte/data/{user_id}', 'ApiController@walletData');
Route::post('/store/Bank/Data', 'ApiController@storeBankData');
Route::get('bank/data/{id}', 'ApiController@bankData');
Route::get('bank/data/delete/{id}', 'ApiController@bankDelete');
Route::post('update/bank/data/{user_id}/{bank_id}', 'ApiController@updateBankData');
Route::post('updateQuantity/', 'ProductController@updateQuantity');


