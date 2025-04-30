<?php

declare(strict_types=1);

namespace Extro\RequestHandler\Contracts;

use Psr\Http\Server\MiddlewareInterface;

interface MiddlewareLoaderInterface
{
    /**
     * Loads middleware instances from the container in configured order
     *
     * @return iterable<MiddlewareInterface>
     */
    public function loadMiddlewareStack(): iterable;
}