<?php
namespace App\Http\Services;

use App\Url;
use Exception;

class UrlService{
    public static function savenotExistUrl($request,$randomstr){
       return Url::create([
            'clicks_count' => 1,
            'short_url' => $randomstr,
            'original_url' => $request->original_url,
        ]);
    }

    public static function getVisits($request){
        try{
            $original_url = Url::where('short_url',$request->url)->firstOrFail()->original_url;
               return redirect($original_url);
           }catch(Exception $e){
               return redirect()->back()->withErrors($e->getMessage());
         }
    }

    public static function existUrl($short_url){
        if(!isset($short_url)){
            abort(404,'Doesnt exist short url');
        }
        $url = Url::with('clicks')->where('short_url',$short_url)->firstOrFail();
        if(!isset($url)){
            abort(404,"The Url doesn't Exist");
        }
        return $url;
    }

    public static function getUrls($url){
        return $url->orderBy('created_at','DESC')->paginate(10);
    }
}

