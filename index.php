<?php

require 'vendor/autoload.php';

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

$config = [
    // Your driver-specific configuration
    'slack' => [
        'token' => 'xoxb-309577759200-wiyjW3qyfOxZBKvWrHGTTkGf'
    ]
];

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'cache' => 'cache',
));

// Load the driver(s) you want to use
DriverManager::loadDriver(\BotMan\Drivers\Slack\SlackDriver::class);

// Create an instance
$botman = BotManFactory::create($config);

// Give the bot something to listen for.
$botman->hears('hello', function (BotMan $bot) use ($twig) {
    $template = $twig->load('welcome.txt');
    $bot->reply($template->render([]));
});

// Give the bot something to listen for.
$botman->on('member_joined_channel', function ($payload, $bot) use ($twig) {
    $template = $twig->load('welcome.txt');
    $bot->reply($template->render([]));
});


// Start listening
$botman->listen();