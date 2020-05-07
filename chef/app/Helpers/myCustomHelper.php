<?php
/**
 * Created by PhpStorm.
 * User: Fayez 
 post_max_size, upload_max_filesize
 */
namespace App\Helpers;

use Illuminate\Http\Request;
use App\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use App\recipe; 
use App\category;
use App\steps;
use App\Challenge;
use File;
use Config;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Boolean;
use Madcoda\Youtube\Youtube;

class myCustomHelper
{
public static function getChannelStatistics(){
$youtube = new Youtube(array('key' => env('YOUTUBE_API_KEY'))); 
$channel = $youtube->getChannelById('UCo0m8aHuHA7pq3LCeN6l73Q');
        return [
            "title" =>  $channel->snippet->title,
            "description" =>  $channel->snippet->description,
            "publishedAt"=> Carbon::parse($channel->snippet->publishedAt)->format('d M Y'),
            "youtubeViews"=>$channel->statistics->viewCount,
            "youtubeSubscriberCount"=>$channel->statistics->subscriberCount,
            "youtubeVideoCount"=>$channel->statistics->videoCount,
            "appSubscriberCount"=>User::count()-1,
            "appVideoCount"=>recipe::count(),
            "challengesCount"=>Challenge::count(),
        ];
}
public static function getVideoInfo($url){
    $urlToken;
    if (strpos($url, 'youtube.com/watch')) {
          $token = explode("=",$url);
          $urlToken=$token[1];  
    }
    else if((strpos($url, 'youtu.be'))){
        $token = explode(".be/",$url);
       $urlToken=$token[1];
if(strpos($token[1], '?')){
    $token = explode("?",$token[1]);
    $urlToken=$token[0];
}
    }

if(strpos($urlToken, '&feature')){
    $token = explode("&feature",$urlToken);
    $urlToken=$token[0];
}

     $youtube = new Youtube(array('key' => env('YOUTUBE_API_KEY'))); 

$video = $youtube->getVideoInfo($urlToken);

return $video;
}


    public static function checkIfUrlIsValid($url){
if (filter_var($url, FILTER_VALIDATE_URL))
return true;
else
return false;
    }

    public static function checkIfAuth(){
return true;
    }
        public static function checkIfAdmin($user)
    {
        return $user->role == 0;
    }

    
public static function formatViewsCount($views)
    {

   $ViewsCount = $views <1000 ? $views: number_format($views/1000,1) . 'k';
   return $ViewsCount;
    }

    public static function GetRecipiesFormattedData($Recipies){
        
        $recipiesToReturn = [];
foreach ($Recipies as $recipe) {
        array_push($recipiesToReturn, myCustomHelper::getRecipeShortDetails($recipe));
        }
        return $recipiesToReturn;
    }


    public static function destroyRecipe($id){

       $recipe=recipe::find($id);
       if($recipe){
       if(isset($recipe->steps)){
    foreach($recipe->steps as $step) {
        $step->delete();
    }
}
    // File::delete(public_path().'/images/thumbs/'.$recipe->thumbnail);
    // File::delete(public_path().'/videos/'.$recipe->video_path);

         recipe::find($id)->delete();
         return response()->api(null, "FORM011");
     }
    }

 
        public static function getRecipeShortDetails($Recipe)
    {
        return [
 
            "id" =>  $Recipe->id,
            "title" =>  $Recipe->title,
            "category" =>  $Recipe->category->title,
            "views" =>  myCustomHelper::formatViewsCount($Recipe->views),
            "youtube_views"=>myCustomHelper::formatViewsCount($Recipe->Yviews),
            "thumbnail" => $Recipe->thumbnail,
            "url"=>"https://www.youtube.com/watch?v=".$Recipe->url,
            "video" => $Recipe->video_path,
            "steps" => $Recipe->steps != null ?$Recipe->steps->toJson() : null,
            "embed"=>$Recipe->url,
            ];
    }

    public static function getNewGuid()
    {
        $guid = "";
        if (function_exists('com_create_guid')) {
            $guid = com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $guid = chr(123)
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . chr(125);
        }
        return strtolower(str_replace('}', '', str_replace('{', '', $guid)));
    }
}