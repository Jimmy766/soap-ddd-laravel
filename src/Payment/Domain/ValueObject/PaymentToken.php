<?php

declare(strict_types=1);

namespace Src\Payment\Domain\ValueObject;

final class PaymentToken
{
    private $value;

    public function __construct(string $token)
    {
        if (empty($token)) {
            throw new \InvalidArgumentException('Payment Token cannot be empty.');
        }
        $this->value = $token;
    }

    public function value(): string
    {
        return $this->value;
    }
}

