<?php

namespace App\Domain\Message\Service;

use App\Domain\Message\Data\MessageData;
use App\Domain\Message\Repository\MessageRepository;
use Exception;

class MessageSendService {

    private $repository;

    public function __construct(MessageRepository $repository) {
        $this->repository = $repository;
    }

    public function sendMessage(array $data): MessageData {
        $messageID = $this->repository->insertMessage($data);
        return new MessageData ($messageID, $data['messageSender'], $data['messageReciever'], $data['messageContent']);
    }
}