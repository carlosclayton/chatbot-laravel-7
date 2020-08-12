<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\Extensions\QuickReplyButton;

class FacebookQuizConversation extends Conversation
{

    /**
     * @return mixed|void
     */
    public function run()
    {
        $this->askQuestionOne();
    }

    private function askQuestionOne()
    {
        $question = Question::create('Qual a sua avaliação para este atendimento?')->addButtons([
            Button::create('Ótimo')->value('otimo'),
            Button::create('Regular')->value('regular'),
            Button::create('Ruim')->value('ruim'),
        ]);

        $this->ask($question, function (Answer $answer) {
            $this->typesAndWaits(1);
            $this->bot->reply('Ok, vamos pra próxima...');
            return $this->askQuestionTwo();
        });
    }

    private function askQuestionTwo()
    {
        $question = Question::create('O atendente conseguiu resolver o seu problema?')->addButtons([
            Button::create('Sim')->value('sim'),
            Button::create('Não')->value('nao'),
            Button::create('Parcialmente')->value('parcialmente'),
        ]);

        $this->ask($question, function (Answer $answer) {
            $this->typesAndWaits(1);
            $this->bot->reply('Ok, vamos pra próxima...');
            return $this->askQuestionThree();
        });
    }

    private function askQuestionThree()
    {
        $question = Question::create('Você recomendaria nossos serviços?')->addButtons([
            Button::create('Sim')->value('sim'),
            Button::create('Não')->value('nao'),
            Button::create('Talvez')->value('talvez'),
        ]);

        $this->ask($question, function (Answer $answer) {
            return $this->bot->reply('Pesquisa finalizada, agradecemos pela atenção.');
        });
    }

}
