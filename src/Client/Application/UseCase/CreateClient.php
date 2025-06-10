<?php

namespace Src\Client\Application\UseCase;

use Src\Client\Domain\Repository\ClientRepository;
use Src\Client\Domain\Entity\Client;

final class CreateClient
{
    private ClientRepository $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Client $client): void
    {
        $oldClient = $this->repository->findByEmail($client->email());
        if ($oldClient) {
            throw new \Exception('Client with this email already exists.');
        }
        $this->repository->save($client);
    }
}