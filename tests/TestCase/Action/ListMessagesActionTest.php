<?php

namespace App\Test\TestCase\Action;

use App\Test\AppTestTrait;
use App\Domain\Data\MessageData;
use App\Domain\Service\MessageService;
use PHPUnit\Framework\TestCase;

class ListMessagesActionTest extends TestCase {
    use AppTestTrait;

    /**
     * @return void
     */
    public function testListMessageAction(): void {
        $testRecipientId = 2;
        $testMessageOne = new MessageData(1, 1, $testRecipientId, "Test Message One");
        $testMessageTwo = new MessageData(2, 1, $testRecipientId, "Test Message Two");
        $testMessages = array($testMessageOne, $testMessageTwo);

        $expectedResult = [
            "data" =>[
                [
                    "sender" => $testMessageOne->getSender(),
                    "recipient" => $testMessageOne->getRecipient(),
                    "body" => $testMessageOne->getBody()
                ],
                [
                    "sender" => $testMessageTwo->getSender(),
                    "recipient" => $testMessageTwo->getRecipient(),
                    "body" => $testMessageTwo->getBody()
                ]
            ]
        ];

        $this->mock(MessageService::class)->method('listMessagesByRecipient')->willReturn($testMessages);

        $request = $this->createJsonRequest(
            'GET',
            "/messages/{$testRecipientId}"
        );

        $result = $this->app->handle($request);

        $this->assertJsonData($result, $expectedResult);
    }
}