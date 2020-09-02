<?php

namespace App\Test\TestCase\Action;

use App\Test\AppTestTrait;
use App\Action\BaseAction;
use App\Domain\Data\UserData;
use App\Domain\Service\UserService;
use PHPUnit\Framework\TestCase;

class CreateUserActionTest extends TestCase {
    use AppTestTrait;

    /**
     * @return void
     */
    public function testCreateUserAction(): void {
        $testUserId = 1;
        $testUsername = 'ali';

        $testUser = new UserData($testUserId, $testUsername);
        
        $expectedResult = [
            "data" => [
                "id" => $testUserId,
                "username" => $testUsername
            ]
        ];

        $this->mock(UserService::class)->method('createUser')->willReturn($testUser);

        $request = $this->createJsonRequest(
            'POST',
            '/user',
            [
                'username' => $testUsername
            ]
        );

        $result = $this->app->handle($request);

        $this->assertJsonData($result, $expectedResult);
    }
}