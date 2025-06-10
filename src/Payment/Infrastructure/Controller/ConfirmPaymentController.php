<?php

namespace Src\Payment\Infrastructure\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Src\Payment\Application\UseCase\ConfirmPayment;
use Src\Payment\Domain\ValueObject\PaymentSessionId;
use Src\Payment\Domain\ValueObject\PaymentToken;

final class ConfirmPaymentController
{
    private ConfirmPayment $useCase;

    public function __construct(ConfirmPayment $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $sessionId = new PaymentSessionId($request->input('session_id'));
            $token = new PaymentToken($request->input('token'));

            $this->useCase->__invoke($sessionId, $token);

            return response()->json(['message' => 'Payment confirmed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
