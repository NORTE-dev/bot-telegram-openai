<?php

namespace NORTEdev;

use Dompdf\Dompdf;

class TelegramBot
{
    private $api;
    private $chatId;
    private $message;
    private $triggers = [
        '/start' => 'Welcome to our bot!',
        '/help' => 'Here is a list of commands: ...',
        '/weather' => 'To get the weather, please enter your location.',
        '/rad' => "Bem-vindo a Radical Store. \n O você deseja? \n /livros /camisetas /bones /canecas",
        '/livros' => "Boa pedida, temos o melhor acerto de livros para você. \n Escolha uma categoria. \n /financeiro /discipulado /santidade /jejum /oracao",
        '/image' => 'https://cdn.midjourney.com/70eb0374-aa63-4df5-8ee7-613b2b493b48/grid_0.png',
        '/img' => 'OK OK',
        '/financeiro' => "OK"
    ];

    public function __construct($token)
    {
        $this->api = "https://api.telegram.org/bot" . $token . "/";
    }

    public function handleInput()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $this->chatId = $input['message']['chat']['id'];
        $this->message = $input['message']['text'];
    }

    public function sendMessage($text)
    {
        $data = array(
            'chat_id' => $this->chatId,
            'text' => $text
        );

        file_get_contents($this->api . "sendMessage?" . http_build_query($data));
    }

    public function ip()
    {
        $ch = curl_init('https://api.ipify.org/?format=json');

        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => 1,
        ]);

        $resposta = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $resposta["ip"];
    }

    public function handleTriggers()
    {
        $msg = "OK";
        foreach ($this->triggers as $trigger => $response) {
            if (strpos($this->message, $trigger) === 0) {
                $msg = $response;
                break;
            }
            if (strpos($this->message, "/ip") === 0) {
                $msg = $this->ip();
                break;
            }
            if (strpos($this->message, "/pdf") === 0) {
                $msg = $this->pdf();
                break;
            }
        }
        $this->sendMessage($msg);
    }

    public function pdf()
    {
        $url = "https://www.bot.norte.dev.br/pdf/";
        $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . "pdf";
        if (!is_dir($path)) {
            mkdir($path, '0765', true);
        }

        $dompdf = new Dompdf();

        $body = null;
        foreach ($this->triggers as $key=>$value){
            $body.="<p>Comando: $key | resposta: $value</p>";
        }

        $dompdf->loadHtml('<h1>Lista de comandos!</h1>'.$body);
        $dompdf->render();
        $pdf = $dompdf->output();
        $nome = md5(uniqid(time(), true)) . ".pdf";
        file_put_contents($path . DIRECTORY_SEPARATOR . $nome, $pdf);

        return $url . $nome;
    }
}