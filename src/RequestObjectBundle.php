<?php

declare(strict_types=1);

namespace Orlan\RequestObject;

use Orlan\RequestObject\DependencyInjection\RequestObjectExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class RequestObjectBundle extends Bundle
{
    public function getContainerExtension(): RequestObjectExtension
    {
        return new RequestObjectExtension();
    }
}
