<?php

namespace App\Providers;

class PaymentProviderFactory
{
    public static function create(string $provider): PaymentProviderInterface
    {
        if ($provider === 'super') {
            return new SuperPaymentProvider();
        }
        // Add more conditions to handle additional payment providers in the future
        // For example: elseif ($provider === 'new_provider') { return new NewPaymentProvider(); }

        throw new \InvalidArgumentException('Invalid payment provider.');
    }
}
