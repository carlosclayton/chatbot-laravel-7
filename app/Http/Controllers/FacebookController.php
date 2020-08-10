<?php

namespace App\Http\Controllers;

use App\Conversations\QuizConversation;
use App\Conversations\TelegramConversation;
use App\Conversations\UserConversation;
use App\Http\Middleware\DialogflowV2;
use App\Http\Middleware\TypingMiddleware;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Middleware\ApiAi;
use BotMan\BotMan\Middleware\Dialogflow;

use BotMan\Drivers\Facebook\FacebookDriver;
use BotMan\Drivers\Telegram\TelegramDriver;
use BotMan\Drivers\Web\WebDriver;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Illuminate\Support\Collection;

class FacebookController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        //$botman = app('botman');

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
                "token" => "EAADrUyTBRMUBALrY6F3ZCLMvI8bmSPM90EOf3ICZAzpeD4NCbqZB54TLKvWvasdAY7Bhi45s8KQYSQSCFdzxUFI1LkW84yYzl5TGHMGsn4FQKbz0P0eVKg8hqlAJZBQUxeDlEW6bnvi9dioj4ummLwHtn5rTmK6WsYQZAzExmZA4Gwfd32twQUp2WjQr34KKMZD",
                "app_secret" => "0a2da13dbc68ab889dbc8b58ef36ff21",
                "verification"=>"258742331458757",
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
