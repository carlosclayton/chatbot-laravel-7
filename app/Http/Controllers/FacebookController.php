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
use BotMan\Drivers\Facebook\Extensions\ListTemplate;
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


        $botman->hears('Olá|olá|ola|Ola|Começar|olá!', function ($bot) {
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
                        ->subtitle('Esta trilha tem como objetivo qualificar desenvolvedores para atuar como Full Stack Developer.')
                        ->image('http://hub4dev.com.br/wp-content/uploads/2019/08/banner_trilha_fullstack-2-1024x362.jpg')
                        ->addButton(ElementButton::create('Mais informações')
                            ->url('http://hub4dev.com.br/laravel-5-8-torne-se-um-desenvolvedor-full-stack/')
                        )
                        ->addButton(ElementButton::create('Tenho interesse')
                            ->payload('fazer_reserva')
                            ->type('postback')
                        ),
                    Element::create('LARAVEL 5.8 – DESENVOLVIMENTO DE UMA API RESTFUL')
                        ->subtitle('Esta trilha tem como objetivo abordar todos aspectos envolvidos no processo de desenvolvimento de uma poderosa API utilizando o Framework Laravel.')
                        ->image('http://hub4dev.com.br/wp-content/uploads/2019/11/BANNER-LARAVEL-API-RESTFUL-1-1024x452.jpg')
                        ->addButton(ElementButton::create('Mais informações')
                            ->url('http://hub4dev.com.br/laravel-5-8-desenvolvimento-de-uma-api-restfull/')
                        )
                        ->addButton(ElementButton::create('Tenho interesse')
                            ->payload('fazer_reserva')
                            ->type('postback')
                        ),
                    Element::create('PROVISIONANDO TECNOLOGIAS PARA GARANTIR ALTA DISPONIBILIDADE DE APLICAÇÕES LARAVEL')
                        ->subtitle('Esta trilha tem como objetivo explorar a cultura DevOps através de um conjunto de práticas para integração entre as equipes de desenvolvimento de softwares e operações através da adoção de processos automatizados para produção rápida e segura de aplicações Laravel.')
                        ->image('http://hub4dev.com.br/wp-content/uploads/2019/11/banner-trilha-devops-1024x564.jpg')
                        ->addButton(ElementButton::create('Mais informações')
                            ->url('http://hub4dev.com.br/provisionando-tecnologias-para-garantir-alta-disponibilidade-de-aplicacoes-laravel/')
                        )
                        ->addButton(ElementButton::create('Tenho interesse')
                            ->payload('fazer_reserva')
                            ->type('postback')
                        ),

                ])
            );


        });

        $botman->hears('fazer_reserva', function ($bot) {
            $bot->typesAndWaits(1);
            $bot->reply('Perfeito! sua reserva já está confirmada.');


        });


        $botman->hears('blog', function ($bot) {
            $bot->reply(ListTemplate::create()
                ->useCompactView()
                ->addGlobalButton(ElementButton::create('Mais Notícias')
                    ->url('http://hub4dev.com.br/blog/')
                )
                ->addElement(Element::create('Como fazer deploy de aplicações Laravel 5.8 usando Heroku')
                    ->subtitle('Hoje vamos aprender como fazer deploy de aplicações Laravel usando o Heroku. ')
                    ->image('http://hub4dev.com.br/wp-content/uploads/2019/11/banner-deploy-870x489.jpg')
                    ->addButton(ElementButton::create('Acessar')
                        ->url('http://hub4dev.com.br/2019/11/18/como-fazer-deploy-de-aplicacoes-laravel-usando-heroku/')
                    )
                )
                ->addElement(Element::create('Laravel Passport - Criando uma API de autenticação RestFul')
                    ->subtitle('Antes de iniciar a prática, vamos entender alguns conceitos básicos que estão envolvidos neste Post. ')
                    ->image('http://hub4dev.com.br/wp-content/uploads/2019/08/banner-laravel-passport-api-restful-870x383.png')
                    ->addButton(ElementButton::create('Acessar')
                        ->url('http://hub4dev.com.br/2019/08/19/laravel-passaport-criando-uma-api-de-autenticacao-restful/')
                    )
                )
                ->addElement(Element::create('Configuração do ambiente de desenvolvimento Laravel 5.8 usando Ubuntu 18.04 LTS no Windows 10')
                    ->subtitle('É isso mesmo que você leu, vamos aprender a configurar o ambiente de desenvolvimento o Laravel na versão 5.8 usando o Ubuntu 18.04 diretamente no Windows 10. ')
                    ->image('http://hub4dev.com.br/wp-content/uploads/2019/08/banner-laravel-passport-api-restful-870x383.png')
                    ->addButton(ElementButton::create('visit')
                        ->url('http://hub4dev.com.br/2019/08/10/configuracao-do-ambiente-de-desenvolvimento-laravel-5-8-usando-ubuntu-18-04-lts-no-windows-10/')
                    )
                )
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
