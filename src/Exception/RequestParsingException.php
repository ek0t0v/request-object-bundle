<?php

declare(strict_types=1);

namespace Orlan\RequestObject\Exception;

final class RequestParsingException extends \Exception
{
    public function __construct(string $message = 'Failed to parse request.')
    {
        parent::__construct($message);
    }
}
