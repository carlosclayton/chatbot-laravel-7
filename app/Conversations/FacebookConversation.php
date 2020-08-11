<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\Extensions\QuickReplyButton;

class FacebookConversation extends Conversation
{

    /**
     * @return mixed|void
     */
    public function run()
    {
        $this->message();

    }

    public function message()
    {
        $firstName = $this->bot->getUser()->getFirstName();
//        $this->bot->reply('ID: ' . $this->bot->getUser()->getId() );
        $this->bot->reply('Olá ' . $firstName . ', seja bem vindo ao nosso atendimento, sou Carlos o seu assistente virtual.');
//        $this->askBot();
//        $this->buttonTemplate();
//        $this->askLocation();

    }

    public function askBot(){

        $this->ask('Gostaria de aprender a criar Chatbot multiplataformas usando Laravel 7 e linguagem natural? ', [
            [
                'pattern' => 'Sim|sim|claro|pode ser|tenho interesse',
                'callback' => function () {
                    $this->say('😉 Okay, vamos registrar seu interesse. ');
//
                }
            ],
            [
                'pattern' => 'não|nao|obrigado',
                'callback' => function () {
                    $this->say('😔 Tudo bem, fica pra próxima.');
                }
            ]
        ]);
    }

    public function buttonTemplate(){
        $this->reply(ButtonTemplate::create('Gostaria de mais informações sobre o curso?')
            ->addButton(ElementButton::create('Mais informações')
                ->url('http://hub4dev.com.br/')
            )
        );
    }

    public function askLocation(){
        $question = Question::create('Great. Can you give me your location?')
            ->addAction(QuickReplyButton::create('test')->type('location'));

        $this->ask($question, function (Answer $answer) {
            $this->bot->reply('Latitude: '.$answer->getMessage()->getLocation()
                    ->getLatitude().' Longitude: '.$answer->getMessage()->getLocation()->getLongitude());
        });
    }

}
