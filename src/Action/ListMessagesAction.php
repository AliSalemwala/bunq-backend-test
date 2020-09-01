<?php

namespace App\Action;

use App\Action\BaseAction;
use App\Domain\Service\MessageService;
use Psr\Http\Message\ResponseInterface as Response;

class ListMessagesAction extends BaseAction {
    /**
     * @param MessageService
     */
    public function __construct(MessageService $messageService) {
        $this->service = $messageService;
    }
    /**
     * {@inheritdoc}
     */
    protected function action(): Response {
        $data = $this->args['recipient'];

        $messages = $this->service->listMessagesByRecipient($data);
        
        return $this->sendResponse($messages);
    }
}