<?php

declare(strict_types=1);
namespace Src\Client\Domain\ValueObject;

final class ClientEmail
{
    private $value;

    public function __construct(string $email)
    {
        if (empty($email)) {
            throw new \InvalidArgumentException('Client email must be a non-empty string.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email format.');
        }
        $this->value = $email;
    }

    public function value(): string
    {
        return $this->value;
    }
}
