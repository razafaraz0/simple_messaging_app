<?php

namespace App\Test\TestCase\Action;

use App\Test\AppTestTrait;
use App\Action\AddUserAction;
use App\Domain\User\Data\UserData;
use App\Domain\User\Service\AddUserService;
use PHPUnit\Framework\TestCase;

class AddUserActionTest extends TestCase {
    use AppTestTrait;

    //Checks if the 2 arrays are the same, while ignoring the order the element in a row
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
    public function testAddUserAction(): void {
        $testUserId = 1;
        $testUser = new UserData($testUserId, 'john');
        $expectedResult = [
            "data" => [
                "userID" => $testUserId,
                "userName" => 'john'
            ]
        ];

        $this->mock(AddUserService::class)->method('createUser')->willReturn($testUser);

        $request = $this->createJsonRequest('POST','/user',['userName' => 'john']);

        $result = (array) $this->app->handle($request);
        $this->assertTrue($this->similar_arrays($result, $expectedResult));
        
    }
}