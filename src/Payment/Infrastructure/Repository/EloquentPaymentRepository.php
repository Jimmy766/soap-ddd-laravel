<?php

namespace Src\Payment\Infrastructure\Repository;

use Src\Payment\Domain\Repository\PaymentRepository;
use Src\Payment\Domain\Entity\Payment;
use Src\Payment\Domain\ValueObject\PaymentId;
use Src\Payment\Domain\ValueObject\PaymentMonto;
use Src\Payment\Domain\ValueObject\PaymentSessionId;
use Src\Payment\Domain\ValueObject\PaymentToken;
use Src\Payment\Domain\ValueObject\PaymentEstado;
use App\Models\Pago as EloquentPayment;

class EloquentPaymentRepository implements PaymentRepository
{
    public function findById(PaymentId $id): ?Payment
    {
        $eloquentPayment = EloquentPayment::find($id->value());
        if( !$eloquentPayment) {
            return null;
        }
        return new Payment(
            new PaymentId($eloquentPayment->id),
            new PaymentMonto($eloquentPayment->monto),
            new PaymentSessionId($eloquentPayment->session_id),
            new PaymentToken($eloquentPayment->token),
            new PaymentEstado($eloquentPayment->estado)
        );
    }

    public function save(Payment $payment): void
    {
        EloquentPayment::create([
            'monto' => $payment->monto()->value(),
            'session_id' => $payment->sessionId()->value(),
            'token' => $payment->token()->value(),
            'estado' => $payment->estado()->value()
        ]);
    }

    public function update(Payment $payment): void
    {
        $eloquentPayment = EloquentPayment::find($payment->getId()->value());
        if ($eloquentPayment) {
            $eloquentPayment->update([
                'monto' => $payment->monto()->value(),
                'session_id' => $payment->sessionId()->value(),
                'token' => $payment->token()->value(),
                'estado' => $payment->estado()->value()
            ]);
        }
    }

    public function delete(PaymentId $id): void
    {
        EloquentPayment::destroy($id->value());
    }
}
