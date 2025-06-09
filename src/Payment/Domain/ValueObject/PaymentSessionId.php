<?php

declare(strict_types=1);

namespace Src\Payment\Domain\ValueObject;

final class PaymentSessionId
{
    private $value;

    public function __construct(string $sessionId)
    {
        if (empty($sessionId)) {
            throw new \InvalidArgumentException('Payment Session ID cannot be empty.');
        }
        $this->value = $sessionId;
    }

    public function value(): string
    {
        return $this->value;
    }
}

