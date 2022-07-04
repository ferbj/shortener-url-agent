<?php
namespace App\Http\Services;

use App\Url;
use App\Click;

class ApiService{
    public static function getApiData(){
        $urls = Url::with('clicks')->get();
        $clicks = Click::with('url')->get();

        foreach($urls as $url){
            foreach($clicks as $click){
           $data[]  = [
                "type" => "urls",
                "id" => $url->id,
                "attributes" => [
                    "created-at" => date($url->created_at),
                    "original-url" => $url->original_url,
                    "url" => url()->previous().'/'.$url->short_url,
                    "clicks" => $url->clicks_count,
                ],
                "relationships"=>[
                    "clicks" => [
                        "data"=> [
                            "id"=> $url->id,
                            "type" => "clicks"
                        ]
                    ]
                ],
            ];
            $included[] = [
                "type" => "clicks",
                    "id" => $click->id,
                    "attributes" => [
                        "created_at" => date($click->created_at),
                        "browser" => $click->browser,
                        "platform" => $click->platform
                    ]
            ];
      }
    }

    return response()->json(['data'=> $data,'included' => $included]);
}
}
