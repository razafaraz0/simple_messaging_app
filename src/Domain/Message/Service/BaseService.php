<?php

namespace App\Domain\Message\Service;

use Exception;
use App\Domain\Message\Repository\BaseRepository;

abstract class BaseService {
    private $repository;

    public function __construct(BaseRepository $repository) {
        $this->repository = $repository;
    }
}