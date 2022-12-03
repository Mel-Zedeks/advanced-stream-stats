<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\BraintreeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubscriptionController extends Controller
{

    public function index()
    {
        $service = new BraintreeService();
        $plans = $service->getPlans();
        return Inertia::render('Subscription/Index',
            compact('plans'));
    }

    public function create(Request $request, Plan $plan)
    {
        $userToken = $request->user()->getToken();
        return Inertia::render('Subscription/Create',
            compact('plan', 'userToken'));
    }

    public function store()
    {

    }
}
