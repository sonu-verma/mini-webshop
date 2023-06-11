<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;

class SuperPaymentProvider implements PaymentProviderInterface
{
    public function processPayment($data): bool
    {
        try{
            $paymentUrl = 'https://superpay.view.agentur-loop.com/pay';

            $response = Http::post($paymentUrl, $data);

            if ($response->successful()) {
                return true;
            } else {
                return false;
            }
        }catch (\Exception $e){
            return false;
        }
    }
}
