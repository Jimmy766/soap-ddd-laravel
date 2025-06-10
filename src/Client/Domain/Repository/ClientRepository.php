<?php

declare(strict_types=1);

namespace Src\Client\Domain\Repository;

use Src\Client\Domain\ValueObject\ClientId;
use Src\Client\Domain\ValueObject\ClientEmail;
use Src\Client\Domain\Entity\Client;
use Src\Client\Domain\ValueObject\ClientDocumento;
use Src\Client\Domain\ValueObject\ClientCelular;

interface ClientRepository
{
    public function findById(ClientId $id): ? Client;
    public function findByEmail(ClientEmail $email): ? Client;
    public function findByCriteria(ClientDocumento $document, ClientCelular $phone): ? Client;
    public function save(Client $client): void;
    public function update(Client $client): void;
    public function delete(ClientId $id): void;
}
