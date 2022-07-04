<?php

namespace Tests\Unit;

use App\Url;
use App\Click;
use App\Http\Services\ClickService;
use App\Http\Services\UrlService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

# app/tests/controllers/UrlControllerTest.php
class UrlControllerTest extends TestCase
{
    /*Test Index load with data*/
    use RefreshDatabase;

    /*test when is created urls and clicks on database*/
    public function test_create_data_test()
    {
        $this->withExceptionHandling();
        $url = factory(Url::class,50)->create();
        $click = factory(Click::class,150)->create();
        $this->assertNotEmpty($url);
        $this->assertNotEmpty($click);
    }

    /*test index get and load data*/
    public function test_index_load_data()
    {
        $this->withExceptionHandling();
        $response = $this->get('/');
        $response->assertStatus(200);
        $url = new Url();
        $values = UrlService::getUrls($url);
        $response->assertViewIs('urls.index');
        $this->assertNotEmpty($values);

    }

    /*Test show statistics from shorcoded url*/
    public function test_show_statistics(){
        $this->withExceptionHandling();
        $id = random_int(1,50);
        $short_url = Url::findOrFail($id)->short_url;
        $url = UrlService::existUrl($short_url);
        $response = $this->get('urls/'.$short_url);
        $dailyClicks = ClickService::getDailyClicks($url);
        $this->assertArrayHasKey(0,$dailyClicks);
        $response->assertSee('Windows');
        $response->assertSee('Mozilla');
        $response->assertViewIs('urls.show');
    }
    /*test a redirect shortcode site*/
    public function test_redirect_shortcode_to_site() {
        $this->withExceptionHandling();
        $id = random_int(1,50);
        $test_shorturl = Url::findOrFail($id)->short_url;
        $test_url = Url::findOrFail($id)->original_url;
        if(!isset($test_url)){
            abort(404);
        }
        $original_url = Url::where('short_url',$test_shorturl)->firstOrFail()->original_url;
        if(isset($original_url)){
            $this->assertEquals($test_url,$original_url);
            $this->followingRedirects($original_url);
        }

    }
    /*test api data and structure*/
    public function test_api_data_and_structure(){
        $response = $this->json('GET','api/v1/geturls');
        $response->assertStatus(200);
        $this->assertNotEmpty($response);
        $response->assertJsonStructure(['data' =>
        [
            '*' => [
                'type',
                'id',
                'attributes' => [
                    'created-at',
                    'original-url',
                    'url',
                    'clicks'
                ],
                'relationships' => [
                    'clicks' => [
                        'data' => [
                            'id',
                            'type'
                        ]
                    ]
                ]
            ]
        ],
        'included' => [
            '*' => [
                'type',
                'id',
                'attributes'=> [
                    'created_at',
                    'browser',
                    'platform'
                ]
            ]
        ]]);
    }

    }
