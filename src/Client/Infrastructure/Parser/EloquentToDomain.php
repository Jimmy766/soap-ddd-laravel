<?php

namespace Src\Client\Infrastructure\Parser;

use Src\Client\Domain\ValueObject\ClientDocumento;
use Src\Client\Domain\ValueObject\ClientId;
use Src\Client\Domain\ValueObject\ClientNombres;
use Src\Client\Domain\ValueObject\ClientCelular;
use Src\Client\Domain\ValueObject\ClientEmail;
use Src\Client\Domain\Entity\Client;
use App\Models\Cliente as EloquentClient;

class EloquentToDomain
{
    public static function toDomain(EloquentClient $eloquentClient): Client
    {
        return new Client(
            new ClientId($eloquentClient->id),
            new ClientNombres($eloquentClient->nombres),
            new ClientDocumento($eloquentClient->documento),
            new ClientCelular($eloquentClient->celular),
            new ClientEmail($eloquentClient->email)
        );
    }
}
