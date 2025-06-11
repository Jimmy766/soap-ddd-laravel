<?php

namespace Src\Client\Infrastructure\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Src\Client\Application\UseCase\CreateClient;
use Src\Client\Domain\Entity\Client;
use Src\Client\Domain\ValueObject\ClientId;
use Src\Client\Domain\ValueObject\ClientNombres;
use Src\Client\Domain\ValueObject\ClientDocumento;
use Src\Client\Domain\ValueObject\ClientCelular;
use Src\Client\Domain\ValueObject\ClientEmail;
use App\Http\Controllers\SoapBaseController;

class CreateClientController extends SoapBaseController
{
    private CreateClient $useCase;

    public function __construct(CreateClient $useCase)
    {
        $this->uri = 'http://localhost/soap/client';
        $this->useCase = $useCase;
    }

    public function create($nombres, $documento, $celular, $email)
    {
        try {
            $client = new Client(
                new ClientId(1),
                new ClientNombres($nombres),
                new ClientDocumento($documento),
                new ClientCelular($celular),
                new ClientEmail($email)
            );

            $this->useCase->__invoke($client);

            return $this->response(true, '00', 'Cliente creado correctamente');
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }
}