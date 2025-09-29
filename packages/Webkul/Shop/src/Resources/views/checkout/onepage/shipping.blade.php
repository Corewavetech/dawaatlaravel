{!! view_render_event('bagisto.shop.checkout.onepage.shipping.before') !!}

<v-shipping-methods
    :methods="shippingMethods"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <!-- Shipping Method Shimmer Effect -->
    <x-shop::shimmer.checkout.onepage.shipping-method />
</v-shipping-methods>

{!! view_render_event('bagisto.shop.checkout.onepage.shipping.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-shipping-methods-template"
    >
        <div class="mb-7">
            <template v-if="! methods">
                <!-- Shipping Method Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage.shipping-method />
            </template>

            <template v-else>
                <!-- Accordion Blade Component -->
                <x-shop::accordion class="overflow-hidden border-0 rounded-0 bg-light" style="background-color:#FFF9EB;">
                    <!-- Accordion Blade Component Header -->
                    <x-slot:header>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="p-3">
                                @lang('shop::app.checkout.onepage.shipping.shipping-method')
                            </h6>
                        </div>
                    </x-slot:header>

                    <!-- Accordion Blade Component Content -->
                    <x-slot:content class="mt-4 p-0">
                        <div class="row g-4">
                            <template v-for="method in methods">
                                {!! view_render_event('bagisto.shop.checkout.onepage.shipping.before') !!}

                                <div 
                                    class="position-relative user-select-none flex-grow-0 flex-shrink-0"
                                    style="max-width: 218px;"
                                    v-for="rate in method.rates"
                                >                                    

                                    <label 
                                        class="position-absolute"
                                        style="top: 20px; right: 20px;"
                                        :class="{'icon-radio-select': $el.previousElementSibling.checked, 'icon-radio-unselect': !$el.previousElementSibling.checked}"
                                        :for="rate.method"
                                    >
                                    <input 
                                        type="radio"
                                        name="shipping_method"
                                        :id="rate.method"
                                        :value="rate.method"
                                        class=""
                                        @change="store(rate.method)"
                                    >
                                    </label>

                                    <label 
                                        class="d-block border rounded p-3 h-100 cursor-pointer"
                                        :for="rate.method"
                                    >
                                        <i class="fas fa-shipping-fast fa-2x"></i>

                                        <div class="mt-3">
                                            <p class="h5 mb-1">
                                                @{{ rate.base_formatted_price }}
                                            </p>
                                            
                                            <p class="text-muted small">
                                                <strong>@{{ rate.method_title }}</strong> - @{{ rate.method_description }}
                                            </p>
                                        </div>
                                    </label>
                                </div>

                                {!! view_render_event('bagisto.shop.checkout.onepage.shipping.after') !!}
                            </template>
                        </div>
                    </x-slot>
                </x-shop::accordion>
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-shipping-methods', {
            template: '#v-shipping-methods-template',

            props: {
                methods: {
                    type: Object,
                    required: true,
                    default: () => null,
                },
            },

            emits: ['processing', 'processed'],

            methods: {
                store(selectedMethod) {
                    this.$emit('processing', 'payment');

                    this.$axios.post("{{ route('shop.checkout.onepage.shipping_methods.store') }}", {    
                            shipping_method: selectedMethod,
                        })
                        .then(response => {
                            if (response.data.redirect_url) {
                                window.location.href = response.data.redirect_url;
                            } else {
                                this.$emit('processed', response.data.payment_methods);
                            }
                        })
                        .catch(error => {
                            this.$emit('processing', 'shipping');

                            if (error.response.data.redirect_url) {
                                window.location.href = error.response.data.redirect_url;
                            }
                        });
                },
            },
        });
    </script>
@endPushOnce
