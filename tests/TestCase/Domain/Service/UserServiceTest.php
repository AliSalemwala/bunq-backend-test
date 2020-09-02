<?php

namespace App\Test\TestCase\Domain\Service;

use Exception;
use App\Test\AppTestTrait;
use App\Domain\Data\UserData;
use App\Domain\Service\UserService;
use App\Domain\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase {
    use AppTestTrait;

    /**
     * @return void
     */
    public function testCreateUser(): void {
        $testUserId = 1;
        $testUsername = "ali";

        $this->mock(UserRepository::class)->method('insertUser')->willReturn($testUserId);

        $service = $this->container->get(UserService::class);

        $requestBody = ["username" => $testUsername];

        $responseUser = $service->createUser($requestBody);

        $this->assertSame($responseUser->getId(), $testUserId);

        $this->assertSame($responseUser->getUsername(), $testUsername);
    }

    /**
     * @return void
     */
    public function testMissingUsernameParameterException(): void {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage("Could not find parameter `username`. Please check your input");

        $service = $this->container->get(UserService::class);

        $responseUser = $service->createUser([]);
    }
}