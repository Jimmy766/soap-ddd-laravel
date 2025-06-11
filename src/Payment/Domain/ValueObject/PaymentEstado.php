<?php

declare(strict_types=1);

namespace Src\Payment\Domain\ValueObject;

final class PaymentEstado
{
    private $value;

    public function __construct(string $estado)
    {
        if (empty($estado)) {
            throw new \InvalidArgumentException('Payment Status cannot be empty.');
        }
        if (!in_array($estado, ['pendiente', 'confirmado', 'cancelado'], true)) {
            throw new \InvalidArgumentException('Invalid payment status provided.');
        }

        $this->value = $estado;
    }

    public function value(): string
    {
        return $this->value;
    }
}

