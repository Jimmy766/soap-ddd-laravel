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

final class CreateClientController
{
    private CreateClient $useCase;

    public function __construct(CreateClient $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $client = new Client(
                new ClientId($request->input('id')),
                new ClientNombres($request->input('nombres')),
                new ClientDocumento($request->input('documento')),
                new ClientCelular($request->input('celular')),
                new ClientEmail($request->input('email'))
            );

            $this->useCase->__invoke($client);

            return response()->json(['message' => 'Client created successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}