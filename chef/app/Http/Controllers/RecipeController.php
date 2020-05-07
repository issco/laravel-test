<?php
namespace App\Http\Controllers;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use App\category;
use App\steps;
use App\recipe;
use App\Helper;
use App\Helpers\myCustomHelper;
use Config;
use Validator;
use Redirect;   
 

class RecipeController extends Controller
{
    public function search(Request $request){
        $param=$request['param'];

        if(strlen ($param)>2 ){
        $Recipies=recipe::where("title","like",'%'.$param.'%')->get();
        $FormattedRecipies = myCustomHelper::GetRecipiesFormattedData($Recipies);
         return response()->api($FormattedRecipies, null);
        }

        else{
         return response()->api(null, null);
        }
        
    }


    public function update(Request $request)
    {

        $Recipe = recipe::find($request->id);
        if (!isset($request->title))
        {
            return response()->api(null, "FORM000");
        }

        if (!isset($request->category_id))
        {
            return response()->api(null, "FORM001");
        }

     foreach($Recipe->steps as $step) {
        $step->delete();
    }
        $Recipe->title = $request->title;
        $Recipe->category_id = $request->category_id;
        $Recipe->save();
        $steps = $request->steps;
        if (isset($steps[0])||isset($steps[1])||isset($steps[2]))
        {
            for ($i = 0;$i < count($steps);$i += 2)
            { 
                $sp = new Steps;
                isset($steps[$i]) ? $sp->title = $steps[$i]: NULL;
                isset($steps[$i + 1]) ? $sp->amount = $steps[$i+1]: NULL;
                $sp->recipe_id = $request->id;
                $sp->stepOrder = $i;
                if(isset($steps[$i])|| isset($steps[$i + 1])){
                	$sp->save();
                }
                
            }
        }
        return response()->api(null, "FORM010");
    }
    public function goToEditPage($id)
    {

        $categories = category::withCount('recipies')->get();
        $recipe = myCustomHelper::getRecipeShortDetails(recipe::find($id));

        return view('edit')->with('categories', $categories)->with('recipe', $recipe)->render();
    }

    public function delete($id)
    {

    	$result=myCustomHelper::destroyRecipe($id);
        $Recipies = recipe::get();
        $FormattedRecipies = count($Recipies) > 0 ? $FormattedRecipies = myCustomHelper::GetRecipiesFormattedData($Recipies) : null;
        return Redirect::back()
            ->with('Recipies', $FormattedRecipies) ;       
    }

    public function getReceipies($page)
    {
        $count=recipe::where("id","!=","0")->count();
        $totalPages = ceil($count / 5);

        if (!((1<= $page) && ($page <= $totalPages))) 
            return response()->api(null,"FORM015");

        $Recipies = recipe::orderBy('created_at', 'DESC')->skip(($page - 1) * 5)->take(5)->get();
        $FormattedRecipies = myCustomHelper::GetRecipiesFormattedData($Recipies);
        return response()->api(["totalPages"=>$totalPages,"data"=>$FormattedRecipies],null);
    }

    public function goToRecipiesPage()
    { 
        $Recipies = recipe::orderBy('created_at', 'DESC')->get();
        $FormattedRecipies = myCustomHelper::GetRecipiesFormattedData($Recipies);
        return view('recipies')->with('Recipies', $FormattedRecipies)->render();
    }
    public function goToAddRecipePage()
    {
        $categories = category::withCount('recipies')->get();
        return view('recipe', compact('categories'));
    }

    public function add(Request $request)
    { 

        $categories = category::withCount('recipies')->get();
        $recipe = new recipe;

        if (!isset($request->url))
        {
            return Redirect::back()
                ->with('Msg', Config::get('enums.Errors_En.FORM013'))
                ->with('categories', $categories);
        }

        if (!myCustomHelper::checkIfUrlIsValid($request->url)) {
                        return Redirect::back()
                ->with('Msg', Config::get('enums.Errors_En.FORM014'))
                ->with('categories', $categories);    
        }
$videoInfo=myCustomHelper::getVideoInfo($request->url);
// dd($e[1]); 
        // if (!isset($request->title))
        // {
        //     return Redirect::back()
        //         ->with('Msg', Config::get('enums.Errors_En.FORM000'))
        //         ->with('categories', $categories);
        // }

        if (!isset($request->category))
        {
            return Redirect::back()
                ->with('Msg', Config::get('enums.Errors_En.FORM001'))
                ->with('categories', $categories);
        }

        // if ($request->hasFile('thumb'))
        // {
        //     $validator2 = Validator::make($request->all() , ['thumb' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', ]);
        //     if (count($validator2->errors()) > 0)
        //     {
        //         return Redirect::back()
        //             ->with('Msg', Config::get('enums.Errors_En.FORM008'))
        //             ->with('categories', $categories);
        //     }

        //     $file = $request['thumb'];
        //     $filename2 = $file->getClientOriginalName();
        //     $extension = \File::extension($filename2);
        //     $filename2 = myCustomHelper::getNewGuid() . "." . $extension;
        //     $path = public_path() . '/images/thumbs/';
        //     $file->move($path, $filename2);
        // }
 
        // else return Redirect::back()->with('Msg', Config::get('enums.Errors_En.FORM009'))
        //     ->with('categories', $categories);

        // if ($request->hasFile('video'))
        // {
        //     $validator = Validator::make($request->all() , ['video' => 'mimes:mp4,mov,ogg,qt | max:150000', ]);
        //     if (count($validator->errors()) > 0)
        //     {
        //         return Redirect::back()
        //             ->with('Msg', Config::get('enums.Errors_En.FORM007'))
        //             ->with('categories', $categories);
        //     }

        //     $file = $request['video'];
        //     $filename = $file->getClientOriginalName();
        //     $extension = \File::extension($filename);
        //     $filename = myCustomHelper::getNewGuid() . "." . $extension;
        //     $path = public_path() . '/videos/';
        //     $file->move($path, $filename);
        // }

        // else return Redirect::back()->with('Msg', Config::get('enums.Errors_En.FORM002'))
        //     ->with('categories', $categories);

$embed=$videoInfo->items[0]->player->embedHtml;
$e=explode(" ", $embed);
$e=explode("embed/", $e[3]); 
$e=str_replace('"', '', $e);
        $recipe->title = $videoInfo->items[0]->snippet->title;
        $recipe->url = $e[1];
        $recipe->category_id = $request->category;
        $recipe->peopleCount = $request->count;
        $recipe->Yviews=$videoInfo->items[0]->statistics->viewCount;
        // $recipe->video_path = $filename;
        $recipe->thumbnail = $videoInfo->items[0]->snippet->thumbnails->standard->url;
        $recipe->save();
        $steps = $request->fields;

        if (isset($steps[0]))
        {

            for ($i = 0;$i < count($steps);$i += 2)
            {
                $sp = new Steps;
                $sp->title = $steps[$i];
                $sp->amount = $steps[$i + 1];
                $sp->recipe_id = $recipe->id;
                $sp->stepOrder = $i;
                $sp->save();
            }
        }
        $Recipies = recipe::get();
        $FormattedRecipies = myCustomHelper::GetRecipiesFormattedData($Recipies);
             return Redirect::back()
             ->with('Msg',Config::get('enums.Errors_En.FORM012'))
             ->with('categories', $categories)
             ->with('token', $request->auth_token);

    }
}

