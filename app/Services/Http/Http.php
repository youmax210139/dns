<?php
namespace App\Services\Http;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * wrapper for guzzle http client
 */
class Http
{
    protected $client;
    protected $stack;

    public function __construct()
    {
        $this->stack = new HandlerStack();
        $this->stack->setHandler(new CurlHandler());
        $this->stack->push(Middleware::mapResponse(function (ResponseInterface $response) {
            return $this->mapResponse($response);
        }));
        $this->client = new Client([
            'allow_redirects' => true,
            'handler' => $this->stack,
            'timeout' => 10,
        ]);
    }

    protected function mapResponse(ResponseInterface $response)
    {
        $url = $response->getHeader('Location');
        return new HttpResponse(
            $response->getStatusCode(),
            $response->getReasonPhrase(),
            $response->getHeaders(),
            $response->getBody()
        );
    }

    protected function mapExceptionResponse(\Exception $e)
    {
        if ($e instanceof \GuzzleHttp\Exception\ConnectException) {
            $response = new HttpResponse(
                408,
                $e->getHandlerContext()['error']
            );
        } elseif (method_exists($e, 'hasResponse') && call_user_func($e, 'hasResponse')) {
            $response = new HttpResponse(
                call_user_func($e, 'getResponse')->getStatusCode(),
                call_user_func($e, 'getResponse')->getReasonPhrase()
            );
        } else {
            $response = new HttpResponse(
                408,
                $e->getMessage()
            );
        }
        return $response;
    }

    public function __call($method, $args)
    {
        try {
            $r = $this->client->$method(...$args);
            if ($r instanceof \GuzzleHttp\Promise\RejectedPromise) {
                $r = $r->then(null, function ($reason) {
                    return $this->mapExceptionResponse($reason);
                });
            }
            return $r;
        } catch (\Exception $e) {
            return $this->mapExceptionResponse($e);
        }
    }

}
