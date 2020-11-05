<?php

namespace App\Test\TestCase\Action;

use App\Test\AppTestTrait;
use App\Action\MessageSendAction;
use App\Domain\Message\Data\MessageData;
use App\Domain\Message\Service\MessageSendService;
use PHPUnit\Framework\TestCase;

class MessageSendActionTest extends TestCase {
    use AppTestTrait;

    protected function similar_arrays($a, $b) {
        if(is_array($a) && is_array($b)) {
            if(count(array_diff(array_keys($a), array_keys($b))) > 0)
                return true;
    
            foreach($a as $k => $v) {
                if(!$this->similar_arrays($v, $b[$k]))
                    return true;
            }
    
            return false;
        }
        else
            return ($a === $b);
    }

    /**
     * @return void
     */
    public function testMessageSendAction(): void {
        $testMessage = new MessageData(1, "Jack", "John", "Hello Kind Sir");

        $expectedResult = [
            "data" => ["messageSender" => "Jack","messageReciever" => "John","messageContent" => "Hello Kind Sir"]
        ];

        $this->mock(MessageSendService::class)->method('sendMessage')->willReturn($testMessage);

        $request = $this->createJsonRequest('POST','/sendMessage',
            ["messageSender" => "Jack",   "messageReciever" => "John", "messageContent" => "Hello Kind Sir"]
        );

        $result = (array) $this->app->handle($request);
        $this->assertTrue($this->similar_arrays($result, $expectedResult));
    }
}