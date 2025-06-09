<?php

declare(strict_types=1);

namespace Src\Payment\Domain\ValueObject;

use Src\Payment\Domain\ValueObject\PaymentSessionId;
use Src\Payment\Domain\ValueObject\PaymentToken;
use Src\Payment\Domain\ValueObject\PaymentId;
use Src\Payment\Domain\ValueObject\PaymentMonto;
use Src\Payment\Domain\ValueObject\PaymentEstado;
use Src\Client\Domain\Entity\Client;

final class Payment
{
    private PaymentId $id;
    private PaymentSessionId $sessionId;
    private PaymentToken $token;
    private PaymentMonto $monto;
    private PaymentEstado $estado;
    private Client $client;

    public function __construct(
        PaymentId $id,
        PaymentSessionId $sessionId,
        PaymentToken $token,
        PaymentMonto $monto,
        PaymentEstado $estado,
        Client $client
    ) {
        $this->id = $id;
        $this->sessionId = $sessionId;
        $this->token = $token;
        $this->monto = $monto;
        $this->estado = $estado;
        $this->client = $client;
    }

    public function id(): PaymentId
    {
        return $this->id;
    }

    public function sessionId(): PaymentSessionId
    {
        return $this->sessionId;
    }

    public function token(): PaymentToken
    {
        return $this->token;
    }

    public function monto(): PaymentMonto
    {
        return $this->monto;
    }

    public function estado(): PaymentEstado
    {
        return $this->estado;
    }

    public function client(): Client
    {
        return $this->client;
    }
}
