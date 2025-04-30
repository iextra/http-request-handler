<?php

declare(strict_types=1);

namespace Extro\RequestHandler\Contracts;

use Psr\Http\Server\MiddlewareInterface;

interface MiddlewareConfigInterface
{
    /**
     * Returns ordered list of middleware class names
     *
     * @return array<class-string<MiddlewareInterface>>
     */
    public function getMiddlewareClasses(): iterable;
}
