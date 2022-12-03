<?php

namespace App\Services;

use Braintree\Configuration;

use Braintree\Gateway;
use Illuminate\Support\Arr;
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

    public function getPlans()
    {
        return $this->gateway->plan()->all();
    }

    public function subscribe(array $data)
    {
        if (!$this->hasPaymentMethod()) {
            $this->addPaymentMethod($data["paymentMethodNonce"]);
        }
        return $this->gateway->subscription()->create($data);
    }

    public function addPaymentMethod($nonce)
    {
        return $this->gateway->paymentMethod()->create([
            'customerId' => request()->user()->btId(),
            'paymentMethodNonce' => $nonce,
            'options' => [
                'failOnDuplicatePaymentMethod' => true,
                'verifyCard' => true
            ]
        ]);
    }

    private function hasPaymentMethod()
    {
        return !is_null($this->paymentMethods());
    }

    public function findPaymentMethod($token)
    {
        return $this->gateway->paymentMethod()->find($token);
    }

    public function getCustomer()
    {
        return $this->gateway->customer()->find(request()->user()->btId());
    }

    public function paymentMethods()
    {
        return $this->getCustomer()->paymentMethods;
    }

}
