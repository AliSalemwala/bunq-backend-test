<?php

namespace App\Action;

use App\Action\BaseAction;
use App\Domain\Service\UserService;
use Psr\Http\Message\ResponseInterface as Response;

class CreateUserAction extends BaseAction {
    /**
     * @param UserService
     */
    public function __construct(UserService $userService) {
        $this->service = $userService;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response {
        $data = (array) $this->request->getParsedBody();
        $user = $this->service->createUser($data);
        return $this->sendResponse($user);
    }
}