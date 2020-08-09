<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class TelegramConversation extends Conversation
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
    }

}
