<?php

declare(strict_types=1);
namespace Src\Client\Domain\ValueObject;

final class ClientCelular
{
    private $value;

    public function __construct(string $celular)
    {
        if( empty($celular)) {
            throw new \InvalidArgumentException('Client phone number must be a non-empty string.');
        }
        $this->value = $celular;
    }

    public function value(): int
    {
        return $this->value;
    }
}