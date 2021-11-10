<?php

declare(strict_types=1);

namespace Ek0t0v\RequestObjectBundle\Exception;

final class RequestParsingException extends \Exception
{
    public function __construct(string $message = 'Failed to parse request.')
    {
        parent::__construct($message);
    }
}
