<?php
namespace App\Http\Services;
use App\Click;
use Exception;

class ClickService{
    public static function saveExistUrl($exist_url,$request,$agent){
        try{
            $exist_url->where('original_url',$request->original_url)->increment('clicks_count',1);
            Click::create([
                'url_id' => $exist_url->id,
                'browser' => $agent->browser(),
                'platform' => $agent->platform()
            ]);
            return redirect()->back()->with('notice','Url Updated click counter');
        }catch(Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }

    }
    public static function savenotExistUrl($url,$agent){

        return Click::create([
            'url_id' => $url->id,
            'browser' => $agent->browser(),
            'platform' => $agent->platform()
        ]);

    }

    public static function getDailyClicks($url){
        $dailyClicks = [];
        $clicks = Click::with('url')->get()
            ->where('url_id',$url->id)
            ->groupBy(function ($item) {return $item->created_at->format('d-m-Y');})->toArray();
        foreach($clicks as $k => $click){
            $dailyClicks[] = [$k, count($clicks[$k])];
        }
        return $dailyClicks;
    }

    public static function getBrowsers($url){
         $browsersClicks = [];
         $browsers = Click::with('url')->get()->where('url_id',$url->id)->groupBy('browser')->toArray();
         $browsersName = array_keys($browsers);

         foreach($browsersName as $brow){
             $browsersClicks[] = [$brow, count($browsers[$brow])];
         }
         return $browsersClicks;
    }

    public static function getPlatforms($url){
        $platformClicks=[];
        $platforms = Click::with('url')->get()->where('url_id',$url->id)->groupBy('platform')->toArray();
        $platform_name = array_keys($platforms);

        foreach($platform_name as $platform){
            $platformClicks[] = [$platform,count($platforms[$platform])];
        }
        return $platformClicks;
    }
}
