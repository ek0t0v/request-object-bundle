<?php

declare(strict_types=1);

namespace Ek0t0v\RequestObjectBundle;

use Symfony\Component\HttpFoundation\Request;

interface RequestObject
{
    /**
     * @throws \Throwable
     */
    public static function createFromRequest(Request $request): self;
}
