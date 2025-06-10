<?php

namespace Src\Payment\Infrastructure\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Src\Payment\Application\UseCase\DoPay;
use Src\Payment\Domain\ValueObject\PaymentAmount;
use Src\Client\Domain\ValueObject\ClientDocumento;
use Src\Client\Domain\ValueObject\ClientCelular;

final class DoPayController
{
    private DoPay $useCase;

    public function __construct(DoPay $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $document = new ClientDocumento($request->input('documento'));
            $phone = new ClientCelular($request->input('celular'));
            $amount = new PaymentAmount($request->input('monto'));

            $this->useCase->__invoke($document, $phone, $amount);

            return response()->json(['message' => 'Payment processed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
