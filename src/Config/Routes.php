<?php

use Estimation\Controller\HomeController;
use RunTracy\Controllers\RunTracyConsole;

// Routes
$app->post('/console/{id:[0-9]+}', RunTracyConsole::class . ':index');
$app->get('/console', RunTracyConsole::class . ':index');

$app->get('/', HomeController::class . ':indexAction');
$app->post('/', HomeController::class . ':calculateAction');
