{!! view_render_event('bagisto.shop.checkout.onepage.address.guest.before') !!}

<!-- Guest Address Vue Component -->
<v-checkout-address-guest
    :cart="cart"
    @processing="stepForward"
    @processed="stepProcessed"
/>

{!! view_render_event('bagisto.shop.checkout.onepage.address.guest.after') !!}

@include('shop::checkout.onepage.address.form')

@pushOnce('scripts')
<script type="text/x-template" id="v-checkout-address-guest-template">
    <!-- Address Form -->
    <x-shop::form v-slot="{ meta, errors, handleSubmit }" as="div">
        <form @submit="handleSubmit($event, addAddress)">
            <!-- Guest Billing Address -->
            <div class="mb-4">
                {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.billing.before') !!}

                <!-- Billing Address Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 fw-bold">
                        @lang('shop::app.checkout.onepage.address.billing-address')
                    </h2>
                </div>

                <!-- Billing Address Form Component -->
                <v-checkout-address-form
                    control-name="billing"
                    :address="cart.billing_address || undefined"
                ></v-checkout-address-form>

                <!-- Use for Shipping Checkbox -->
                <div class="form-check mt-3" v-if="cart.have_stockable_items">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="billing.use_for_shipping"
                        id="use_for_shipping"
                        value="1"
                        @change="useBillingAddressForShipping = !useBillingAddressForShipping"
                        :checked="!!useBillingAddressForShipping"
                    >
                    <label class="form-check-label text-muted" for="use_for_shipping">
                        @lang('shop::app.checkout.onepage.address.same-as-billing')
                    </label>
                </div>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.billing.after') !!}
            </div>

            <!-- Guest Shipping Address -->
            <template v-if="cart.have_stockable_items">
                <div v-if="!useBillingAddressForShipping" class="mt-4">
                    {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.shipping.before') !!}

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h5 fw-bold">
                            @lang('shop::app.checkout.onepage.address.shipping-address')
                        </h2>
                    </div>

                    <v-checkout-address-form
                        control-name="shipping"
                        :address="cart.shipping_address || undefined"
                    ></v-checkout-address-form>

                    {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.shipping.after') !!}
                </div>
            </template>

            <!-- Proceed Button -->
            <div class="mt-4 text-end">
                <x-shop::button
                    class="btn btn-primary px-4 py-2 w-100"
                    :title="trans('shop::app.checkout.onepage.address.proceed')"
                    ::loading="isStoring"
                    ::disabled="isStoring"
                />
            </div>
        </form>
    </x-shop::form>
</script>

<script type="module">
    app.component('v-checkout-address-guest', {
        template: '#v-checkout-address-guest-template',
        props: ['cart'],
        emits: ['processing', 'processed'],

        data() {
            return {
                useBillingAddressForShipping: true,
                isStoring: false,
            }
        },

        created() {
            if (this.cart.billing_address) {
                this.useBillingAddressForShipping = this.cart.billing_address.use_for_shipping;
            }
        },

        methods: {
            addAddress(params, { setErrors }) {
                this.isStoring = true;

                params['billing']['use_for_shipping'] = this.useBillingAddressForShipping;

                this.moveToNextStep();

                this.$axios.post('{{ route('shop.checkout.onepage.addresses.store') }}', params)
                    .then((response) => {
                        this.isStoring = false;

                        if (response.data.data.redirect_url) {
                            window.location.href = response.data.data.redirect_url;
                        } else {
                            if (this.cart.have_stockable_items) {
                                this.$emit('processed', response.data.data.shippingMethods);
                            } else {
                                this.$emit('processed', response.data.data.payment_methods);
                            }
                        }
                    })
                    .catch(error => {
                        this.isStoring = false;

                        if (error.response.status == 422) {
                            setErrors(error.response.data.errors);
                        }
                    });
            },

            moveToNextStep() {
                if (this.cart.have_stockable_items) {
                    this.$emit('processing', 'shipping');
                } else {
                    this.$emit('processing', 'payment');
                }
            }
        }
    });
</script>
@endPushOnce
