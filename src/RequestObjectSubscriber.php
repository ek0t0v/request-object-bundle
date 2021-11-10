<?php

declare(strict_types=1);

namespace Ek0t0v\RequestObjectBundle;

use Ek0t0v\RequestObjectBundle\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RequestObjectSubscriber implements EventSubscriberInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator) {
        $this->validator = $validator;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER_ARGUMENTS => [
                ['validate', -1],
            ],
        ];
    }

    /**
     * @throws ValidationException
     */
    public function validate(ControllerArgumentsEvent $event): void
    {
        $dto = null;

        foreach ($event->getArguments() as $argument) {
            if ($argument instanceof RequestObject) {
                $dto = $argument;

                break;
            }
        }

        if (!$dto) {
            return;
        }

        $violations = $this->validator->validate($dto);

        if (count($violations) > 0) {
            throw new ValidationException($violations);
        }
    }
}
