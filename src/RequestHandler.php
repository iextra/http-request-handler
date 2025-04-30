<?php

declare(strict_types=1);

namespace Extro\RequestHandler;

use Extro\RequestHandler\Contracts\FallbackRequestHandlerInterface;
use Extro\RequestHandler\Contracts\MiddlewareLoaderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SplQueue;

class RequestHandler implements RequestHandlerInterface
{
    private SplQueue $middlewares;
    private FallbackRequestHandlerInterface $fallbackHandler;

    public function __construct(
        MiddlewareLoaderInterface $middlewareLoader,
        FallbackRequestHandlerInterface $fallbackHandler
    ) {
        $this->fallbackHandler = $fallbackHandler;
        $this->middlewares = new SplQueue();

        foreach ($middlewareLoader->loadMiddlewareStack() as $middleware) {
            $this->middlewares->enqueue($middleware);
        }
    }

    public function add(MiddlewareInterface $middleware): void
    {
        $this->middlewares->enqueue($middleware);
    }

    public function addToStart(MiddlewareInterface $middleware): void
    {
        $this->middlewares->unshift($middleware);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->middlewares->isEmpty()) {
            return $this->fallbackHandler->handle($request);
        }

        /** @var MiddlewareInterface $middleware */
        $middleware = $this->middlewares->dequeue();

        return $middleware->process($request, $this);
    }
}
