<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app){
    $app->post('/addUser', \App\Action\AddUserAction::class);

    $app->post('/sendMessage', \App\Action\MessageSendAction::class);

    $app->get('/getMessages/{recipient}', \App\Action\ShowAllMessagesAction::class);
};