<?php

declare(strict_types=1);

namespace Ek0t0v\RequestObjectBundle\Tests;

use Ek0t0v\RequestObjectBundle\Exception\ValidationException;
use Ek0t0v\RequestObjectBundle\Tests\App\AppKernel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class BundleTest extends TestCase
{
    private AppKernel $kernel;

    public function setUp(): void
    {
        $kernel = new AppKernel('test', true);

        $kernel->boot();

        $this->kernel = $kernel;
    }

    public function testOkWithValidData(): void
    {
        $request = Request::create('/', 'POST', [], [], [], [], json_encode([
            'name' => [
                'first' => 'John',
                'last' => 'Doe',
            ],
            'email' => 'john@doe.com',
            'password' => 'secret',
            'age' => 20,
            'array' => [0, 1, 2, 3],
        ], JSON_THROW_ON_ERROR, 512));

        $response = $this->kernel->handle($request);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testThrowsValidationExceptionWithInvalidData(): void
    {
        $request = Request::create('/', 'POST', [], [], [], [], json_encode([
            'name' => [
                'first' => '',
                'last' => 'Doe',
            ],
            'email' => 'invalid email',
            'password' => '?',
            'age' => 20,
            'array' => [0, 1, 2, 3],
        ], JSON_THROW_ON_ERROR, 512));

        $isExceptionThrown = false;

        try {
            $this->kernel->handle($request);
        } catch (\Throwable $e) {
            $isExceptionThrown = true;

            self::assertInstanceOf(ValidationException::class, $e);
        }

        self::assertTrue($isExceptionThrown);
    }
}
