<?php

declare(strict_types=1);

namespace Src\Payment\Domain\ValueObject;

final class PaymentMonto
{
    private $value;

    public function __construct(float $amount)
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Payment Amount must be a positive integer.');
        }
        $this->value = $amount;
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
