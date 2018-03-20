<?php
Route::get('/', 'HomeController@home')->name('home');

Route::get('a/{alias}', 'AlbumController@show')->name('showAlbum');
Route::post('a/delete/{alias}', 'AlbumController@delete')->name('postAlbumDelete');

Route::get('i/{alias}', 'ImageController@show')->name('showImage');
Route::post('i/delete/{alias}', 'ImageController@delete')->name('postImageDelete');

Route::post('/u', 'UploadController@postUpload')->name('postUpload');

// auth
Route::get('register', 'Auth\RegisterController@getRegister')->name('getRegister');
Route::post('register', 'Auth\RegisterController@postRegister')->name('postRegister');

Route::get('login', 'Auth\LoginController@getLogin')->name('getLogin');
Route::post('login', 'Auth\LoginController@postLogin')->name('postLogin');

Route::get('logout', 'Auth\LogoutController@getLogout')->name('getLogout');

// profile
Route::get('me', 'ProfileController@getProfile')
  ->name('getProfile')
  ->middleware('cauth');

Route::post('u/a/delete', 'AlbumController@userPostAlbumDelete')
    ->name('userPostAlbumDelete')
    ->middleware('cauth');

Route::post('u/i/delete/', 'ImageController@userPostImageDelete')
    ->name('userPostImageDelete')
    ->middleware('cauth');

Route::post('profile/cpwd', 'ProfileController@changePassword')
  ->name('changePassword')
  ->middleware('cauth');

Route::get('me/a/', 'AlbumController@getAlbumsUser')
  ->name('getAlbumsUser')
  ->middleware('cauth');

Route::get('me/i/', 'ImageController@getImagesUser')
  ->name('getImagesUser')
  ->middleware('cauth');

// faq
Route::get('faq', function () {
  return view('faq');
})->name('faq');

