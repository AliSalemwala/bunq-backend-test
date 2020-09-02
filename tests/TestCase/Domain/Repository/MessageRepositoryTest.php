<?php

namespace App\Test\TestCase\Domain\Repository;

use App\Test\AppTestTrait;
use App\Domain\Data\MessageData;
use App\Domain\Repository\MessageRepository;
use PHPUnit\Framework\TestCase;

class MessageRepositoryTest extends TestCase {
    use AppTestTrait;

    /**
     * @return void
     */
    public function testInsertMessage(): void {
        $sender = 1;

        $this->mock(MessageRepository::class)->method('insertMessage')->willReturn(1);

        $repository = $this->container->get(MessageRepository::class);

        $result = $repository->insertMessage(1, $sender, 2, 'Hi');

        $this->assertSame($sender, $result);
    }

    /**
     * @return void
     */
    public function testSelectMessagesByRecipient(): void {
        $testRecipientId = 2;
        $testMessageOne = new MessageData(1, 1, $testRecipientId, "Test Message One");
        $testMessageTwo = new MessageData(2, 1, $testRecipientId, "Test Message Two");
        $testMessages = array($testMessageOne, $testMessageTwo);

        $this->mock(MessageRepository::class)->method('selectMessagesByRecipient')->willReturn($testMessages);

        $repository = $this->container->get(MessageRepository::class);

        $result = $repository->selectMessagesByRecipient($testRecipientId);

        $this->assertSame(2, count($result));
    }
}