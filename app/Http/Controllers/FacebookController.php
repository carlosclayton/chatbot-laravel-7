<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Facebook\FacebookDriver;
use Illuminate\Support\Collection;

class FacebookController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
//        $botman = app('botman');

        $config = [
            "web" => [
                "matchingData" => [
                    "driver" => "facebook",
                ]
            ],
            "botman" => [
                "conversation_cache_time" => 3600,
                "user_cache_time" => 3600,
            ],
            "facebook" => [
                "token" => env('FACEBOOK_TOKEN'),
                "app_secret" => env('FACEBOOK_APP_SECRET'),
                "verification" => env('FACEBOOK_VERIFICATION')
            ]

        ];

        DriverManager::loadDriver(FacebookDriver::class);
        $botman = BotManFactory::create($config, new LaravelCache());


        $botman->fallback(function ($bot) {
            $bot->typesAndWaits(1);
            $bot->reply($this->fallbackResponse());
        });


        $botman->listen();


    }

    public function fallbackResponse()
    {
        return Collection::make([
            'Desculpe, não entendi. Poderia repetir, por favor?',
            'Ainda não compreendi, poderia tentar novamente?',
            'Opa! não consegui entender, poderia repetir',
            'Ok, vamos começar de novo. Poderia tentar mais uma vez?'
        ])->random();
    }


}
