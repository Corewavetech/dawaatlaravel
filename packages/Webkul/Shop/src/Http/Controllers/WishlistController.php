<?php

namespace Webkul\Shop\Http\Controllers;

use Cart;
use Illuminate\Support\Facades\Event;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Shop\Http\Resources\CartResource;
use Webkul\Shop\Http\Resources\WishlistResource;

class WishlistController extends Controller
{
    public function __construct(
        protected WishlistRepository $wishlistRepository,
        protected ProductRepository $productRepository
    ) {}

    /**
     * Cart page.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {               

        $customer = auth('customer')->user();        

        if($customer){
            
            $items = $this->wishlistRepository
                ->where([
                    'channel_id'  => core()->getCurrentChannel()->id,
                    // 'customer_id' => ,
                ])
                ->count();

        }else{
            $items = 0;
        }

        return response()->json(['status'=>true, 'message'=>'success', 'data'=>$items]);

    }
}
