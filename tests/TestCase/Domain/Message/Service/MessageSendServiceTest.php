<?php

namespace App\Test\TestCase\Domain\Service;

use Exception;
use App\Test\AppTestTrait;
use App\Domain\Message\Data\MessageData;
use App\Domain\Message\Service\MessageSendService;
use App\Domain\Message\Repository\MessageRepository;
use PHPUnit\Framework\TestCase;

class MessageSendServiceTest extends TestCase {
    use AppTestTrait;


    /**
     * @return void
     */
    public function testSendMessage(): void {

        $this->mock(MessageRepository::class)->method('insertMessage')->willReturn(1);

        $service = $this->container->get(MessageSendService::class);

        $requestBody = [
            "messageSender" => "jack",
            "messageReciever" => "john",
            "messageContent" => "hello"
        ];

        $responseMessage = $service->sendMessage($requestBody);

        $this->assertSame($responseMessage->getSender(), 'jack');
        $this->assertSame($responseMessage->getRecipient(), 'john');
        $this->assertSame($responseMessage->getBody(), 'hello');
    }

    /**
     * @return void
     */
    public function testMissingSenderParameterException(): void {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage("Incorrect input `messageSender` given");

        $service = $this->container->get(MessageSendService::class);

        $request = ["messageReciever" => "john", "messageContent" => "hello"];

        $responseMessage = $service->sendMessage($request);
    }

    /**
     * @return void
     */
    public function testMissingRecipientParameterException(): void {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage("Incorrect input `messageReciever` given");

        $service = $this->container->get(MessageSendService::class);

        $request = ["messageSender" => "jack", "messageContent" => "hello"];

        $responseMessage = $service->sendMessage($request);
    }

    /**
     * @return void
     */
    public function testMissingBodyParameterException(): void {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage("Incorrect input `messageContent` given");

        $service = $this->container->get(MessageSendService::class);
        $request = ["messageSender" => "jack", "messageReciever" => "john"];
        $responseMessage = $service->sendMessage($request);
    }
}