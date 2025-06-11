<?php

namespace Src\Payment\Infrastructure\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Src\Payment\Application\UseCase\DoPay;
use Src\Payment\Domain\ValueObject\PaymentMonto;
use Src\Client\Domain\ValueObject\ClientDocumento;
use Src\Client\Domain\ValueObject\ClientCelular;
use App\Http\Controllers\SoapBaseController;

final class DoPayController extends SoapBaseController
{
    private DoPay $useCase;

    public function __construct(DoPay $useCase)
    {
        $this->uri = 'http://localhost/soap/payment/dopay';
        $this->useCase = $useCase;
    }

    public function dopay($documento, $celular, $monto)
    {
        try {
            $document = new ClientDocumento($documento);
            $phone = new ClientCelular($celular);
            $amount = new PaymentMonto($monto);

            $this->useCase->__invoke($document, $phone, $amount);

            return $this->response(true, '00', 'Payment processed successfully');
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }
}
