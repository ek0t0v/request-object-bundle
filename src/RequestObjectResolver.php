<?php

declare(strict_types=1);

namespace Ek0t0v\RequestObjectBundle;

use Ek0t0v\RequestObjectBundle\Exception\RequestParsingException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class RequestObjectResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_a($argument->getType(), RequestObject::class, true);
    }

    /**
     * @throws RequestParsingException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        $class = $argument->getType();

        /**
         * @var RequestObject $dto
         */
        $dto = new $class;

        try {
            $requestObject = $dto::createFromRequest($request);
        } catch (\Throwable $e) {
            throw new RequestParsingException();
        }

        yield $requestObject;
    }
}
