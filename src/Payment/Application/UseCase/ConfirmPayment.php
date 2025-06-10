<?php

namespace Src\Payment\Application\UseCase;

use Src\Payment\Domain\Repository\PaymentRepository;
use Src\Wallet\Domain\Repository\WalletRepository;
use Src\Payment\Domain\Entity\Payment;
use Src\Payment\Domain\ValueObject\PaymentId;
use Src\Payment\Domain\ValueObject\PaymentSessionId;
use Src\Payment\Domain\ValueObject\PaymentToken;
use Src\Payment\Domain\ValueObject\PaymentEstado;
use Src\Wallet\Domain\ValueObject\WalletSaldo;


final class ConfirmPayment
{
    private PaymentRepository $paymentRepository;
    private WalletRepository $walletRepository;

    public function __construct(PaymentRepository $paymentRepository, WalletRepository $walletRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->walletRepository = $walletRepository;
    }

    public function __invoke(PaymentSessionId $sessionId, PaymentToken $token): void
    {
        $payment = $this->paymentRepository->findByCriteria($sessionId, $token);
        if (!$payment) {
            throw new \Exception("Payment not found for session ID: " . $sessionId->value() . " and token: " . $token->value());
        }

        $wallet = $this->walletRepository->findByClientId($payment->client()->id());
        if (!$wallet) {
            throw new \Exception("Wallet not found for client ID: " . $payment->client()->id()->value());
        }
        if ($wallet->saldo()->value() < $payment->monto()->value()) {
            throw new \Exception("Insufficient funds in wallet for payment ID: " . $payment->id()->value());
        }
        $saldo = $wallet->saldo()->value() - $payment->monto()->value();
        $this->walletRepository->update(
            new Wallet(
                $wallet->id(),
                new WalletSaldo($saldo),
                $wallet->client()
            )
        );

        $this->paymentRepository->update(
            new Payment(
                $payment->id(),
                $payment->sessionId(),
                $payment->token(),
                $payment->monto(),
                new PaymentEstado('confirmado'),
                $payment->client()
            )
        );
    }
}
