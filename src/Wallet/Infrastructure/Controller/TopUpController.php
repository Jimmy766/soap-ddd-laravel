<?php

namespace Src\Wallet\Infrastructure\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Src\Wallet\Application\UseCase\TopUpWallet;
use Src\Wallet\Domain\ValueObject\WalletSaldo;
use Src\Client\Domain\ValueObject\ClientDocumento;
use Src\Client\Domain\ValueObject\ClientCelular;
use App\Http\Controllers\SoapBaseController;

final class TopUpController extends SoapBaseController
{
    private TopUpWallet $useCase;

    public function __construct(TopUpWallet $useCase)
    {
        $this->uri = 'http://localhost/soap/wallet/topup';
        $this->useCase = $useCase;
    }

    public function topup($documento, $celular, $monto)
    {
        try {
            $document = new ClientDocumento($documento);
            $phone = new ClientCelular($celular);
            $amount = new WalletSaldo($monto);

            $this->useCase->__invoke($document, $phone, $amount);

            return $this->response(true, '00', 'Wallet topped up successfully');
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }
}
