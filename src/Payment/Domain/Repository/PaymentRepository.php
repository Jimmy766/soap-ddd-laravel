<?php

namespace Src\Payment\Domain\Repository;
use Src\Payment\Domain\ValueObject\PaymentId;
use Src\Payment\Domain\Entity\Payment;

interface PaymentRepository
{
    public function findById(PaymentId $id): ?Payment;
    public function save(Payment $payment): void;
    public function update(Payment $payment): void;
    public function delete(PaymentId $id): void;
}
