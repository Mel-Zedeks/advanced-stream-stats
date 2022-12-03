<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\BraintreeService;
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
        $plans = $this->service->getPlans();

        $plan=Arr::first(Arr::where($plans,function ($_plan) use ($plan){
            return $_plan->id == $plan;
        }));
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

        return $this->service->subscribe($data);
    }
}
