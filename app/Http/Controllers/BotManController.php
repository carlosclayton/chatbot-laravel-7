<?php

namespace App\Http\Controllers;

use App\Conversations\QuizConversation;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Middleware\ApiAi;
use BotMan\BotMan\Middleware\Dialogflow;
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
//
//        $dialogflow = ApiAi::create('0913868cc83fb2c4e1459136626c0921521a2f24')->listenForAction();
//        $botman->middleware->received($dialogflow);
//        $botman->hears('smalltalk.agent.age', function ( $bot) {
//            $extras = $bot->getMessage()->getExtras();
//            $apiReply = $extras['apiReply'];
//            $apiAction = $extras['apiAction'];
//            $apiIntent = $extras['apiIntent'];
//            $bot->reply($apiReply);
//        })->middleware($dialogflow);





        $botman->hears('Olá|olá|ola|Ola', function ($bot) {
            $bot->typesAndWaits(2);
            $this->askName($bot);

        });

        $botman->hears('Signo|signo', function ($bot) {
            $bot->typesAndWaits(2);
            $bot->startConversation(new QuizConversation());
        });

        $botman->fallback(function ($bot) {
            $bot->reply($this->fallbackResponse());
        });


//        $botman->fallback(function ($bot) {
//            $bot->reply($bot->getMessage()->getExtras('apiReply'));
//        });

        $botman->listen();


    }

    public function fallbackResponse(){
        return Collection::make([
            'Desculpe, não entendi. Poderia repetir, por favor?',
            'Ainda não compreendi, poderia tentar novamente?',
            'Opa! não consegui entener, poderia repetir',
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

    public function setupDialog($botman){
        $dialogflow = ApiAi::create(env('DIALOG_FLOW_TOKEN'))->listenForAction();
        $botman->middleware->received($dialogflow);
        $botman->hears('my_api_action', function (BotMan $bot) {
            $extras = $bot->getMessage()->getExtras();
            $apiReply = $extras['apiReply'];
            $apiAction = $extras['apiAction'];
            $apiIntent = $extras['apiIntent'];
            $bot->reply("this is my reply");
        })->middleware($dialogflow);
    }

}
