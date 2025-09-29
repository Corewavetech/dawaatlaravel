<?php 

namespace Webkul\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Corewave\Subscription\Models\SubscriptionPlan;
use Webkul\Admin\Http\Requests\MassDestroyRequest;
use Webkul\Admin\Http\Requests\SubscriptionPlanRequest;
use Webkul\Product\Models\Product;
use Webkul\Product\Repositories\ProductRepository;

class SubscriptionPlanController extends Controller
{

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $plans = SubscriptionPlan::with('product')->get();

        if (request()->ajax()) {
            return datagrid(\Webkul\Admin\DataGrids\SubscriptionPlan\SubscriptionPlan::class)->process();
        }

        return view('admin::subscription_plan.index');

    }

    public function create()
    {
        
        $locales = core()->getAllLocales();
        $products = Product::all();

        return view('admin::subscription_plan.create', compact('locales', 'products'));

    }

    public function store(SubscriptionPlanRequest $request)
    {       

        $subscriptionsplan = SubscriptionPlan::create($request->all());

        return redirect()->route('admin.subscription.plans.index');
    }

    public function edit(SubscriptionPlan $plan)
    {        
        $locales = core()->getAllLocales();
        $products = Product::all();

        return view('admin::subscription_plan.edit', compact('locales', 'products', 'plan'));
    }

    public function update(SubscriptionPlanRequest $request, SubscriptionPlan $plan)
    {
        
        $isUpdated = $plan->update($request->all());

        if($isUpdated){
            return redirect()->route('admin.subscription.plans.index')->with('success', 'Plan updated successfully');
        }

        return redirect()->back()->with('error', 'Plan not updated');

    }

    public function destroy(SubscriptionPlan $plan)
    {
        if($plan){
            $plan->delete();
            return redirect()->route('admin.subscription.plans.index')->with('success', 'Plan deleted successfully');
        }

        return redirect()->route('admin.subscription.plans.index')->with('error', 'Failed to delete Plan');

    }

    public function massDestroy(MassDestroyRequest $request)
    {        
        $planIds = $request->input('indices');
        
        try {
            
            foreach ($planIds as $planId) {
                $plan = SubscriptionPlan::find($planId);

                if(isset($plan)){
                    $plan->delete();
                }
            }

            return new JsonResponse([
                'message' => 'Selected Items Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ]);
        }

    }

}