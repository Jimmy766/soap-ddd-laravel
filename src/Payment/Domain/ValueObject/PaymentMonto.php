<?php

declare(strict_types=1);

namespace Src\Payment\Domain\ValueObject;

final class PaymentMonto
{
    private $value;

    public function __construct(float $amount)
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Payment Amount must be a positive float.');
        }
        $this->value = $amount;
    }

    public function value(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
