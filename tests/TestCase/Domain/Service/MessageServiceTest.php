<?php

namespace App\Test\TestCase\Domain\Service;

use Exception;
use App\Test\AppTestTrait;
use App\Domain\Data\MessageData;
use App\Domain\Service\MessageService;
use App\Domain\Repository\MessageRepository;
use PHPUnit\Framework\TestCase;

class MessageServiceTest extends TestCase {
    use AppTestTrait;

    /**
     * @return void
     */
    public function testListMessagesByRecipient(): void {
        $testId = 1;
        $testSender = 1;
        $testRecipient = 2;
        $testBody = 'testMessageOne';
        $testMessageOne = new MessageData($testId, $testSender, $testRecipient, $testBody);
        $testMessages = array();
        array_push($testMessages, $testMessageOne);

        $this->mock(MessageRepository::class)->method('selectMessagesByRecipient')->willReturn(
            array(
                0 => array(
                    'id' => $testId,
                    'sender' => "{$testSender}",
                    'recipient' => "{$testRecipient}",
                    'body' => $testBody)
                )
        );

        $service = $this->container->get(MessageService::class);

        $responseMessages = $service->listMessagesByRecipient($testRecipient);

        $this->assertSame($responseMessages[0]->getSender(), "{$testSender}");

        $this->assertSame($responseMessages[0]->getRecipient(), "{$testRecipient}");

        $this->assertSame($responseMessages[0]->getBody(), $testBody);
    }

    /**
     * @return void
     */
    public function testSendMessage(): void {
        $sender = 1;
        $recipient = 2;
        $body = 'Hi';

        $this->mock(MessageRepository::class)->method('insertMessage')->willReturn(1);

        $service = $this->container->get(MessageService::class);

        $requestBody = [
            "sender" => $sender,
            "recipient" => $recipient,
            "body" => $body
        ];

        $responseMessage = $service->sendMessage($requestBody);

        $this->assertSame($responseMessage->getSender(), "{$sender}");

        $this->assertSame($responseMessage->getRecipient(), "{$recipient}");

        $this->assertSame($responseMessage->getBody(), $body);
    }

    /**
     * @return void
     */
    public function testMissingSenderParameterException(): void {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage("Could not find parameter `sender`. Please check your input");

        $service = $this->container->get(MessageService::class);

        $request = ["recipient" => 2, "body" => "testMessage"];

        $responseMessage = $service->sendMessage($request);
    }

    /**
     * @return void
     */
    public function testMissingRecipientParameterException(): void {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage("Could not find parameter `recipient`. Please check your input");

        $service = $this->container->get(MessageService::class);

        $request = ["sender" => 2, "body" => "testMessage"];

        $responseMessage = $service->sendMessage($request);
    }

    /**
     * @return void
     */
    public function testMissingBodyParameterException(): void {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage("Could not find parameter `body`. Please check your input");

        $service = $this->container->get(MessageService::class);

        $request = ["sender" => 1, "recipient" => 2];

        $responseMessage = $service->sendMessage($request);
    }
}