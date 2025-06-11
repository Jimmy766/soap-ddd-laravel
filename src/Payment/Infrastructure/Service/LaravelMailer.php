<?php
namespace Src\Payment\Infrastructure\Service;

use Src\Payment\Domain\Service\Mailer;
use Illuminate\Support\Facades\Mail;

class LaravelMailer implements Mailer
{
    public function send(string $to, string $subject, string $body): void
    {
        Mail::raw($body, function ($message) use ($to, $subject) {
            $message->to($to)
                    ->subject($subject);
        });
    }
}
