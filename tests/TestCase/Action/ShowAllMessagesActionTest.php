<?php

namespace App\Test\TestCase\Action;

use App\Test\AppTestTrait;
use App\Action\ShowAllMessagesAction;
use App\Domain\Message\Data\MessageData;
use App\Domain\Message\Service\ShowAllMessagesService;
use PHPUnit\Framework\TestCase;

class ShowAllMessagesActionTest extends TestCase {
    use AppTestTrait;

    /**
     * @return void
     */
    public function testShowAllMessagesAction(): void {
        $testRecipientId = 2;
        $testMessageOne = new MessageData(1, "Jack", "John", "Hello Kind Sir");
        $testMessageTwo = new MessageData(2, "John", "Jack", "Top of the morning to you too");
        $testMessages = array($testMessageOne, $testMessageTwo);

        $expectedResult = [
            "data" =>[
                [ "messageSender" => $testMessageOne->getSender(),  "messageReciever" => $testMessageOne->getRecipient(), "messageContent" => $testMessageOne->getBody()],
                [ "messageSender" => $testMessageTwo->getSender(),"messageReciever" => $testMessageTwo->getRecipient(),"messageContent" => $testMessageTwo->getBody()]
            ]
        ];

        $this->mock(ShowAllMessagesService::class)->method('listMessagesByRecipient')->willReturn($testMessages);

        $request = $this->createJsonRequest('GET',"/getMessages/{$testRecipientId}");
        $result = $this->app->handle($request);
        $this->assertJsonData($result, $expectedResult);
    }
}