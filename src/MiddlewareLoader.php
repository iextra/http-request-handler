<?php

declare(strict_types=1);

namespace Extro\RequestHandler;

use Extro\RequestHandler\Contracts\MiddlewareConfigInterface;
use Extro\RequestHandler\Contracts\MiddlewareLoaderInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Server\MiddlewareInterface;
use RuntimeException;

readonly class MiddlewareLoader implements MiddlewareLoaderInterface
{
    public function __construct(
        private MiddlewareConfigInterface $config,
        private ContainerInterface $container,
    ) {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function loadMiddlewareStack(): iterable
    {
        $middlewares = [];

        foreach ($this->config->getMiddlewareClasses() as $middleware) {
            $loaded = $this->container->get($middleware);

            if (!$loaded instanceof MiddlewareInterface) {
                throw new RuntimeException(
                    sprintf(
                        'Middleware "%s" must implement %s',
                        is_object($loaded) ? get_class($loaded) : gettype($loaded),
                        MiddlewareInterface::class
                    )
                );
            }

            $middlewares[] = $loaded;
        }

        return $middlewares;
    }
}
