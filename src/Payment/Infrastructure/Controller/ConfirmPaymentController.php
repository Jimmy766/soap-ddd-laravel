<?php

namespace Src\Payment\Infrastructure\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Src\Payment\Application\UseCase\ConfirmPayment;
use Src\Payment\Domain\ValueObject\PaymentSessionId;
use Src\Payment\Domain\ValueObject\PaymentToken;
use App\Http\Controllers\SoapBaseController;

final class ConfirmPaymentController extends SoapBaseController
{
    private ConfirmPayment $useCase;

    public function __construct(ConfirmPayment $useCase)
    {
        $this->uri = 'http://localhost/soap/payment/confirm';
        $this->useCase = $useCase;
    }

    public function confirm($sessionId, $token)
    {
        try {
            $sessionIdPayment = new PaymentSessionId($sessionId);
            $tokenPayment = new PaymentToken($token);

            $this->useCase->__invoke($sessionIdPayment, $tokenPayment);

            return $this->response(true, '00', 'Payment confirmed successfully');
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }
}
