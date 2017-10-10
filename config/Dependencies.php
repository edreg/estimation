<?php
// DIC configuration

use Estimation\Helper\Response;
use Slim\Http\Headers;

$container = $app->getContainer();
//$container['settings'] = $settings;

// view renderer
$container['renderer'] = function (\Slim\Container $c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\Twig($settings['template_path']);
};

// monolog
$container['logger'] = function (\Slim\Container $c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['response'] = function (\Slim\Container $container) {
    $headers = new Headers(['Content-Type' => 'text/html; charset=UTF-8']);
    $response = new Response(200, $headers);

    return $response->withProtocolVersion($container->get('settings')['httpVersion']);
};

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../templates', [
        'cache' => false, //'path/to/cache'
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};
