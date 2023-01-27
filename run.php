<?php
$token = "5826242098:AAHN9yWhWI30ztDBj98dSxzxvjwCUg_g9Pk";
$url = 'https://www.bot.norte.dev.br'; // substitua com o endereço do seu arquivo PHP
$api = 'https://api.telegram.org/bot'.$token;

$output = file_get_contents($api.'/setWebhook?url='.$url);
echo $output;
