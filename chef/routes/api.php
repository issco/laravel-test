<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:api'], function () {
Route::post('/category/add','CategoryController@add');
Route::put('/recipe/update/','RecipeController@update');
Route::post('/auth','Controller@checkIfAuth');
});
Route::post('login', 'User@login')->name('login');
Route::get('/getReceipies/{page}','RecipeController@getReceipies');
Route::get('/search','RecipeController@search');


 