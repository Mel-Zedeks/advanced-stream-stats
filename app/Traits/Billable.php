<?php

namespace App\Traits;

trait Billable
{

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

}
