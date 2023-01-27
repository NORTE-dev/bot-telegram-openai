<?php

use NORTEdev\TelegramBot;

require_once __DIR__ . "/vendor/autoload.php";

$bot = new TelegramBot("5826242098:AAHN9yWhWI30ztDBj98dSxzxvjwCUg_g9Pk");
$bot->handleInput();
$bot->handleTriggers();