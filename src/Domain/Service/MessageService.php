<?php

namespace App\Domain\Service;

use App\Domain\Service\BaseService;
use App\Domain\Repository\MessageRepository;

class MessageService extends BaseService {
    /**
     * @param MessageRepository
     */
    public function __construct(MessageRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @param array
     * @return MessageData
     */
    public function sendMessage(array $data): MessageData {
        $sender = $this->resolveParam ($data, 'sender');
        $recipient = $this->resolveParam ($data, 'recipient');
        $body = $this->resolveParam ($data, 'body');

        $messageId = $this->repository->insertMessage($sender, $recipient, $body);
        return new MessageData ($messageId, $sender, $recipient, $body);
    }

    /**
     * @param string
     * @return array
     */
    public function listMessagesByRecipient(string $recipient): array {
        $messages = $this->repository->selectMessagesByRecipient($recipient);
        
        $messagesList = array();

        foreach($messages as $message) {
            $sender = $message['sender'];
            $recipient = $message['recipient'];
            $body = $message['body'];

            array_push($messagesList, new MessageData ($sender, $recipient, $body));
        }

        return $messagesList;
    }
}