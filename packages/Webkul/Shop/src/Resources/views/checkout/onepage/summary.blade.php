<div class="card cart-summary">
    <div class="card-body">
        <h5 class="card-title mb-4">Cart Summary</h5>

        <h6>Price Details (@{{ cart?.items_count }} Items)</h6>
        <div class="d-flex justify-content-between mb-3">
            <span>Total MRP</span>
            <span> @{{ cart?.formatted_sub_total }} </span>
        </div>
        <div class="d-flex justify-content-between mb-3" v-if="cart.discount_amount && parseFloat(cart.discount_amount) > 0">
            <span>
                @lang('shop::app.checkout.cart.summary.discount-amount')
            </span>                                                    
            <span v-if="cart.discount_amount && parseFloat(cart.discount_amount) > 0"> @{{ cart?.formatted_discount_amount }} </span>
        </div>
        
        @include('shop::checkout.coupon')

        <div class="d-flex justify-content-between mb-3">
            <span>Tax Amount</span>
            <span> @{{ cart?.formatted_tax_total }}</span>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <span>Shipping Charge</span>
            <span class="free_shipping" v-if="cart?.shipping_method && cart?.shipping_amount == 0">Free</span>
            <span v-if="cart?.shipping_amount > 0">@{{ cart?.formatted_shipping_amount }}</span>
        </div>
        <hr>
        <div class="d-flex justify-content-between mb-4">
            <strong>Total</strong>
            <strong> @{{ cart?.formatted_grand_total }}</strong>
        </div>
        
    </div>
</div>