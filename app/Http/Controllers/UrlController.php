<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use App\Http\Requests\UrlRequest;
use App\Http\Services\ApiService;
use App\Http\Services\UrlService;
use App\Http\Services\StoreService;
use App\Http\Services\HelpersService;
use App\Http\Services\StatisticsService;
use Jenssegers\Agent\Agent;

class UrlController extends Controller
{

     /*List of urls and clicks*/
    public function index(Url $url)
    {
        $urls = UrlService::getUrls($url);
        return view('urls.index', compact('url','urls'));
    }

    /*Store a new Url and update the click counter*/
    public function store(UrlRequest $request,Agent $agent){
        $randomStr = HelpersService::randomstr();
        return StoreService::saveDataUrl($request,$randomStr,$agent);
    }

    /*redirect short_url to original webpage*/
    public function visit(Request $request)
    {
        return UrlService::getVisits($request);
    }

    /*show statistics*/
    public function show($shortUrl)
    {
        return StatisticsService::getStatistics($shortUrl);
    }

    /*getUrls for Api http://127.0.0.1:8000/api/v1/geturls*/
    public function geturls(){
        return ApiService::getApiData();
    }
}
