<?php

namespace App\Http\Controllers;

use App\Conversations\QuizConversation;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Middleware\ApiAi;
use BotMan\BotMan\Middleware\Dialogflow;

use BotMan\Drivers\Telegram\TelegramDriver;
use BotMan\Drivers\Web\WebDriver;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Illuminate\Support\Collection;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

//        $dialogflow = DialogflowV2::create('en')
//            ->listenForAction();
//
//        $botman->middleware->received($dialogflow);
//
//        $botman->hears('smalltalk.agent.*', function ( $bot) {
//            $extras = $bot->getMessage()->getExtras();
//            $apiReply = $extras['apiReply'];
//            $apiAction = $extras['apiAction'];
//            $apiIntent = $extras['apiIntent'];
//            $bot->reply($apiReply);
//        })->middleware($dialogflow);

//        $config = [
//            'web' => [
//                'matchingData' => [
//                    'driver' => 'web',
//                ]
//            ],
//            'config' => [
//                'user_cache_time' => 30000,
//                'conversation_cache_time' => 30000,
//            ]
//        ];
//
//        DriverManager::loadDriver(WebDriver::class);
//        $botman = BotManFactory::create($config, new LaravelCache());

        $botman->hears('Olá|olá|ola|Ola', function ($bot) {
            $bot->typesAndWaits(1);
            $this->askName($bot);

        });

        $botman->hears('Signo|signo', function ($bot) {
            $bot->typesAndWaits(1);
            $bot->startConversation(new QuizConversation());
        });

//        $botman->hears('login', function ($bot) {
//            $bot->typesAndWaits(1);
//            $bot->startConversation(new UserConversation());
//        });

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

    public function askName($botman)
    {

        $botman->ask('😀 Olá! Qual o seu nome?', function (Answer $answer) {
            $name = $answer->getText();
            $this->say('🥰 Prazer  ' . $name . ', como podemos ajuda-lo?');
        });
    }


}
