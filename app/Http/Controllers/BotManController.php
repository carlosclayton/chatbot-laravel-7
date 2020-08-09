<?php

namespace App\Http\Controllers;

use App\Conversations\QuizConversation;
use App\Conversations\TelegramConversation;
use App\Conversations\UserConversation;
use App\Http\Middleware\DialogflowV2;
use App\Http\Middleware\TypingMiddleware;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Middleware\ApiAi;
use BotMan\BotMan\Middleware\Dialogflow;

use BotMan\Drivers\Telegram\TelegramDriver;
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
        $botman = resolve('botman');

//        $config = [
//            "telegram" => [
//                "token" => env('TELEGRAM_TOKEN')
//            ]
//        ];
//
//        DriverManager::loadDriver(TelegramDriver::class);
//        $botman = BotManFactory::create($config);

        $botman->hears('/start|start', function ($bot) {
            $bot->typesAndWaits(1);
            $bot->startConversation(new TelegramConversation());
        });

        $botman->hears('/lancamento|lancamento', function ($bot) {
            $bot->typesAndWaits(1);
            $bot->reply('🥰 Falta pouco para o lançamento do curso: Desenvolvendo Chatbots multiplataformas com linguagem natural usando Laravel 7');

            $bot->ask('Gostaria de participar?', [
                [
                    'pattern' => 'Sim|sim|claro|pode ser|tenho interesse',
                    'callback' => function () {
                        $this->say('😉 Okay, vamos registrar seu interesse. ');
                    }
                ],
                [
                    'pattern' => 'não|nao|obrigado',
                    'callback' => function (    ) {
                        $this->say('😔 Tudo bem, fica pra próxima.');
                    }
                ]
            ]);
        });


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

    public function fallbackResponse(){
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
