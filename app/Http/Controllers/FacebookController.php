<?php

namespace App\Http\Controllers;

use App\Conversations\FacebookConversation;
use App\Conversations\FacebookProfileConversation;
use App\Conversations\FacebookQuizConversation;
use App\Conversations\TelegramConversation;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Facebook\Extensions\Element;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate;
use BotMan\Drivers\Facebook\Extensions\QuickReplyButton;
use BotMan\Drivers\Facebook\FacebookDriver;
use BotMan\Drivers\Facebook\FacebookLocationDriver;
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
                "verification" => env('FACEBOOK_VERIFICATION'),
                "start_button_payload" => env('START_BUTTON_PAYLOAD')
            ]

        ];

        DriverManager::loadDriver(FacebookDriver::class);
        DriverManager::loadDriver(FacebookLocationDriver::class);

        $botman = BotManFactory::create($config, new LaravelCache());


        $botman->hears('Olá|olá|ola|Ola|Começar', function ($bot) {
            $bot->typesAndWaits(1);
            $bot->startConversation(new FacebookConversation());
        });

        $botman->receivesLocation(function ($bot) {
            $bot->typesAndWaits(1);
            $bot->reply('location');
        });

        $botman->hears('user_profile', function ($bot) {
            $bot->typesAndWaits(1);
            $bot->startConversation(new FacebookProfileConversation());


        });

        $botman->hears('iniciar_pesquisa', function ($bot) {
            $bot->typesAndWaits(1);
            $bot->startConversation(new FacebookQuizConversation());


        });
        $botman->hears('cursos', function ($bot) {
            $bot->typesAndWaits(1);
            $bot->reply(GenericTemplate::create()
                ->addImageAspectRatio(GenericTemplate::RATIO_SQUARE)
                ->addElements([
                    Element::create('LARAVEL 5.8 – TORNE-SE UM DESENVOLVEDOR FULL STACK')
                        ->subtitle('Esta trilha tem como objetivo qualificar desenvolvedores para atuar como Full Stack Developer, um conceito que coloca o desenvolvedor no centro do processo de desenvolvimento. Ou seja, Infrastrutura, Designer, Banco de dados, testes, Front End e Back End fazem parte do background Full Stack.    Diante disso, iremos ver todos os aspectos envolvidos no processo de desenvolvimento de aplicações de ponta-a-ponta utilizando o Framework Laravel 5.7 juntamente com a poderosa  Platform as a Service Heroku para rodar  Pipelines e Review Apps tudo de forma integrada com Github.')
                        ->image('http://hub4dev.com.br/wp-content/uploads/2019/08/banner_trilha_fullstack-2-1024x362.jpg')
                        ->addButton(ElementButton::create('Mais informações')
                            ->url('http://hub4dev.com.br/laravel-5-8-torne-se-um-desenvolvedor-full-stack/')
                        )
                        ->addButton(ElementButton::create('Tenho interesse')
                            ->payload('fazer_reserva')
                            ->type('postback')
                        ),
                    Element::create('BotMan Laravel Starter')
                        ->subtitle('This is the best way to start with Laravel and BotMan')
                        ->image('http://botman.io/img/botman-body.png')
                        ->addButton(ElementButton::create('visit')
                            ->url('https://github.com/mpociot/botman-laravel-starter')
                        ),
                ])
            );


        });


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
