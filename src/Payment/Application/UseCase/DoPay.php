<?php

namespace Src\Payment\Application\UseCase;

use Src\Payment\Domain\Repository\PaymentRepository;
use Src\Payment\Domain\Entity\Payment;
use Src\Payment\Domain\ValueObject\PaymentMonto;
use Src\Payment\Domain\ValueObject\PaymentId;
use Src\Payment\Domain\ValueObject\PaymentSessionId;
use Src\Payment\Domain\ValueObject\PaymentToken;
use Src\Payment\Domain\ValueObject\PaymentEstado;
use Src\Wallet\Domain\Repository\WalletRepository;
use Src\Wallet\Domain\ValueObject\WalletSaldo;
use Src\Wallet\Domain\ValueObject\WalletId;
use Src\Client\Domain\ValueObject\ClientId;
use Src\Client\Domain\ValueObject\ClientDocumento;
use Src\Client\Domain\ValueObject\ClientCelular;
use Src\Client\Domain\Repository\ClientRepository;

final class DoPay
{
    private PaymentRepository $paymentRepository;
    private WalletRepository $walletRepository;
    private ClientRepository $clientRepository;

    public function __construct(
        PaymentRepository $paymentRepository,
        WalletRepository $walletRepository,
        ClientRepository $clientRepository
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->walletRepository = $walletRepository;
        $this->clientRepository = $clientRepository;
    }

    public function __invoke(ClientDocumento $document, ClientCelular $phone, PaymentMonto $amount): void
    {
        $client = $this->clientRepository->findByCriteria($document, $phone);
        if (!$client) {
            throw new \Exception("Client not found for document: " . $document->value() . " and phone: " . $phone->value());
        }
        $wallet = $this->walletRepository->findByClientId($client->id());
        if (!$wallet) {
            throw new \Exception("Wallet not found for client ID: " . $client->id()->value());
        }
        if ($wallet->saldo()->value() < $amount->value()) {
            throw new \Exception("Insufficient funds in wallet.");
        }
        $sesionId = new PaymentSessionId(Str::uuid());
        $token = new PaymentToken(Str::uuid());
        $payment = new Payment(
            new PaymentId(1),
            $sesionId,
            $token,
            $amount,
            new PaymentEstado('pendiente'),
            $wallet->client()
        );

        $this->paymentRepository->save($payment);
    }

}
