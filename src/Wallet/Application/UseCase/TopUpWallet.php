<?php

namespace Src\Wallet\Application\UseCase;

use Src\Wallet\Domain\Repository\WalletRepository;
use Src\Wallet\Domain\Entity\Wallet;
use Src\Client\Domain\ValueObject\ClientId;
use Src\Wallet\Domain\ValueObject\WalletSaldo;
use Src\Client\Domain\Repository\ClientRepository;
use Src\Client\Domain\ValueObject\ClientDocumento;
use Src\Client\Domain\ValueObject\ClientCelular;

final class TopUpWallet
{
    private WalletRepository $walletRepository;
    private ClientRepository $clientRepository;

    public function __construct(WalletRepository $walletRepository, ClientRepository $clientRepository)
    {
        $this->walletRepository = $walletRepository;
        $this->clientRepository = $clientRepository;
    }

    public function __invoke(ClientDocumento $document, ClientCelular $phone, WalletSaldo $amount): void
    {
        $client = $this->clientRepository->findByCriteria($document, $phone);
        if (!$client) {
            throw new \Exception("Client not found for document: " . $document->value() . " and phone: " . $phone->value());
        }
        $wallet = $this->walletRepository->findByClientId($client->id());
        if(!wallet){
            $this->walletRepository->save(new Wallet(
                new WalletId(1),
                $amount,
                $client
            ));
            $wallet = $this->walletRepository->findByClientId($clientId);
        }
        $newSaldo = $wallet->saldo()->value() + $amount->value();
        
        $this->repository->update(
            new Wallet(
                $wallet->id(),
                new WalletSaldo($newSaldo),
                $wallet->client()
            )
        );
    }
}
