<?php

declare(strict_types=1);

namespace Src\Payment\Domain\ValueObject;

final class PaymentId
{
    private $value;

    public function __construct(int $id)
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('Payment ID must be a positive integer.');
        }
        $this->value = $id;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
