<?php

declare(strict_types=1);

namespace Ek0t0v\RequestObjectBundle\Tests\RequestObject;

use Ek0t0v\RequestObjectBundle\RequestObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class SomeRequestObject implements RequestObject
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $firstName;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $lastName;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Email()
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("int")
     */
    private $age;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("array")
     */
    private $array;

    public static function createFromRequest(Request $request): RequestObject
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $object = new self();

        $object->firstName = $data['name']['first'] ?? '';
        $object->lastName = $data['name']['last'] ?? '';
        $object->email = $data['email'] ?? '';
        $object->password = $data['password'] ?? '';
        $object->age = $data['age'] ?? '';
        $object->array = $data['array'] ?? '';

        return $object;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function age(): int
    {
        return $this->age;
    }

    public function array(): array
    {
        return $this->array;
    }
}
