<?php

declare(strict_types=1);

namespace Orlan\RequestObject\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationException extends \Exception
{
    private ConstraintViolationListInterface $constraintViolationList;

    public function __construct(ConstraintViolationListInterface $constraintViolationList)
    {
        $this->constraintViolationList = $constraintViolationList;

        parent::__construct('Validation failed.');
    }

    public function constraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}
