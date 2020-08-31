<?php

namespace App\Action;

use App\Response\Payload;
use App\Domain\Service\BaseService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class BaseAction {
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var array
     */
    protected $args;

    /**
     * @var BaseService
     */
    protected $service;

    /**
     * @param BaseService
     */
    public function __construct(BaseService $service) {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $args): Response {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
        
        return $this->action();
    }

    /**
     * @return Response
     */
    abstract protected function action(): Response;

    /**
     * @param array|object|null
     * @return Response
     */
    protected function sendResponse($data = null): Response {
        $json = json_encode(new Payload($data));
        $this->response->getBody()->write($json);

        return $this->response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
    }
}
