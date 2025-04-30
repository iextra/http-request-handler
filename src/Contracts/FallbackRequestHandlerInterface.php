<?php

declare(strict_types=1);

namespace Extro\RequestHandler\Contracts;

use Psr\Http\Server\RequestHandlerInterface;

/**
 * Marker interface for fallback request handlers.
 *
 * This interface exists to provide a distinct DI container binding target
 * for fallback handlers that should be used when the middleware queue is exhausted.
 *
 * Implementations of this interface will be used as the final handler when:
 * 1. No middleware is registered in the pipeline
 * 2. All middleware delegates to the next handler
 *
 * Unlike regular RequestHandlerInterface implementations, this serves as:
 * - The ultimate fallback when no other handlers are available
 * - A configurable endpoint that can be swapped in DI configuration
 *
 * @see RequestHandlerInterface The base PSR-15 handler interface
 */
interface FallbackRequestHandlerInterface extends RequestHandlerInterface
{
}
