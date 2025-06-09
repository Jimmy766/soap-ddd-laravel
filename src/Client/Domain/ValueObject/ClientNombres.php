<?php

declare(strict_types=1);
namespace Src\Client\Domain\ValueObject;

final class ClientNombres
{
    private $value;

    public function __construct(string $nombres)
    {
        if (empty($nombres)) {
            throw new \InvalidArgumentException('Client names cannot be empty.');
        }
        $this->value = $nombres;
    }

    public function value(): int
    {
        return $this->value;
    }
}