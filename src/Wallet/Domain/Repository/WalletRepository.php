<?php

declare(strict_types=1);

namespace Src\Wallet\Domain\Repository;
use Src\Wallet\Domain\ValueObject\WalletId;
use Src\Wallet\Domain\Entity\Wallet;
use Src\Client\Domain\ValueObject\ClientId;
interface WalletRepository
{
    public function findById(WalletId $id): ?Wallet;
    public function findByClientId(ClientId $clientId): ?Wallet;
    public function save(Wallet $wallet): void;
    public function update(Wallet $wallet): void;
    public function delete(WalletId $id): void;
}