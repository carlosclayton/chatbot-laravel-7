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

        $this->bot->typesAndWaits(1);
        $this->bot->reply('Olá ' . $firstName . ', seja bem vindo ao nosso atendimento, sou o seu assistente virtual.');

        $this->bot->typesAndWaits(1);
        $this->introducaoTrilha();
//        $this->askBot();
//        $this->buttonTemplate();


    }

    public function askBot()
    {

        $this->bot->ask('Gostaria de conhecer as trilhas que estão disponíveis no momento? ', [
            [
                'pattern' => 'Sim|sim|claro|pode ser|tenho interesse',
                'callback' => function () {
                    $this->bot->reply('😉 Okay, vamos registrar seu interesse. ');
//
                }
            ],
            [
                'pattern' => 'não|nao|obrigado',
                'callback' => function () {
                    $this->bot->reply('😔 Tudo bem, fica pra próxima.');
                }
            ]
        ]);
    }


    public function buttonTemplate()
    {
        $this->reply(ButtonTemplate::create('Gostaria de mais informações sobre o curso?')
            ->addButton(ElementButton::create('Mais informações')
                ->url('http://hub4dev.com.br/')
            )
        );
    }

    public function introducaoTrilha()
    {

        $this->bot->reply("O HUB4DEV foi criado para suprir a necessidade que o mercado de Desenvolvimento de Software tem por profissionais mais práticos.  ");
        $this->bot->typesAndWaits(1);
        $this->bot->reply("Nós oferecemos diversas trilhas de aprendizagem para ajudar você a atingir seus obetivos de forma mais rápida e consistente.");

    }


}
