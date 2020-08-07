<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class QuizConversation extends Conversation
{


    public function run()
    {
        $this->question();
    }

    public function question()
    {
        $question = Question::create("Escolha seu signo?")
            ->addButtons([
                Button::create('Áries')->value('aries'),
                Button::create('Touro')->value('touro'),
                Button::create('Gêmeos')->value('gemeos'),
                Button::create('Câncer')->value('cancer'),
                Button::create('Leão')->value('leao'),
                Button::create('Virgem')->value('virgem'),
                Button::create('Libra')->value('libra'),
                Button::create('Escorpião')->value('escorpiao'),
                Button::create('Sagitário')->value('sargitario'),
                Button::create('Capricórnio')->value('capricornio'),
                Button::create('Aquário')->value('aquario'),
                Button::create('Peixes')->value('peixes')

            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->say("Você escolheu: " . $answer->getText());
                $this->say("Confira a previsão do Horóscopo 2020 de hoje para seu signo: ");

                if ($answer->getValue() === 'aries') {
                    $this->say("Avalie sonhos e ambições. Intuição e sintonia com a força interior revelarão caminhos a seguir. O céu conspirará a seu favor. Saiba esperar o tempo certo para concretizar planos e decidir rumos. Com Marte em seu signo, não haverá porta fechada. O dia favorecerá atividades criativas, decisões sobre filhos e conquista de maior independência. Poder pessoal em alta!");
                } elseif ($answer->getValue() === 'touro') {
                    $this->say("Poder de influência e prestígio marcarão sua presença nas redes sociais e na equipe de trabalho hoje. Atividades em grupo, conexões com autoridades, mestres ou pessoas de outras localidades serão enriquecedoras. Amplie relacionamentos e movimente negócios. Com Vênus na área do dinheiro, cuide das suas posses, do seu patrimônio, e mantenha o orçamento estabilizado.");
                } elseif ($answer->getValue() === 'gemeos') {
                    $this->say("Planos atraentes para o futuro. Momento de se aproximar da missão, redirecionar a carreira e assumir mais poder. Envolvimento com um novo grupo renovará conceitos e mobilizará mudanças. Pesquise cursos on-line, aprenda uma linguagem diferente, atualize tecnologias e amplie as comunicações e contatos. A cabeça estará a mil. Discuta ideias com amigos.");
                } elseif ($answer->getValue() === 'cancer') {
                    $this->say("Clima mágico numa viagem, ou em conexão com pessoas de longe, proporcionará lindos momentos hoje. Se estiver só, poderá surgir chance para o amor. Novos relacionamentos despertarão seus melhores sentimentos. Tudo aberto para realizar um sonho do casamento. Decisões sobre o futuro e investimentos cobrarão organização financeira. Racionalize custos.");
                } elseif ($answer->getValue() === 'leao') {
                    $this->say("Prefira a privacidade para se concentrar no trabalho ou planejar as mudanças que deseja. Sentimentos profundos inspirarão novos planos e reformulações da rotina. Bom momento para dar uma virada de vida e embarcar em experiências diferentes. Sol e Mercúrio em seu signo iluminarão objetivos e caminhos para o futuro. Comece novo ciclo e inove a carreira");
                } elseif ($answer->getValue() === 'virgem') {
                    $this->say("Emoções fortes envolverão a relação com os filhos ou par. O amor atingirá camadas mais profundas dos sentimentos. Bom para fortalecer vínculos importantes em sua vida e também para se apaixonar novamente, se estiver só. Aproveite esta fase que antecede o aniversário para fazer um balanço dos últimos tempos e encerrar um longo ciclo. Mudanças pela frente!");
                } elseif ($answer->getValue() === 'libra') {
                    $this->say("Rotina gostosa, harmonia, apoio familiar e ótimo desempenho no trabalho manterão a tranquilidade e segurança. Novas amizades motivarão atividade diferente de lazer. Ótimo momento para iniciar relacionamentos, ampliar sua rede e as chances para o amor, se o coração estiver livre. Aprenda com novas referências e some forças com o grupo.");
                } elseif ($answer->getValue() === 'escorpiao') {
                    $this->say("Conversas sensíveis com o par redefinirão planos da relação. Esclareça dúvidas e resolva diferenças. Encerre dinâmicas do passado e renove os conceitos sobre o amor. O trabalho ganhará amplitude. Impulsione novo projeto e alavanque a carreira. Sol e Mercúrio anunciam sucesso, visibilidade e perspectivas de bons contratos. Criatividade em alta!");
                } elseif ($answer->getValue() === 'sargitario') {
                    $this->say("Um negócio imobiliário poderá se definir hoje. O dia trará oportunidade financeira e decisões familiares. Planeje uma viagem ou impulsione um projeto pessoal e realize um sonho antigo. Bom momento para escapar da rotina em segurança, nem que seja só na fantasia. Dê asas à imaginação. Lembranças gostosas e resgates do passado intensificarão as emoções.");
                } elseif ($answer->getValue() === 'capricornio') {
                    $this->say("Palavras emocionadas, lindas histórias e empatia nas comunicações tocarão o coração hoje. Circule pelas redes, troque mensagens e ligue suas antenas. O dia trará informações preciosas e novidades. Bom para descobrir novos focos de interesse, investigar informações e decifrar segredos. Esclareça confusões no trabalho e relações próximas. Proximidade com a família. ");
                } elseif ($answer->getValue() === 'aquario') {
                    $this->say("Cuidado com distrações nas contas ou gastos sem pensar. Assuntos financeiros cobrarão reflexões. Você terá boas oportunidades para aumentar os rendimentos. Conte com maior poder de negociação e argumentos imbatíveis. Planos a dois fortalecerão o casamento. Se estiver só, novo romance começará com discussão instigante. Solte a curiosidade nas relações.");
                } else {
                    $this->say("Lua em seu signo destacará os sonhos. Projete sua imagem e atraia oportunidades de negócio. Fase de conquistas financeiras e de sucesso no trabalho. Inicie um empreendimento, ou viabilize novos projetos com apoio de parceiros. Dê um toque especial na decoração da casa e torne o cotidiano mais agradável. Família em harmonia. Pense mais em você!");
                }

            }
        });
    }
}
