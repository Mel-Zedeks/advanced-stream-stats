<?php

namespace App\Services;

use Braintree\Configuration;

use Braintree\Gateway;
use Illuminate\Support\Facades\Log;

class BraintreeService
{

    public function __construct()
    {
        $config = [];
        try {
            $config = new Configuration([
                'environment' => config('services.braintree.environment'),
                'merchantId' => config('services.braintree.merchant_id'),
                'publicKey' => config('services.braintree.public_key'),
                'privateKey' => config('services.braintree.private_key')
            ]);
            $config->timeout(10);
        } catch (\Braintree\Exception\Configuration $e) {
            Log::error(json_encode($e));
        }
        $this->gateway = new Gateway($config);
    }

    public function createCustomer(array $array)
    {
        return $this->gateway->customer()->create($array);
    }

    public function createToken($btId)
    {
        return $this->gateway->clientToken()->generate([
            "customerId" => $btId
        ]);
    }

    public function getPlans(){
        return $this->gateway->plan()->all();
    }

}
