<?php

if (PHP_SAPI === 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

//https://trinitytuts.com/secure-your-php-web-services-using-jwt/
//https://trinitytuts.com/rest-api-using-slim-2-framework/

require __DIR__ . '/../vendor/autoload.php';

session_start();

RunTracy\Helpers\Profiler\Profiler::enable();

RunTracy\Helpers\Profiler\Profiler::start('loadSettings');
$cfg = require __DIR__ . '/../config/Settings.php';
RunTracy\Helpers\Profiler\Profiler::finish('loadSettings');

RunTracy\Helpers\Profiler\Profiler::start('initApp');
$app = new \Estimation\Helper\App($cfg);
RunTracy\Helpers\Profiler\Profiler::finish('initApp');

// Register dependencies
RunTracy\Helpers\Profiler\Profiler::start('RegisterDependencies');
require __DIR__ . '/../config/Dependencies.php';
RunTracy\Helpers\Profiler\Profiler::finish('RegisterDependencies');

$app->add(new RunTracy\Middlewares\TracyMiddleware($app));

// Register middleware
RunTracy\Helpers\Profiler\Profiler::start('RegisterMiddlewares');
require __DIR__ . '/../config/Middleware.php';
RunTracy\Helpers\Profiler\Profiler::finish('RegisterMiddlewares');

// Register routes
RunTracy\Helpers\Profiler\Profiler::start('RegisterRoutes');
require __DIR__ . '/../config/Routes.php';
RunTracy\Helpers\Profiler\Profiler::finish('RegisterRoutes');

//RunTracy\Helpers\Profiler\Profiler::start('RegisterModules')
//// Register modules
//$app->getContainer()->get('module')->initModules($app, $cfg['settings']['modules'])
//RunTracy\Helpers\Profiler\Profiler::finish('RegisterModules')

RunTracy\Helpers\Profiler\Profiler::start('runApp, %s, line %s', basename(__FILE__), __LINE__);
// Run app
$app->run();

RunTracy\Helpers\Profiler\Profiler::finish('runApp, %s, line %s', basename(__FILE__), __LINE__);
