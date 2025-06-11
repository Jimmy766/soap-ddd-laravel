<?php

declare(strict_types=1);

namespace Src\Wallet\Infrastructure\Repository;

use Src\Wallet\Domain\Repository\WalletRepository;
use Src\Wallet\Domain\Entity\Wallet;
use Src\Wallet\Domain\ValueObject\WalletId;
use Src\Wallet\Domain\ValueObject\WalletSaldo;
use Src\Client\Domain\Entity\Client;
use Src\Client\Domain\ValueObject\ClientId;
use App\Models\Billetera as EloquentWallet;
use Src\Client\Infrastructure\Parser\EloquentToDomain as EloquentClientParser;

class EloquentWalletRepository implements WalletRepository
{
    public function findById(WalletId $id): ?Wallet
    {
        $eloquentWallet = EloquentWallet::find($id->value());
        if (!$eloquentWallet) {
            return null;
        }


        return new Wallet(
            new WalletId($eloquentWallet->id),
            new WalletSaldo($eloquentWallet->saldo),
            EloquentClientParser::toDomain(
                $eloquentWallet->cliente
            )
        );
    }

    public function findByClientId(ClientId $clientId): ?Wallet
    {
        $eloquentWallet = EloquentWallet::where('cliente_id', $clientId->value())->first();
        if (!$eloquentWallet) {
            return null;
        }

        return new Wallet(
            new WalletId($eloquentWallet->id),
            new WalletSaldo($eloquentWallet->saldo),
            EloquentClientParser::toDomain(
                $eloquentWallet->cliente
            )
        );
    }

    public function save(Wallet $wallet): void
    {
        EloquentWallet::create([
            'saldo' => $wallet->saldo()->value(),
            'cliente_id' => $wallet->client()->id()->value()
        ]);
    }

    public function update(Wallet $wallet): void
    {
        $eloquentWallet = EloquentWallet::find($wallet->id()->value());
        if ($eloquentWallet) {
            $eloquentWallet->update([
                'saldo' => $wallet->saldo()->value()
            ]);
        }
    }

    public function delete(WalletId $id): void
    {
        EloquentWallet::destroy($id->value());
    }
}
