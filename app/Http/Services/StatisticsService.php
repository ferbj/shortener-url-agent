<?php
namespace App\Http\Services;

use Exception;
use App\Http\Services\ClickService;

class StatisticsService{

    public static function getStatistics($short_url){
        $url = UrlService::existUrl($short_url);
        try {
            $dailyClicks = ClickService::getDailyClicks($url);
            $browsersClicks = ClickService::getBrowsers($url);
            $platformClicks = ClickService::getPlatforms($url);
            return view('urls.show', ['url' =>$url, 'browsers_clicks' => $browsersClicks, 'daily_clicks' => $dailyClicks, 'platform_clicks' => $platformClicks]);
        } catch (Exception $e) {
        return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
