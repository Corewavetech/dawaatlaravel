<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.checkout.onepage.index.checkout')"/>
    <meta name="keywords" content="@lang('shop::app.checkout.onepage.index.checkout')"/>
@endPush

<x-shop::layouts>
    
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.onepage.index.checkout')
    </x-slot>

    <!-- Page Content -->
    <div class="container-fluid mt-4">

        <!-- Checkout Vue Component -->
        <v-checkout>
            <x-shop::shimmer.checkout.onepage />
        </v-checkout>
    </div>

    @pushOnce('scripts')
        <script type="text/x-template" id="v-checkout-template">
            <template v-if="! cart">
                <x-shop::shimmer.checkout.onepage />
            </template>

            <template v-else>
                <div class="row g-4 mb-4">
                    <!-- Mobile Summary -->                    

                    <!-- Steps -->
                    <div class="col-md-8">
                        <template v-if="['address', 'shipping', 'payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.address')
                        </template>

                        <template v-if="cart.have_stockable_items && ['shipping', 'payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.shipping')
                        </template>

                        <template v-if="['payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.payment')
                        </template>
                    </div>

                    <!-- Desktop Summary -->
                    <div class="col-md-4">
                        <div class="d-none d-md-block">
                            @include('shop::checkout.onepage.summary')
                        </div>

                        <div class="d-flex justify-content-end mt-3" v-if="canPlaceOrder">
                            <template v-if="cart.payment_method == 'paypal_smart_button'">
                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.before') !!}
                                <v-paypal-smart-button></v-paypal-smart-button>
                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.after') !!}
                            </template>

                            <template v-else>
                                <x-shop::button
                                    type="button"
                                    class="btn btn-primary px-4 py-2 w-100"
                                    :title="trans('shop::app.checkout.onepage.summary.place-order')"
                                    ::disabled="isPlacingOrder"
                                    ::loading="isPlacingOrder"
                                    @click="placeOrder"
                                />
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </script>

        <script type="module">
            app.component('v-checkout', {
                template: '#v-checkout-template',

                data() {
                    return {
                        cart: null,
                        displayTax: {
                            prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",
                            subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",
                            shipping: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_shipping_amount') }}",
                        },
                        isPlacingOrder: false,
                        currentStep: 'address',
                        shippingMethods: null,
                        paymentMethods: null,
                        canPlaceOrder: false,
                    }
                },

                mounted() {
                    this.getCart();
                },

                methods: {
                    getCart() {
                        this.$axios.get("{{ route('shop.checkout.onepage.summary') }}")
                            .then(response => {
                                this.cart = response.data.data;
                                this.scrollToCurrentStep();
                            })
                            .catch(error => {});
                    },

                    stepForward(step) {
                        this.currentStep = step;
                        this.canPlaceOrder = (step === 'review');

                        if (this.currentStep === 'shipping') this.shippingMethods = null;
                        if (this.currentStep === 'payment') this.paymentMethods = null;
                    },

                    stepProcessed(data) {
                        if (this.currentStep === 'shipping') this.shippingMethods = data;
                        if (this.currentStep === 'payment') this.paymentMethods = data;
                        this.getCart();
                    },

                    scrollToCurrentStep() {
                        let container = document.getElementById('steps-container');
                        if (!container) return;

                        container.scrollIntoView({ behavior: 'smooth', block: 'end' });
                    },

                    placeOrder() {
                        this.isPlacingOrder = true;

                        this.$axios.post('{{ route('shop.checkout.onepage.orders.store') }}')
                            .then(response => {
                                window.location.href = response.data.data.redirect
                                    ? response.data.data.redirect_url
                                    : '{{ route('shop.checkout.onepage.success') }}';

                                this.isPlacingOrder = false;
                            })
                            .catch(error => {
                                this.isPlacingOrder = false;
                                this.$emitter.emit('add-flash', {
                                    type: 'error',
                                    message: error.response.data.message
                                });
                            });
                    }
                },
            });
        </script>
    @endPushOnce
</x-shop::layouts>
