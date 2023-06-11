<?php

namespace App\Providers;

interface PaymentProviderInterface
{
    public function processPayment(array $data): bool;
}
