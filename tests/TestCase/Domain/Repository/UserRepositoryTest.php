<?php

namespace App\Test\TestCase\Domain\Repository;

use App\Test\AppTestTrait;
use App\Domain\Data\UserData;
use App\Domain\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase {
    use AppTestTrait;

    /**
     * @return void
     */
    public function testInsertUser(): void {
        $testUserId = 1;

        $username = "ali";

        $this->mock(UserRepository::class)->method('insertUser')->willReturn($testUserId);

        $repository = $this->container->get(UserRepository::class);

        $result = $repository->insertUser($username);

        $this->assertSame($testUserId, $result);
    }
}