<?php
namespace App\Http\Services;
use App\Url;

use Exception;
use App\Http\Services\UrlService;
use App\Http\Services\ClickService;

class StoreService{

    public static function saveDataUrl($request,$randomstr,$agent){
        $exist_url = Url::where('original_url',$request->original_url)->first();
            //if exist a url
        if($exist_url) {
           return ClickService::saveExistUrl($exist_url,$request,$agent);
        }
        //is not exist the url create a new Url
            try{
                $url = UrlService::savenotExistUrl($request,$randomstr);
                ClickService::savenotExistUrl($url,$agent);
                return redirect()->back()->with('notice','New Url Added');
            }catch(Exception $e){
                return redirect()->back()->withErrors($e->getMessage());
            }
    }
}
