<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\Extensions\QuickReplyButton;

class FacebookProfileConversation extends Conversation
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
        $this->bot->typesAndWaits(1);
        $this->bot->reply('Olá ' . $firstName . ', preciso confirmar algumas informações pessoais com vc 😏');
        $this->bot->typesAndWaits(1);
        $this->askEmail();

    }


    public function askEmail()
    {
        $question = Question::create('Podemos utilizar este e-mail como principal?')
            ->addAction(QuickReplyButton::create('test')->type('user_email'));

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->bot->reply('Obrigado, o e-mail: ' . $answer->getValue() . ' foi cadastrado com sucesso.');
                $this->bot->typesAndWaits(1);
                $this->askNumber();
            }
        });

    }

    public function askNumber()
    {

        $question = Question::create('Este telefone ainda é usado por você?')
            ->addAction(QuickReplyButton::create('test')->type('user_phone_number'));

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->bot->reply('Legal, o telefone: ' . $answer->getValue() . ' foi cadastrado com sucesso.');
            }
        });
    }

}
