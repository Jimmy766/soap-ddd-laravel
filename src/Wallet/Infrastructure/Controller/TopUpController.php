<?php

namespace Src\Wallet\Infrastructure\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Src\Wallet\Application\UseCase\TopUpWallet;
use Src\Wallet\Domain\ValueObject\WalletSaldo;
use Src\Client\Domain\ValueObject\ClientDocumento;
use Src\Client\Domain\ValueObject\ClientCelular;

final class TopUpController
{
    private TopUpWallet $useCase;

    public function __construct(TopUpWallet $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $document = new ClientDocumento($request->input('documento'));
            $phone = new ClientCelular($request->input('celular'));
            $amount = new WalletSaldo($request->input('monto'));

            $this->useCase->__invoke($document, $phone, $amount);

            return response()->json(['message' => 'Wallet topped up successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
