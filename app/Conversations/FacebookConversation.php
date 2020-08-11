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
        $this->say('Para iniciar nosso atendimento, preciso confirmar algumas informações pessoais com vc 😏');
        $this->askEmail();

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

    public function askEmail(){
        $question = Question::create('Podemos utilizar este e-mail como principal?')
            ->addAction(QuickReplyButton::create('test')->type('user_email'));

        $this->ask($question, function (Answer $answer) {
            $this->bot->reply('Obrigado, o e-mail: ' . $answer->getValue() . ' será usado para futuras comunicações.');
        });

        $this->askNumber();
    }

    public function askNumber(){
        $question = Question::create('Encontramos este e-mail, podemos cadastrá-lo em nosso sistema?')
            ->addAction(QuickReplyButton::create('test')->type('user_phone_number'));

        $this->ask($question, function (Answer $answer) {
            $this->bot->reply('Legal, o telefone: ' . $answer->getValue() . ' e seu cadastra está atualizado.');
        });
    }

}
