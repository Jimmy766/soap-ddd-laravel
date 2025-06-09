<?php

declare(strict_types=1);
namespace Src\Client\Domain\Entity;

use Src\Client\Domain\ValueObject\ClientId;
use Src\Client\Domain\ValueObject\ClientNombres;
use Src\Client\Domain\ValueObject\ClientDocumento;
use Src\Client\Domain\ValueObject\ClientCelular;
use Src\Client\Domain\ValueObject\ClientEmail;

final class Client
{
    private ClientId $id;
    private ClientNombres $nombres;
    private ClientDocumento $documento;
    private ClientCelular $celular;
    private ClientEmail $email;

    public function __construct(
        ClientId $id,
        ClientNombres $nombres,
        ClientDocumento $documento,
        ClientCelular $celular,
        ClientEmail $email
    ) {
        $this->id = $id;
        $this->nombres = $nombres;
        $this->documento = $documento;
        $this->celular = $celular;
        $this->email = $email;
    }

    public function id(): ClientId
    {
        return $this->id;
    }

    public function nombres(): ClientNombres
    {
        return $this->nombres;
    }

    public function documento(): ClientDocumento
    {
        return $this->documento;
    }

    public function celular(): ClientCelular
    {
        return $this->celular;
    }

    public function email(): ?ClientEmail
    {
        return $this->email;
    }
}
