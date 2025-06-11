<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use SoapServer;

abstract class SoapBaseController extends Controller
{
    protected $uri = 'http://localhost/soap/client';

    public function handle(Request $request)
    {
        $options = ['uri' => $this->uri];
        $server = new \SoapServer(null, $options);
        $server->setObject($this);

        ob_start();
        $server->handle();
        $response = ob_get_clean();

        return response($response, 200)->header('Content-Type', 'text/xml');
    }

    protected function response($success, $code, $msg, $data = []): array
    {
        return [
            'success' => $success,
            'cod_error' => $code,
            'msg' => $msg,
            'data' => $data
        ];
    }

    protected function error(\Exception $e): array
    {
        return [
            'success' => false,
            'cod_error' => '99',
            'msg' => $e->getMessage(),
            'data' => []
        ];
    }
}