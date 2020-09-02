<?php

namespace App\Action;

use App\Action\BaseAction;
use App\Domain\Service\MessageService;
use Psr\Http\Message\ResponseInterface as Response;

class SendMessageAction extends BaseAction {
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
        $data = (array)$this->request->getParsedBody();

        $message = $this->service->sendMessage($data);
        
        return $this->sendResponse($message);
    }
}