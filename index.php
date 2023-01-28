<?php

use NORTEdev\TelegramBot;

require_once __DIR__ . "/vendor/autoload.php";

$bot = new TelegramBot("");
$bot->handleInput();
$bot->handleTriggers();