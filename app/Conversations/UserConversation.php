<?php

namespace App\Conversations;

use App\User;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserConversation extends Conversation
{


    protected $user;


    public function loginUser() {
        // Access user
        if ($this->bot->getUser()->getInfo()) {
            $user = User::where('messenger_id', $this->bot->getUser()->getId())->first();
            if (isset($user) && $user->name) {
                Auth::login($user, true);
                $this->user = Auth::user();
                $this->say('Hi ' . $this->user->name);

            } else {
                $this->createUser();
            }
        } else {
            $this->askName();
        }

    }

    public function createUser() {
        if ($this->bot->getUser()->getInfo()) {
            $this->user = User::createFromIncomingMessage($this->bot->getUser());
        } else {
            $this->user['messenger_id'] = null;
            $this->user['email'] = null;
            $this->user = User::create($this->user);
        }
        Auth::login($this->user, true);
        $this->user = Auth::user();
        $this->say('Hi ' . $this->user->name);

    }



    public function run() {
        // This will be called immediately
        $this->user = new User();
        $storage = $this->bot->userStorage();
        $storage->save([
            'name' => "Carlos Clayton",
            'email' => "carlos.clayton@gmail.com",
            'password' => bcrypt('123456789')
        ]);

        $this->askName();



    }

    public function askName()
    {
        Log::info($this->bot->userStorage()->all());
        Log::error('ID: '. $this->bot->getUser()->getInfo('userId'));
        $this->bot->ask('😀 Olá! Qual o seu nome?', function (Answer $answer) {
            $this->say('🥰 Prazer  ' . $answer->getText() );
        });

    }

    public function askEmail()
    {
        $this->bot->ask('😀 Olá! Qual o seu email?', function (Answer $answer) {
            $this->say('🥰 Ok, obrigado');
        });
    }
}

