<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\BraintreeService;
use Braintree\Collection;
use Braintree\SubscriptionSearch;
use Braintree\TransactionSearch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SubscriptionController extends Controller
{
    private BraintreeService $service;

    public function __construct()
    {
        $this->service = new BraintreeService();
    }

    public function index()
    {

        $plans = $this->service->getPlans();
        return Inertia::render('Subscription/Index',
            compact('plans'));
    }

    public function create(Request $request, $plan)
    {
        $plan = $this->service->getPlanById($plan);
        $userToken = $request->user()->getToken();
        return Inertia::render('Subscription/Create',
            compact('plan', 'userToken'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "paymentMethodNonce" => "required|string",
            "planId" => "required|string"
        ]);
        $request->user()->subscribe($data);

        return to_route('dashboard');
    }


    public function show(Request $request)
    {
        $user = $request->user();
        $subscriptions = $user->subscriptions;
        $transactions = $user->transactions();

        return Inertia::render('Subscription/Show',
            compact('subscriptions', 'transactions'));
    }

    public function destroy(Request $request, $id)
    {
        $request->user()->cancelSubscription($id);
        return back();
    }
}
