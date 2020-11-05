<?php

namespace App\Action;

use App\Domain\Message\Service\ShowAllMessagesService;
use App\Response\Payload;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ShowAllMessagesAction {

    public $request;
    public $response;
    public $args;

    public $service;

    public function __construct(ShowAllMessagesService $MessageSendService) {
        $this->service = $MessageSendService;
    }
    
    public function __invoke(Request $request, Response $response, $args): Response {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
        
        return $this->sendRequest();
    }

    public function sendResponse($data = null): Response {
        $json = json_encode(new Payload($data));
        $this->response->getBody()->write($json);

        return $this->response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
    }

    public function sendRequest(): Response {
        $data = $this->args['recipient'];
        $messages = $this->service->listMessagesByRecipient($data);
        return $this->sendResponse($messages);
    }
}