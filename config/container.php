<?php

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

return [

    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        return AppFactory::create();
    },

    // Db Connection
    PDO::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['db'];        
        $conn = new PDO('sqlite:' . __DIR__ . $settings['dbname']);
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn -> exec('PRAGMA foreign_keys = ON;');

        return $conn;
    },
    
    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $errorSettings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$errorSettings['display_error_details'],
            (bool)$errorSettings['log_errors'],
            (bool)$errorSettings['log_error_details']
        );
    }
    

];