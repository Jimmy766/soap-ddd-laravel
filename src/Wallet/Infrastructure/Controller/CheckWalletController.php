<?php

namespace Str\Wallet\Infrastructure\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Str\Wallet\Application\UseCase\CheckWallet;
use Str\Client\Domain\ValueObject\ClientDocumento;
use Str\Client\Domain\ValueObject\ClientCelular;

final class CheckWalletController
{
    private CheckWallet $useCase;

    public function __construct(CheckWallet $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $document = new ClientDocumento($request->input('documento'));
            $phone = new ClientCelular($request->input('celular'));

            $wallet = $this->useCase->__invoke($document, $phone);

            return response()->json([
                'message' => 'Wallet checked successfully',
                'wallet' => $wallet
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
