<?php

declare(strict_types=1);

namespace Ek0t0v\RequestObjectBundle;

use Ek0t0v\RequestObjectBundle\DependencyInjection\RequestObjectExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class RequestObjectBundle extends Bundle
{
    public function getContainerExtension(): RequestObjectExtension
    {
        return new RequestObjectExtension();
    }
}
