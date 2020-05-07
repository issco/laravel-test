<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\recipe;
use App\category;
class CategoryController extends Controller
{
    public function goToCategoriesPage()
    {
    	$categories=category::withCount('recipies')->get();
        return view('category',compact('categories'));
    }
        public function getCategories()
    {
        $categories=category::withCount('recipies')->get();
        return response()->api(["categories"=>$categories], null);
    }
        public function add(Request $request)
    {
    	$category=new category;
    	$category->title=$request->title;
    	$category->save();
    	$categories=category::withCount('recipies')->get();
        return response()->api(["categories"=>$categories], null);
    }

}
