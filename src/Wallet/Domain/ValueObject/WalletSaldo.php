<?php

declare(strict_types=1);

namespace Src\Wallet\Domain\ValueObject;

final class WalletSaldo
{
    private $value;

    public function __construct(float $saldo)
    {
        if ($saldo < 0) {
            throw new \InvalidArgumentException('Wallet balance must be a non-negative float.');
        }
        $this->value = $saldo;
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
