<?php

declare(strict_types=1);
namespace Src\Client\Domain\ValueObject;

final class ClientDocumento
{
    private $value;

    public function __construct(string $documento)
    {
        if( empty($documento)) {
            throw new \InvalidArgumentException('Client document must be a non-empty string.');
        }
        $this->value = $documento;
    }

    public function value(): string
    {
        return $this->value;
    }
}
