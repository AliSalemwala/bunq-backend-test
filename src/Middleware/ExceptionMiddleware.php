<?php

namespace App\Middleware;

use PDO;
use Exception;
use App\Response\ErrorPayload;
use Slim\Exception\HttpException;
use Slim\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;

final class ExceptionMiddleware implements MiddlewareInterface {
    /**
     * @param Request
     * @param Handler
     * @return ResponseInterface
     */
    public function process (Request $request, Handler $handler): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (HttpException $httpException) {

            $description = $httpException->getMessage();
            $statusCode = $httpException->getCode();
            $errorType;

            switch ($statusCode) {
                case 400:
                    $errorType = 'Bad Request';
                break;
                case 401:
                    $errorType = 'Unauthorized';
                break;
                case 403:
                    $errorType = 'Insufficient Privileges';
                break;
                case 404:
                    $errorType = 'Resource Not Found';
                break;
                case 405:
                    $errorType = 'Not Allowed';
                break;
                case 501:
                    $errorType = 'Not Implemented';
                break;
                default: $errorType = 'Unknown HTTP Exception';
            }
            
            return $this->sendError($errorType, $description, $statusCode);

        } catch (PDOException $pdoException) {

            return sendError('Database Exception', $pdoException->getMessage());

        } catch (Exception $exception) {

            $description = $exception->getMessage();
            $statusCode = $exception->getCode();
            $errorType;

            switch ($statusCode) {
                case 500:
                    $errorType = 'Incorrect Parameters';
                break;
                default: $errorType = 'Unknown Exception';
            }

            return $this->sendError($errorType, $description);
        }
    }

    /**
     * @param array|object|null
     * @param string
     * @param int
     * @return Response
     */
    protected function sendError($errorType, $error = null, $statusCode = 500): Response {
        $json = json_encode(new ErrorPayload($errorType, $error));
        $response = new Response();
        $response->getBody()->write($json);

        return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus($statusCode);
    }
}