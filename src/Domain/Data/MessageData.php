<?php

namespace App\Domain\Data;

use JsonSerializable;

class MessageData implements JsonSerializable {
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $sender;

    /**
     * @var string
     */
    private $recipient;

    /**
     * @var string
     */
    private $body;

    /**
     * @param int
     * @param string
     * @param string
     * @param string
     */
    public function __construct(int $id, string $sender, string $recipient, string $body) {
        $this->id = $id;
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getSender(): string {
        return $this->sender;
    }

    /**
     * @return string
     */
    public function getRecipient(): string {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function getBody(): string {
        return $this->body;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array {
        return [
            'sender' => $this->sender,
            'recipient' => $this->recipient,
            'body' => $this->body
        ];
    }
}