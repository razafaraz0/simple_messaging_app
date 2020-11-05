<?php

namespace App\Test\TestCase\Domain\User\Service;

use Exception;
use App\Test\AppTestTrait;
use App\Domain\User\Data\UserData;
use App\Domain\User\Service\AddUserService;
use App\Domain\User\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class AddUserServiceTest extends TestCase {
    use AppTestTrait;

    /**
     * @return void
     */
    public function testCreateUser(): void {

        $this->mock(UserRepository::class)->method('insertUser')->willReturn(1);

        $service = $this->container->get(AddUserService::class);
        $user = ["userName" => "john"];
        $responseUser = $service->createUser($user);

        $this->assertSame($responseUser->getId(), 1);
        $this->assertSame($responseUser->getUsername(), "john");
    }
    
    // /**
    //  * @return void
    //  */
    public function testMissingUsernameParameterException(): void {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage("Incorrect input `userName` given");

        $service = $this->container->get(AddUserService::class);
        $responseUser = $service->createUser([]);
    }
}