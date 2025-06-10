<?php

namespace Src\Wallet\Application\UseCase;

use Src\Wallet\Domain\Repository\WalletRepository;
use Src\Client\Domain\Repository\ClientRepository;
use Src\Wallet\Domain\Entity\Wallet;
use Src\Wallet\Domain\ValueObject\WalletId;
use Src\Client\Domain\ValueObject\ClientDocumento;
use Src\Client\Domain\ValueObject\ClientCelular;
use Src\Client\Domain\Entity\Client;

final class CheckWallet
{
    private WalletRepository $walletRepository;
    private ClientRepository $clientRepository;

    public function __construct(WalletRepository $walletRepository, ClientRepository $clientRepository)
    {
        $this->walletRepository = $walletRepository;
        $this->clientRepository = $clientRepository;
    }

    public function __invoke(ClientDocumento $document, ClientCelular $phone): ?Wallet
    {
        $client = $this->clientRepository->findByCriteria($document, $phone);
        if (!$client) {
            throw new \Exception("Client not found for document: " . $document->value() . " and phone: " . $phone->value());
        }
        $wallet = $this->walletRepository->findByClientId($client->id());
        if (!$wallet) {
            throw new \Exception("Wallet not found for client ID: " . $client->id()->value());
        }
        return $wallet;
    }
}
