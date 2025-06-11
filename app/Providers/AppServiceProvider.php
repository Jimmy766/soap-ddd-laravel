<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Client\Infrastructure\Repository\EloquentClientRepository;
use Src\Client\Domain\Repository\ClientRepository;
use Src\Wallet\Domain\Repository\WalletRepository;
use Src\Wallet\Infrastructure\Repository\EloquentWalletRepository;
use Src\Payment\Infrastructure\Repository\EloquentPaymentRepository;
use Src\Payment\Domain\Repository\PaymentRepository;
use Src\Payment\Domain\Service\Mailer;
use Src\Payment\Infrastructure\Service\LaravelMailer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ClientRepository::class, EloquentClientRepository::class);
        $this->app->bind(WalletRepository::class, EloquentWalletRepository::class);
        $this->app->bind(PaymentRepository::class, EloquentPaymentRepository::class);
        $this->app->bind(Mailer::class, LaravelMailer::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
