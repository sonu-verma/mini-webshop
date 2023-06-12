<?php

namespace App\Providers;

class PaymentProviderFactory
{
    public static function create(string $provider): PaymentProviderInterface
    {
        if ($provider === 'super') {
            return new SuperPaymentProvider();
        }
        
        throw new \InvalidArgumentException('Invalid payment provider.');
    }
}
