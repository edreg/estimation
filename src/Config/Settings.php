<?php

use Tracy\Debugger;

defined('DS') || define('DS', DIRECTORY_SEPARATOR);
define('DIR', dirname(__DIR__, 2) . DS);

Debugger::enable(Debugger::DEVELOPMENT, __DIR__ . '/../../logs');

return [
    'settings' => [
        'displayErrorDetails'               => true, // set to false in production
        'addContentLengthHeader'            => false, // Allow the web server to send the content-length header
        'determineRouteBeforeAppMiddleware' => false,
        'debug'                             => true,

        // Renderer settings
        'renderer'                          => [
            'template_path' => __DIR__ . '/../../templates/',
        ],

        // Monolog settings
        'logger'                            => [
            'name'  => 'slim-app',
            'path'  => __DIR__ . '/../../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'modules' => [
            'core' => 'LoadMan'
        ],

        // DB Connection
        'db'    => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'username'  => 'root',
            'password'  => '',
            'database'  => 'alko_rest',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],

        // Debugger
        'tracy' => [
            'showPhpInfoPanel'         => 0,
            'showSlimRouterPanel'      => 0,
            'showSlimEnvironmentPanel' => 0,
            'showSlimRequestPanel'     => 1,
            'showSlimResponsePanel'    => 1,
            'showSlimContainer'        => 0,
            'showEloquentORMPanel'     => 0,
            'showTwigPanel'            => 0,
            'showIdiormPanel'          => 0,
            // > 0 mean you enable logging
            // but show or not panel you decide in browser in panel selector
            'showDoctrinePanel'        => 'em',
            // here also enable logging and you must enter your Doctrine container name
            // and also as above show or not panel you decide in browser in panel selector
            'showProfilerPanel'        => 0,
            'showVendorVersionsPanel'  => 0,
            'showXDebugHelper'         => 1,
            'showIncludedFiles'        => 0,
            'showConsolePanel'         => 0,
            'configs'                  => [
                // XDebugger IDE key
                'XDebugHelperIDEKey'   => 'PHPSTORM',
                // Disable login (don't ask for credentials, be careful) values( 1 || 0 )
                'ConsoleNoLogin'       => 0,
                // Multi-user credentials values( ['user1' => 'password1', 'user2' => 'password2'] )
                'ConsoleAccounts'      => [
                    'dev' => '34c6fceca75e456f25e7e99531e2425c6c1de443'// = sha1('dev')
                ],
                // Password hash algorithm (password must be hashed) values('md5', 'sha256' ...)
                'ConsoleHashAlgorithm' => 'sha1',
                // Home directory (multi-user mode supported) values ( var || array )
                // '' || '/tmp' || ['user1' => '/home/user1', 'user2' => '/home/user2']
                'ConsoleHomeDirectory' => dirname(__DIR__, 2),
                // terminal.js full URI
                'ConsoleTerminalJs'    => '/assets/js/jquery.terminal.min.js',
                // terminal.css full URI
                'ConsoleTerminalCss'   => '/assets/css/jquery.terminal.min.css',
                'ProfilerPanel'        => [
                    // Memory usage 'primaryValue' set as Profiler::enable() or Profiler::enable(1)
                    //                    'primaryValue' =>                   'effective',    // or 'absolute'
                    'show' => [
                        'memoryUsageChart' => 1, // or false
                        'shortProfiles'    => true, // or false
                        'timeLines'        => true // or false
                    ],
                ],
            ],
        ],
    ],
];
