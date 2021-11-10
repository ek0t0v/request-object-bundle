# RequestObjectBundle

This is an extremely simple bundle, based on **ArgumentValueResolver** to create a request object and subscribing to **ControllerArgumentsEvent** where the request object is validated.

> Request objects are not designed for any complex data structures (for example, nested objects), you can use ordinary fields and collections without any problems, this is usually enough for most use cases. But it is possible that the bundle will improve in this direction in the future.

Install this package via composer:

```
composer require ek0t0v/request-object-bundle
```

Create request object like this:

```php
final class SomeRequestObject implements RequestObject
{
    /**
     * Don't set the type for the validator to work correctly.
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $foo;

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Choice(callback={"BarType", "getValues"})
     */
    private $bar;

    /**
     * @Assert\NotBlank
     * @Assert\Date
     */
    private $date;

    /**
     * @Assert\NotBlank
     * @Assert\All({
     *     @Assert\File(maxSize="2M", mimeTypes={"image/*"}),
     * })
     */
    private $images;
    
    /**
     * Fill the object properties "as is", there should not be any logic here,
     * only filling. Any exception here (e.g., incorrect json) will throw a
     * RequestParsingException.
     */
    public static function createFromRequest(Request $request): self
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $object = new self();

        $object->foo = $data['foo'] ?? '';
        $object->bar = $data['bar'] ?? '';
        $object->date = $data['date'] ?? '';
        $object->images = $request->files->all();

        return $object;
    }
    
    public  function foo(): int
    {
        return $this->foo;
    }
    
    /**
     * In the getter, you can convert the value to the desired object.
     */
    public  function bar(): BarType
    {
        return new BarType($this->bar);
    }
    
    public  function date(): \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->date);
    }
    
    public  function images(): array
    {
        return $this->files;
    }
}
```

Using in controller:

```php
/**
 * @Route("/", name="create", methods={"POST"})
 */
public function create(SomeRequestObject $request): Response
{
    $request->foo(); // <- Already valid!
}
```

A bundle can throw two types of exceptions - **RequestParsingException** and **ValidationException**. You can subscribe to them and implement the processing logic. An example of handling a ValidationException:

```php
final class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['onValidationException'],
            ],
        ];
    }
    
    public function onValidationException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if (!($e instanceof ValidationException)) {
            return;
        }

        $errors = [];

        foreach ($e->constraintViolationList() as $constraintViolation) {
            $errors[] = [
                'property' => $constraintViolation->getPropertyPath(),
                'message' => $constraintViolation->getMessage(),
            ];
        }

        $event->setResponse(new JsonResponse($errors, Response::HTTP_BAD_REQUEST));
    }
}
```
