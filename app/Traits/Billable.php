<?php

namespace App\Traits;

use App\Models\Subcription;
use App\Services\BraintreeService;
use Braintree\Customer;
use Braintree\SubscriptionSearch;
use Braintree\TransactionSearch;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

trait Billable
{
    protected $service;

    public function __construct()
    {
        $this->service = new BraintreeService();
    }

    public function createBraintreeCustomer()
    {
        $response = $this->service->createCustomer(
            [
                'firstName' => $this->first_name,
                'lastName' => $this->last_name,
                'email' => $this->email,
            ]
        );
        if (!$response->success) {
            throw ValidationException::withMessages([
                'email' => 'Something went wrong on our side'
            ]);
        }
        $this->forceFill([
            "meta" => [
                "bt_customer_id" => $response->customer->id
            ]
        ])->save();
        return $response->customer;
    }

    public function subscribe($data)
    {
        if ($this->subscribed($data['planId'])) {
            return true;
        }
        if (!$this->hasPaymentMethod()) {
            $this->addPaymentMethod($data["paymentMethodNonce"]);
        }
        $subscription_response = $this->service->subscribe($data);

        if (!$subscription_response->success) {
            throw ValidationException::withMessages([
                "planId" => "Something went wrong, try again later"
            ]);
        }
        $this->storeLocalSubscription(
            [
                "name" => $this->service->getPlanById($subscription_response->subscription->planId)->name,
                'braintree_id' => $subscription_response->subscription->id,
                'braintree_plan' => $subscription_response->subscription->planId,
            ]
        );
        /**
         * ask user to select plan
         * check if the user has a btID
         * if not create a customer id
         * use btId to create token
         *
         * ask user to enter payment details with token
         *
         * get nonce
         *
         * save payment details as default
         * save card last 4
         * card brand
         *
         * create transaction
         * change user subscription status and end_date
         */

    }

    public function hasBtId()
    {
        return Arr::has($this->meta, 'bt_customer_id') && $this->meta['bt_customer_id'] !== "";
    }

    public function btId()
    {
        return Arr::has($this->meta, 'bt_customer_id') ? $this->meta['bt_customer_id'] : null;
    }

    public function getToken()
    {
        if (!$this->hasBtId()) {
            $this->createBraintreeCustomer();
        }
        return $this->service->createToken($this->btId());
    }

    public function subscriptions()
    {
        return $this->hasMany(Subcription::class)->orderBy('created_at', 'desc');
    }

    public function subscription($subscription = 'default')
    {
        return $this->subscriptions->sortByDesc(function ($value) {
            return $value->created_at->getTimestamp();
        })->first(function ($value) use ($subscription) {
            return $value->name === $subscription;
        });
    }

    public function currentSubscription()
    {
        if($this->subscriptions->isEmpty()){
            return null;
        }
        return $this->subscriptions()
            ->where('ends_at', null)
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->get()->sortByDesc('created_at')
            ->first()?->toArray();
    }

    public function onPlan($plan)
    {
        return $this->service->getPlanById($plan);
    }

    /**
     *
     * Payment Methods
     */

    public function hasPaymentMethod()
    {
        return !is_null($this->paymentMethods());
    }

    public function addPaymentMethod($nonce)
    {
        return $this->service->addPaymentMethod($this, $nonce);
    }

    public function paymentMethods()
    {
        return $this->service->getPaymentMethods($this);
    }


    private function storeLocalSubscription($data)
    {

        return $this->subscriptions()->create([
            "name" => $data['name'],
            'braintree_id' => $data['braintree_id'],
            'braintree_plan' => $data['braintree_plan'],
            'quantity' => 1,
            'trial_ends_at' => null,
            'ends_at' => null,
        ]);
    }

    public function transactions($options = [])
    {
        $_transactions = [];
        $transactions = $this->service->getTransactionByCustomerId($this->btId(), $options);
        foreach ($transactions as $transaction) {
            $_transactions[] = $transaction;
        }
        return $_transactions;
    }

    public function subscribed(int $plan)
    {
        $transactions = $this->transactions([
            TransactionSearch::createdAt()->between(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth())
        ]);
        foreach ($transactions as $transaction) {
            $local_subscription = $this->subscriptions()->where('braintree_id', $transaction->subscriptionId)->first();
            if (is_null($local_subscription)) {
                $subscription_response = $this->service->getSubscriptionById($transaction->subscriptionId);
                $this->storeLocalSubscription(
                    [
                        "name" => $this->service->getPlanById($subscription_response->planId)->name,
                        'braintree_id' => $subscription_response->id,
                        'braintree_plan' => $subscription_response->planId,
                        'ends_at' => Carbon::now()->gte(Carbon::instance($subscription_response->billingPeriodEndDate)) ?
                            $subscription_response->billingPeriodEndDate : null,
                    ]);
            }
        }

        $subscription = $this->subscription($this->service->getPlanById($plan)->name);
        return !is_null($subscription) && $subscription->valid() &&
            $subscription->braintree_plan === $plan;
    }

    public function cancelSubscription($id)
    {
        $results=$this->service->cancelSubscription($id);
        if ($results->success){
            $this->subscriptions()->where('braintree_id',$id)->first()->forceFill([
                'ends_at'=>Carbon::now()
            ])->save();
        }
    }

}
