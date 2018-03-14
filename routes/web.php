<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvaliaser within a group which
| contains the "web" maliasdleware group. Now create something great!
|
*/
Route::get('a/{alias}', 'AlbumController@show')->name('showAlbum');
Route::post('a/delete/{alias}', 'AlbumController@delete')->name('postAlbumDelete');

Route::get('i/{alias}', 'ImageController@show')->name('showImage');
Route::post('i/delete/{alias}', 'ImageController@delete')->name('postImageDelete');

Route::get('/', 'UploadController@getUpload')->name('getUpload');
Route::post('/', 'UploadController@postUpload')->name('postUpload');
