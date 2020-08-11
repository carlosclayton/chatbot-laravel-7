<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\ElementButton;

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
        $this->bot->reply('Olá ' . $firstName . ', seja bem vindo ao nosso atendimento, sou Carlos o seu assistente virtual.');
        $this->askBot();
    }

    public function askBot(){

        $this->ask('Gostaria de aprender a criar Chatbot multiplataformas usando Laravel 7 e linguagem natural? ', [
            [
                'pattern' => 'Sim|sim|claro|pode ser|tenho interesse',
                'callback' => function () {
                    $this->say('😉 Okay, vamos registrar seu interesse. ');
                    $this->buttonTemplate();
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
            ->addButton(ElementButton::create('Tenho interesse')
                ->type('postback')
                ->payload('interesse')
            )
            ->addButton(ElementButton::create('Mais informações')
                ->url('http://hub4dev.com.br/')
            )
        );
    }

}
