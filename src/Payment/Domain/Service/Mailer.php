<?php

namespace Src\Payment\Domain\Service;

interface Mailer
{
    public function send(string $to, string $subject, string $body): void;
}
