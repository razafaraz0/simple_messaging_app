<?php

namespace App\Domain\Message\Data;

use JsonSerializable;

class MessageData implements JsonSerializable {
    private $id;
    private $sender;
    private $recipient;

    private $body;

    public function __construct(int $id, string $sender, string $recipient, string $body) {
        $this->id = $id;
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->body = $body;
    }

    public function getSender(): string {
        return $this->sender;
    }

    public function getRecipient(): string {
        return $this->recipient;
    }

    public function getBody(): string {
        return $this->body;
    }

    public function jsonSerialize(): array {
        return [
            'messageSender' => $this->sender,
            'messageReciever' => $this->recipient,
            'messageContent' => $this->body
        ];
    }
}