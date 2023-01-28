<?php
$token = "";
$url = 'https://www.bot.norte.dev.br'; // substitua com o endereço do seu arquivo PHP
$api = 'https://api.telegram.org/bot'.$token;

$output = file_get_contents($api.'/setWebhook?url='.$url);
echo $output;
