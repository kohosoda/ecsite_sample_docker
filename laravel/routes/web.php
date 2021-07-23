<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 商品一覧画面
Route::name('item.')->group(function(){
  Route::get('/', 'ItemController@index')->name('index');
  Route::get('/item/{item}', 'ItemController@show')->name('show');
  Route::put('/item/{item}/like', 'ItemController@like')->name('like');
  Route::delete('/item/{item}/like', 'ItemController@unlike')->name('unlike');  
});

// カート画面
Route::name('cart.')->middleware('auth')->group(function(){
  Route::get('/cartitem', 'CartItemController@index')->name('index');
  Route::post('/cartitem', 'CartItemController@store')->name('store');
  Route::put('/cartitem/{cartItem}', 'CartItemController@update')->name('update');
  Route::delete('/cartitem/{cartItem}', 'CartItemController@destroy')->name('destroy'); 
});

// 購入処理
Route::post('/solditem', 'SoldItemController@store')->middleware('auth')->name('soldItem.store');

// マイページ
Route::name('mypage.')->middleware('auth')->group(function(){
  Route::get('/mypage', 'UserController@show')->name('show');  //登録情報を表示
  Route::post('/mypage', 'UserController@store')->name('store'); //登録情報を更新
  Route::get('/mypage/like', 'UserController@like')->name('like'); // お気に入り
  Route::get('/mypage/history', 'UserController@history')->name('history');  //購入履歴  
});

//認証用ルート
Auth::routes(); 