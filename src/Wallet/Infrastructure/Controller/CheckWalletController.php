<?php

namespace Src\Wallet\Infrastructure\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Src\Wallet\Application\UseCase\CheckWallet;
use Src\Client\Domain\ValueObject\ClientDocumento;
use Src\Client\Domain\ValueObject\ClientCelular;
use App\Http\Controllers\SoapBaseController;
use Illuminate\Support\Facades\Mail;

final class CheckWalletController extends SoapBaseController
{
    private CheckWallet $useCase;

    public function __construct(CheckWallet $useCase)
    {
        $this->uri = 'http://localhost/soap/wallet/check';
        $this->useCase = $useCase;
    }

    public function check($documento, $celular)
    {
        try {
            $document = new ClientDocumento($documento);
            $phone = new ClientCelular($celular);

            $wallet = $this->useCase->__invoke($document, $phone);

            return $this->response(
                true,
                '00',
                'Wallet checked successfully',
                [
                    'saldo' => $wallet->saldo()->value(),
                ]
            );
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }
}
