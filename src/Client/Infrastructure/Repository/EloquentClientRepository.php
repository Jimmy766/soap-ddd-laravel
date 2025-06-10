<?php

declare(strict_types=1);

namespace Src\Client\Infrastructure\Repository;

use Src\Client\Domain\Repository\ClientRepository;
use Src\Client\Domain\ValueObject\ClientId;
use Src\Client\Domain\ValueObject\ClientEmail;
use Src\Client\Domain\Entity\Client;
use Src\Client\Domain\ValueObject\ClientDocumento;
use Src\Client\Domain\ValueObject\ClientCelular;
use App\Models\Cliente as EloquentClient;

class EloquentClientRepository implements ClientRepository
{
    public function findById(ClientId $id): ?Client
    {
        $eloquentClient = EloquentClient::find($id->value());
        if (!$eloquentClient) {
            return null;
        }

        return new Client(
            new ClientId($eloquentClient->id),
            new ClientNombres($eloquentClient->nombres),
            new ClientDocumento($eloquentClient->documento),
            new ClientCelular($eloquentClient->celular),
            new ClientEmail($eloquentClient->email)
        );
    }

    public function findByEmail(ClientEmail $email): ?Client
    {
        $eloquentClient = EloquentClient::where('email', $email->value())->first();
        if (!$eloquentClient) {
            return null;
        }

        return new Client(
            new ClientId($eloquentClient->id),
            new ClientNombres($eloquentClient->nombres),
            new ClientDocumento($eloquentClient->documento),
            new ClientCelular($eloquentClient->celular),
            new ClientEmail($eloquentClient->email)
        );
    }

    public function findByCriteria(ClientDocumento $document, ClientCelular $phone): ? Client{

        $eloquentClient = EloquentClient::where('documento', $document->value())
            ->where('celular', $phone->value())
            ->first();
        
        if (!$eloquentClient) {
            return null;
        }

        return new Client(
            new ClientId($eloquentClient->id),
            new ClientNombres($eloquentClient->nombres),
            new ClientDocumento($eloquentClient->documento),
            new ClientCelular($eloquentClient->celular),
            new ClientEmail($eloquentClient->email)
        );
    }
    
    public function save(Client $client): void
    {
        $eloquentClient = new EloquentClient();
        $eloquentClient->nombres = $client->nombres()->value();
        $eloquentClient->documento = $client->documento()->value();
        $eloquentClient->celular = $client->celular()->value();
        $eloquentClient->email = $client->email()->value();
        $eloquentClient->save();
    }

    public function update(Client $client): void
    {
        // TODO implement update logic
    }

    public function delete(ClientId $id): void
    {
        // TODO implement delete logic
    }
}
