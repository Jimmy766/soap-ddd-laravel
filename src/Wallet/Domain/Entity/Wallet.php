<?php

declare(strict_types=1);

namespace Src\Wallet\Domain\Entity;

use Src\Wallet\Domain\ValueObject\WalletId;
use Src\Wallet\Domain\ValueObject\WalletSaldo;
use Src\Client\Domain\Entity\Client;

final class Wallet
{
    private WalletId $id;
    private WalletSaldo $saldo;
    private Client $client;

    public function __construct(
        WalletId $id,
        WalletSaldo $saldo,
        Client $client
    ) {
        $this->id = $id;
        $this->saldo = $saldo;
        $this->client = $client;
    }

    public function id(): WalletId
    {
        return $this->id;
    }

    public function saldo(): WalletSaldo
    {
        return $this->saldo;
    }

    public function client(): Client
    {
        return $this->client;
    }
}
