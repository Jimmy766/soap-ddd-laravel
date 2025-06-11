<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoapController;
use App\Http\Controllers\SoapController1;
use Src\Client\Infrastructure\Controller\CreateClientController;
use Src\Wallet\Infrastructure\Controller\CheckWalletController;
use Src\Wallet\Infrastructure\Controller\TopUpController;
use Src\Payment\Infrastructure\Controller\DoPayController;
use Src\Payment\Infrastructure\Controller\ConfirmPaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::match(['GET', 'POST'],'/soap/client', [CreateClientController::class, 'handle']);
Route::match(['GET', 'POST'],'/soap/wallet/topup', [TopUpController::class, 'handle']);
Route::match(['GET', 'POST'],'/soap/wallet/check', [CheckWalletController::class, 'handle']);
Route::match(['GET', 'POST'],'/soap/payment/dopay', [DoPayController::class, 'handle']);
Route::match(['GET', 'POST'],'/soap/payment/confirm', [ConfirmPaymentController::class, 'handle']);
