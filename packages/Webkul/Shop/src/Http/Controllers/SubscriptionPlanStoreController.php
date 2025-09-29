<?php

namespace Webkul\Shop\Http\Controllers;

use Corewave\Subscription\Models\SubscriptionPlan;
use Illuminate\Foundation\Http\FormRequest;
use Webkul\Shop\Http\Controllers\Controller;

class SubscriptionPlanStoreController extends Controller
{

    public function index()
    {        
        $plans = SubscriptionPlan::with('product')->paginate(10);
        return view('shop::subscriptions.plans.index', compact('plans'));
    }

    public function checkout(FormRequest $request)
    {
        $plan = SubscriptionPlan::with('product')->findOrFail($request->plan_id);
        session(['subscription_plan' => $plan]);
        return redirect()->route('shop.subscription.payment');
    }

}