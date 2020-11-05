<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserData;
use App\Domain\User\Repository\UserRepository;

use Exception;

class AddUserService {
    private $repository;

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function createUser(array $data): UserData {
        $userId = $this->repository->insertUser($data);
        return new UserData ($userId, $data['userName']);
    }
}