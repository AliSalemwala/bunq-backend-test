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
     * @param string
     * @param string
     * @param string
     */
    public function __construct(string $sender, string $recipient, string $body) {
        $this->id = $id;
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function jsonSerialize() {
        return [
            'sender' => $this->sender,
            'recipient' => $this->recipient,
            'body' => $this->body
        ];
    }
}