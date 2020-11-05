<?php

namespace App\Test\TestCase\Domain\User\Repository;

use App\Test\AppTestTrait;
use App\Domain\User\Data\UserData;
use App\Domain\User\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase {
    use AppTestTrait;

    /**
     * @return void
     */
    public function testInsertUser(): void {    
        $username = ["userName" => 'john'];
        $this->mock(UserRepository::class)->method('insertUser')->willReturn(1);
        $repository = $this->container->get(UserRepository::class);
        $result = $repository->insertUser($username);

        $this->assertSame(1, $result);
    }


}