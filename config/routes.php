<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app){
    $app->post('/user', \App\Action\CreateUserAction::class);

    $app->post('/message', \App\Action\SendMessageAction::class);

    $app->get('/messages/{recipient}', \App\Action\ListMessagesAction::class);
};