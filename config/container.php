<?php

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

return [
    // The settings for this API
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    // The App
    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        return AppFactory::create();
    },

    // Used to catch errors
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
    },
    
    // Used for database connection
    PDO::class => function (ContainerInterface $container) {
        $dbSettings = $container->get('settings')['db'];

        $dbname = $dbSettings['dbname'];
        $path = __DIR__ . $dbname;

        $conn = new PDO('sqlite:' . $path);
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn -> exec('PRAGMA foreign_keys = ON;');

        return $conn;
    }
];