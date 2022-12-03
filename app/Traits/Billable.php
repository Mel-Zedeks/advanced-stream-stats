<?php

namespace App\Traits;

use App\Services\BraintreeService;
use Braintree\Customer;
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

    public function subscribe()
    {
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

    public function btId()
    {
        return $this->meta['bt_customer_id'];
    }

    public function getToken()
    {
        return $this->service->createToken($this->btId());
    }

}
