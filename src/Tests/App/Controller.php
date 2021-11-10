<?php

declare(strict_types=1);

namespace Ek0t0v\RequestObjectBundle\Tests\App;

use Ek0t0v\RequestObjectBundle\Tests\RequestObject\SomeRequestObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class Controller extends AbstractController
{
    /**
     * @Route("/", name="action", methods={"POST"})
     */
    public function action(SomeRequestObject $request): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_CREATED);
    }
}
