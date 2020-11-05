<?php

namespace App\Domain\Message\Service;
    
use App\Domain\Message\Service\BaseService;
use App\Domain\Message\Repository\MessageRepository;

class ShowAllMessagesService extends BaseService {
    private $repository;

    public function __construct(MessageRepository $repository) {
        $this->repository = $repository;
    }

    public function listMessagesByRecipient(string $recipient): array {
        return $this->repository->selectMessagesByRecipient($recipient);
    }

}