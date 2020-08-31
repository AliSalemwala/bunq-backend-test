<?php

use Slim\App;
use App\Middleware\ExceptionMiddleware;
use Slim\Middleware\ErrorMiddleware;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Catch exceptions
    $app->add(ExceptionMiddleware::class);

    // Catch errors
    $app->add(ErrorMiddleware::class);

    
};
