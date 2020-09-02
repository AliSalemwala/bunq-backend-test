<?php

namespace App\Test\TestCase\Action;

use App\Test\AppTestTrait;
use App\Action\SendMessageAction;
use App\Domain\Data\MessageData;
use App\Domain\Service\MessageService;
use PHPUnit\Framework\TestCase;

class SendMessageActionTest extends TestCase {
    use AppTestTrait;

    /**
     * @return void
     */
    public function testSendMessageAction(): void {
        $testMessageId = 1;
        $testSender = 1;
        $testRecipient = 2;
        $testBody = "Hi";

        $testMessage = new MessageData($testMessageId, $testSender, $testRecipient, $testBody);

        $expectedResult = [
            "data" => [
                "sender" => "{$testSender}",
                "recipient" => "{$testRecipient}",
                "body" => $testBody
            ]
        ];

        $this->mock(MessageService::class)->method('sendMessage')->willReturn($testMessage);

        $request = $this->createJsonRequest(
            'POST',
            '/message',
            [
                "sender" => $testSender,
                "recipient" => $testRecipient,
                "body" => $testBody
            ]
        );

        $result = $this->app->handle($request);

        $this->assertJsonData($result, $expectedResult);
    }
}