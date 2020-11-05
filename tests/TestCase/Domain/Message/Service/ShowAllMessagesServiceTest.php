<?php

namespace App\Test\TestCase\Domain\Service;

use Exception;
use App\Test\AppTestTrait;
use App\Domain\Message\Data\MessageData;
use App\Domain\Message\Service\MessageSendService;
use App\Domain\Message\Service\ShowAllMessagesService;
use App\Domain\Message\Repository\MessageRepository;
use PHPUnit\Framework\TestCase;

class ShowAllMessagesServicesTest extends TestCase {
    use AppTestTrait;

    /**
     * @return void
     */
    public function testListMessagesByRecipient(): void {
        $testMessageOne = new MessageData(1, "Jack", "John", "Hello Kind Sir");
        $testMessages = array();
        array_push($testMessages, $testMessageOne);

        $this->mock(MessageRepository::class)->method('selectMessagesByRecipient')->willReturn(
            array(
                0 => array(
                    'messageID' => 1,
                    'messageSender' => "Jack",
                    'messageReciever' => "John",
                    'messageContent' => "Hello Kind Sir")
                )
        );

        $service = $this->container->get(ShowAllMessagesService::class);
        $responseMessages = $service->listMessagesByRecipient("John");

        $this->assertSame($responseMessages[0]["messageSender"], "Jack");
        $this->assertSame($responseMessages[0]["messageReciever"], "John");
        $this->assertSame($responseMessages[0]["messageContent"], "Hello Kind Sir");
    }

    /**
     * @return void
     */
    public function testMissingSenderParameterException(): void {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage("Incorrect input `messageSender` given");

        $service = $this->container->get(MessageSendService::class);

        $request = ["messageReciever" => "John", "messageContent" => "Hello Kind Sir"];

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

        $request = ["messageSender" => "Jack", "messageContent" => "Hello Kind Sir"];

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

        $request = ["messageSender" => "Jack", "messageReciever" => "John"];

        $responseMessage = $service->sendMessage($request);
    }
}