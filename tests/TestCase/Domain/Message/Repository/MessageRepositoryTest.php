<?php

namespace App\Test\TestCase\Domain\Message\Repository;

use App\Test\AppTestTrait;
use App\Domain\Message\Data\MessageData;
use App\Domain\Message\Repository\MessageRepository;
use PHPUnit\Framework\TestCase;

class MessageRepositoryTest extends TestCase {
    use AppTestTrait;

    /**
     * @return void
     */
    public function testInsertMessage(): void {
        $sender = 1;
        
        $message = ['messageSender' => "Jack", 
                    'messageReciever' => "John",
                     'messageContent' => "Hello Kind Sir"];

        $this->mock(MessageRepository::class)->method('insertMessage')->willReturn(1);

        $repository = $this->container->get(MessageRepository::class);

        $result = $repository->insertMessage($message);

        $this->assertSame($sender, $result);
    }

    /**
     * @return void
     */
    public function testSelectMessagesByRecipient(): void {
        $testRecipientId = 2;
        $testMessageOne = new MessageData(1, "Jack", "John", "Hello Kind Sir");
        $testMessageTwo = new MessageData(2, "Jack", "John", "How are you?");
        $testMessages = array($testMessageOne, $testMessageTwo);

        $this->mock(MessageRepository::class)->method('selectMessagesByRecipient')->willReturn($testMessages);

        $repository = $this->container->get(MessageRepository::class);

        $result = $repository->selectMessagesByRecipient($testRecipientId);

        $this->assertSame(2, count($result));
    }
}