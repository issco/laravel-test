<?php
 
use Illuminate\Support\Facades\Route;


Route::get('/statistics','Controller@goToStatisticsPage');
Route::get('/recipies','RecipeController@goToRecipiesPage');
Route::get('/categories','CategoryController@goToCategoriesPage');
Route::get('/recipe','RecipeController@goToAddRecipePage');
Route::post('/recipe/add','RecipeController@add');  
Route::get('/recipe/{id}/delete','RecipeController@delete');
Route::get('/recipe/{id}/edit','RecipeController@goToEditPage'); 
// Auth::routes();
Route::get('/', 'Controller@index')->name('index'); 
Route::get('/home', 'Controller@home')->name('home');  
 