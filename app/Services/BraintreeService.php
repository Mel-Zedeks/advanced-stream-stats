<?php

namespace App\Services;

use Braintree\Configuration;

use Braintree\Gateway;
use Braintree\SubscriptionSearch;
use Braintree\TransactionSearch;
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

    public function getCustomerById($id)
    {
        return $this->gateway->customer()->find($id);
    }

    public function createToken($btId)
    {
        return $this->gateway->clientToken()->generate([
            "customerId" => $btId
        ]);
    }


    public function subscribe(array $data)
    {
        return $this->gateway->subscription()->create($data);
    }

    public function addPaymentMethod($user,$nonce)
    {
        return $this->gateway->paymentMethod()->create([
            'customerId' => $user->btId(),
            'paymentMethodNonce' => $nonce,
            'options' => [
                'failOnDuplicatePaymentMethod' => true,
                'verifyCard' => true
            ]
        ]);
    }


    public function getPaymentMethodByToken($token)
    {
        return $this->gateway->paymentMethod()->find($token);
    }


    public function getPaymentMethods($user)
    {
        return $this->getCustomerById($user->btId())->paymentMethods;
    }


    public function getPlans()
    {
        return $this->gateway->plan()->all();
    }

    public function getPlanById($plan)
    {
        $plans = $this->getPlans();

        return Arr::first(Arr::where($plans, function ($_plan) use ($plan) {
            return $_plan->id == $plan;
        }));
    }


    public function getTransactionByCustomerId($btId,$options=[])
    {
       return $this->gateway->transaction()->search([
            TransactionSearch::customerId()->is($btId),
        ]+$options);
    }

    public function getSubscriptionByTransactionId($txId)
    {
       return $this->gateway->subscription()->search([
           SubscriptionSearch::transactionId()->is($txId)
       ]);
   }

   public function getActiveSubscriptions($token=null){
       return $this->gateway->subscription()->search([
           SubscriptionSearch::status()->is('Active'),
       ]);
   }

    public function getSubscriptionById($id)
    {
       return $this->gateway->subscription()->find($id);
    }

    public function cancelSubscription($id)
    {
        return $this->gateway->subscription()->cancel($id);
    }
}
