<?php

declare(strict_types=1);

namespace Src\Client\Domain\Repository;

use Src\Client\Domain\ValueObject\ClientId;
use Src\Client\Domain\Entity\Client;

interface ClientRepository
{
    public function findById(ClientId $id): ?\Src\Client\Domain\Entity\Client;
    public function save(Client $client): void;
    public function update(Client $client): void;
    public function delete(ClientId $id): void;
}