<?php

namespace App\Domain\User\Data;

use JsonSerializable;

class UserData implements JsonSerializable {

    private $id;
    private $username;

    public function __construct (int $id, string $username) {
        $this->id = $id;
        $this->username = strtolower($username);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function jsonSerialize(): array {
        return [
            'userID' => $this->id,
            'userName' => $this->username
        ];
    }
}