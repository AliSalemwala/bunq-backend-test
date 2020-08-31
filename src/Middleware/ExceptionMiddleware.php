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
    public function process (Request $request, Handler $handler): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (HttpException $httpException) {

            $description = $httpException->getMessage();
            $statusCode = $httpException->getCode();
            $type;

            switch ($statusCode) {
                case 400:
                    $type = 'Bad Request';
                break;
                case 401:
                    $type = 'Unauthorized';
                break;
                case 403:
                    $type = 'Insufficient Privileges';
                break;
                case 404:
                    $type = 'Resource Not Found';
                break;
                case 405:
                    $type = 'Not Allowed';
                break;
                case 501:
                    $type = 'Not Implemented';
                break;
                default: $type = 'Unknown HTTP Exception';
            }
            
            return $this->sendError($type, $description, $statusCode);

        } catch (PDOException $pdoException) {

            return sendError('Database Exception', $pdoException->getMessage());

        } catch (Exception $exception) {

            $description = $exception->getMessage();
            $statusCode = $exception->getCode();
            $type;

            switch ($statusCode) {
                case 500:
                    $type = 'Incorrect Parameters';
                break;
                default: $type = 'Unknown Exception';
            }

            return $this->sendError($type, $description);
        }
    }

    /**
     * @param array|object|null
     * @return Response
     */
    protected function sendError($type, $error = null, $statusCode = 500): Response {
        $json = json_encode(new ErrorPayload($type, $error));
        $response = new Response();
        $response->getBody()->write($json);

        return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus($statusCode);
    }
}