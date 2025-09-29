{!! view_render_event('bagisto.shop.checkout.onepage.address.customer.before') !!}

<!-- Customer Address Vue Component -->
<v-checkout-address-customer
    :cart="cart"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <!-- Billing Address Shimmer -->
    <x-shop::shimmer.checkout.onepage.address />
</v-checkout-address-customer>

{!! view_render_event('bagisto.shop.checkout.onepage.address.customer.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-address-customer-template"
    >
        <template v-if="isLoading">
            <!-- Billing Address Shimmer -->
            <x-shop::shimmer.checkout.onepage.address />
        </template>

        <template v-else>
            <!-- Saved Addresses -->            
            <template v-if="! activeAddressForm && customerSavedAddresses.billing.length">
                <x-shop::form v-slot="{ meta, errors, handleSubmit }" as="div">
                    <form @submit="handleSubmit($event, addAddressToCart)">
                        <!-- Billing Address Header -->
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <h2 class="h5 fw-medium">
                                @lang('shop::app.checkout.onepage.address.billing-address')
                            </h2>
                        </div>

                        <!-- Saved Customer Addresses Cards -->
                        <div class="mb-3 row  gap-4">
                            <div
                                class="position-relative card p-3 cursor-pointer col-4"
                                v-for="address in customerSavedAddresses.billing"
                            >
                                                        
                                <!-- Actions -->
                                <div class="position-absolute top-0 end-0 mt-3 me-3 d-flex gap-2">                                    

                                    <x-shop::form.control-group class="form-check mb-0 d-flex align-items-center gap-2">
                                        <x-shop::form.control-group.control
                                            type="radio"
                                            name="billing.id"
                                            ::id="`billing_address_id_${address.id}`"
                                            ::for="`billing_address_id_${address.id}`"
                                            ::value="address.id"
                                            v-model="selectedAddresses.billing_address_id"
                                            rules="required"
                                            label="{{ trans('shop::app.checkout.onepage.address.billing-address') }}"
                                        />
                                    </x-shop::form.control-group>

                                    {{-- <div class="form-check mb-0 d-flex align-items-center gap-2">
                                        <input 
                                            class="form-check-input" 
                                            type="radio" 
                                            name="billing.id" 
                                            :id="'billing_address_id_' + address.id" 
                                            v-model="selectedAddresses.billing_address_id"
                                            :value="address.id"
                                        >

                                        <label 
                                            class="form-check-label fs-4" 
                                            :for="'billing_address_id_' + address.id"
                                        >                                           
                                        </label>
                                    </div> --}}


                                    <!-- Edit Icon -->
                                    <span
                                        class="icon-edit fs-5 cursor-pointer"
                                        @click="
                                            selectedAddressForEdit = address;
                                            activeAddressForm = 'billing';
                                            saveAddress = address.address_type == 'customer'
                                        "
                                    > <i class="fa fa-pencil"></i> </span>
                                </div>

                                <!-- Details -->
                                <label class="form-label cursor-pointer" :for="`billing_address_id_${address.id}`">
                                    <span class="icon-checkout-address display-5 text-primary d-block mb-3"></span>

                                    <p class="fw-semibold mb-1">
                                        @{{ address.first_name + ' ' + address.last_name }}
                                        <template v-if="address.company_name">
                                            (@{{ address.company_name }})
                                        </template>
                                    </p>
                                    
                                    <p class="text-muted small mb-0">
                                        <template v-if="address.address">
                                            @{{ address.address.join(', ') }},
                                        </template>
                                        @{{ address.city }},
                                        @{{ address.state }}, @{{ address.country }},
                                        @{{ address.postcode }}
                                    </p>
                                </label>
                            </div>
                            
                            <!-- New Address Card -->
                            <div
                                class="card d-flex align-items-center justify-content-center p-4 cursor-pointer col-4"
                                @click="activeAddressForm = 'billing'"
                                v-if="! cart.billing_address"
                            >
                                <div class="d-flex align-items-center gap-2" role="button" tabindex="0">
                                    <span
                                        class="icon-plus border border-dark rounded-circle p-2 fs-4"
                                        role="presentation"
                                    ></span>
                                    <p class="mb-0">@lang('shop::app.checkout.onepage.address.add-new-address')</p>
                                </div>
                            </div>
                        </div>

                        <!-- Error Message Block -->
                        <x-shop::form.control-group.error name="billing.id" />

                        <!-- Shipping Address Block if have stockable items -->
                        <template v-if="cart.have_stockable_items">
                            <!-- Use for Shipping Checkbox -->   
                             <x-shop::form.control-group class="mb-4 mt-4 d-flex align-items-center gap-2">
                                <x-shop::form.control-group.control
                                    type="checkbox"
                                    name="billing.use_for_shipping"
                                    id="use_for_shipping"
                                    for="use_for_shipping"
                                    value="1"
                                    @change="useBillingAddressForShipping = ! useBillingAddressForShipping"
                                    ::checked="!! useBillingAddressForShipping"
                                />

                                <label                                    
                                    for="use_for_shipping"
                                >
                                    @lang('shop::app.checkout.onepage.address.same-as-billing')
                                </label>
                            </x-shop::form.control-group>

                            <!-- Shipping Address Section -->
                            <div class="mt-4" v-if="! useBillingAddressForShipping">
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <h2 class="h5 fw-medium">
                                        @lang('shop::app.checkout.onepage.address.shipping-address')
                                    </h2>
                                </div>

                                <!-- Saved Shipping Address Cards -->

                                <div class="mb-3 row  gap-4">
                                    <div
                                        class="position-relative card p-3 cursor-pointer col-4"
                                        v-for="address in customerSavedAddresses.shipping"
                                    >
                                                                
                                        <!-- Actions -->
                                        <div class="position-absolute top-0 end-0 mt-3 me-3 d-flex gap-2">                                    

                                            <x-shop::form.control-group class="form-check mb-0 d-flex align-items-center gap-2">
                                                <x-shop::form.control-group.control
                                                    type="radio"
                                                    name="shipping.id"
                                                    ::id="`shipping_address_id_${address.id}`"
                                                    ::for="`shipping_address_id_${address.id}`"
                                                    ::value="address.id"
                                                    v-model="selectedAddresses.shipping_address_id"
                                                    rules="required"
                                                    label="{{ trans('shop::app.checkout.onepage.address.shipping-address') }}"
                                                />
                                            </x-shop::form.control-group>                                           

                                            <!-- Edit Icon -->
                                            <span
                                                class="icon-edit fs-5 cursor-pointer"
                                                @click="
                                                    selectedAddressForEdit = address;
                                                    activeAddressForm = 'shipping';
                                                    saveAddress = address.address_type == 'customer'
                                                "
                                            > <i class="fa fa-pencil"></i> </span>
                                        </div>

                                        <!-- Details -->
                                        <label class="form-label cursor-pointer" :for="`billing_address_id_${address.id}`">
                                            <span class="icon-checkout-address display-5 text-primary d-block mb-3"></span>

                                            <p class="fw-semibold mb-1">
                                               @{{ address.first_name + ' ' + address.last_name }}
                                                <template v-if="address.company_name">
                                                    (@{{ address.company_name }})
                                                </template>
                                            </p>
                                            
                                            <p class="text-muted small mb-0">
                                                <template v-if="address.address">
                                                    @{{ address.address.join(', ') }},
                                                </template>
                                                @{{ address.city }},
                                                @{{ address.state }}, @{{ address.country }},
                                                @{{ address.postcode }}
                                            </p>
                                        </label>
                                    </div>
                                    
                                    <!-- New Address Card -->
                                    <div
                                        class="card d-flex align-items-center justify-content-center p-4 cursor-pointer col-4"
                                        @click="selectedAddressForEdit = null; activeAddressForm = 'shipping'"
                                        v-if="! cart.shipping_address"
                                    >
                                        <div class="d-flex align-items-center gap-2" role="button" tabindex="0">
                                            <span
                                                class="icon-plus border border-dark rounded-circle p-2 fs-4"
                                                role="presentation"
                                            ></span>
                                            <p class="mb-0">@lang('shop::app.checkout.onepage.address.add-new-address')</p>
                                        </div>
                                    </div>
                                </div>                                

                                <!-- Error Block -->
                                <x-shop::form.control-group.error name="shipping.id" />
                            </div>
                        </template>

                        <!-- Proceed Button -->
                        <div class="mt-4 d-flex justify-content-end">
                            <x-shop::button
                                class="btn btn-primary rounded-pill px-4 py-2"
                                :title="trans('shop::app.checkout.onepage.address.proceed')"
                                ::loading="isStoring"
                                ::disabled="isStoring"
                            />
                        </div>
                    </form>
                </x-shop::form>
            </template>


            <!-- Create/Edit Address Form -->
            <template v-else>
                <x-shop::form v-slot="{ meta, errors, handleSubmit }" as="div">
                    <form @submit="handleSubmit($event, updateOrCreateAddress);console.log(this.activeAddressForm);">
                        <!-- Billing/Shipping Address Header -->
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <h2 class="h5 fw-medium">
                                
                                <template v-if="activeAddressForm == 'billing'">
                                    @lang('shop::app.checkout.onepage.address.billing-address')
                                </template>

                                <template v-else>
                                    @lang('shop::app.checkout.onepage.address.shipping-address')
                                </template>
                            </h2>

                            <span
                                class="d-flex align-items-center cursor-pointer text-decoration-underline"
                                v-show="customerSavedAddresses.billing.length && ['billing', 'shipping'].includes(activeAddressForm)"
                                @click="selectedAddressForEdit = null; activeAddressForm = null"
                            >
                                <i class="bi bi-arrow-left me-2 d-none d-md-inline fs-5"></i>
                                @lang('shop::app.checkout.onepage.address.back')
                            </span>
                        </div>

                        <!-- Address Form Vue Component -->                        
                        <v-checkout-address-form
                            :control-name="activeAddressForm"
                            :address="selectedAddressForEdit || undefined"
                        ></v-checkout-address-form>

                        <!-- Save Address to Address Book Checkbox -->
                        <x-shop::form.control-group class="flex gap-3">
                            <x-shop::form.control-group.control
                                type="checkbox"
                                ::name="activeAddressForm + '.save_address'"
                                id="save_address"
                                for="save_address"
                                value="1"
                                v-model="saveAddress"
                                @change="saveAddress = ! saveAddress"
                            />

                            <label
                                class="cursor-pointer"
                                for="save_address"
                            >
                                @lang('shop::app.checkout.onepage.address.save-address')
                            </label>
                        </x-shop::form.control-group>


                        <!-- Save Button -->
                        <div class="mt-4 d-flex justify-content-end">
                            <button                                
                                class="btn btn-primary rounded-pill px-4 py-2"
                                :disabled="isStoring"
                                @click="storeAddress"
                            >
                                <span v-if="!isStoring">{{ trans('shop::app.checkout.onepage.address.save') }}</span>
                                <span v-else>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Saving...
                                </span>
                            </button>
                        </div>

                    </form>
                </x-shop::form>
            </template>

        </template>
    </script>

    <script type="module">
        app.component('v-checkout-address-customer', {
            template: '#v-checkout-address-customer-template',

            props: ['cart'],

            emits: ['processing', 'processed'],

            data() {
                return {
                    customerSavedAddresses: {
                        'billing': [],
                        
                        'shipping': [],
                    },

                    useBillingAddressForShipping: true,

                    activeAddressForm: null,

                    selectedAddressForEdit: null,

                    saveAddress: false,

                    selectedAddresses: {
                        billing_address_id: null,

                        shipping_address_id: null,
                    },

                    isLoading: true,

                    isStoring: false,
                }
            },

            created() {
                if (this.cart.billing_address) {
                    this.useBillingAddressForShipping = this.cart.billing_address.use_for_shipping;
                }
            },

            mounted() {
                this.getCustomerSavedAddresses();
            },

            methods: {
                getCustomerSavedAddresses() {
                    this.$axios.get('{{ route('shop.api.customers.account.addresses.index') }}')
                        .then(response => {
                            this.initializeAddresses('billing', structuredClone(response.data.data));

                            this.initializeAddresses('shipping', structuredClone(response.data.data));

                            if (! this.customerSavedAddresses.billing.length) {
                                this.activeAddressForm = 'billing';
                            }

                            this.isLoading = false;
                        })
                        .catch((error) => {
                            console.error(error);
                        });
                },

                initializeAddresses(type, addresses) {
                    this.customerSavedAddresses[type] = addresses;

                    let cartAddress = this.cart[type + '_address'];

                    if (! cartAddress) {
                        addresses.forEach(address => {
                            if (address.default_address) {
                                this.selectedAddresses[type + '_address_id'] = address.id;
                            }
                        });

                        return addresses;
                    }

                    if (cartAddress.parent_address_id) {
                        addresses.forEach(address => {
                            if (address.id == cartAddress.parent_address_id) {
                                this.selectedAddresses[type + '_address_id'] = address.id;
                            }
                        });
                    } else {
                        this.selectedAddresses[type + '_address_id'] = cartAddress.id;
                        
                        addresses.unshift(cartAddress);
                    }

                    return addresses;
                },

                updateOrCreateAddress(params, { setErrors }) {                                        
                    console.log('Active Address Form:', this.activeAddressForm);                     

                    this.$emit('processing', 'address');

                    params = params[this.activeAddressForm];                    
                    
                    if (!params) {
                        console.error('Params is undefined or not available');
                        return;
                    }

                    let address = this.customerSavedAddresses[this.activeAddressForm].find(address => {
                        return address.id == params.id;
                    });

                    if (! address) {
                        if (params.save_address) {
                            this.createCustomerAddress(params, { setErrors })
                                .then((response) => {
                                    this.addAddressToList(response.data.data);
                                })
                                .catch((error) => {});
                        } else {
                            this.addAddressToList(params);
                        }

                        return;
                    }

                    if (params.save_address) {
                        if (address.address_type == 'customer') {
                            this.updateCustomerAddress(params.id, params, { setErrors })
                                .then((response) => {
                                    this.updateAddressInList(response.data.data);
                                })
                                .catch((error) => {});
                        } else {
                            this.removeAddressFromList(params);

                            this.createCustomerAddress(params, { setErrors })
                                .then((response) => {
                                    this.addAddressToList(response.data.data);
                                })
                                .catch((error) => {});
                        }
                    } else {
                        this.updateAddressInList(params);
                    }
                },

                addAddressToList(address) {
                    this.cart[this.activeAddressForm + '_address'] = address;

                    this.customerSavedAddresses[this.activeAddressForm].unshift(address);

                    this.selectedAddresses[this.activeAddressForm + '_address_id'] = address.id;

                    this.activeAddressForm = null;
                },

                updateAddressInList(params) {
                    this.customerSavedAddresses[this.activeAddressForm].forEach((address, index) => {
                        if (address.id == params.id) {
                            params = {
                                ...address,
                                ...params,
                            };

                            this.cart[this.activeAddressForm + '_address'] = params;

                            this.customerSavedAddresses[this.activeAddressForm][index] = params;

                            this.selectedAddresses[this.activeAddressForm + '_address_id'] = params.id;

                            this.activeAddressForm = null;
                        }
                    });
                },

                removeAddressFromList(params) {
                    this.customerSavedAddresses[this.activeAddressForm] = this.customerSavedAddresses[this.activeAddressForm].filter(address => address.id != params.id);
                },

                createCustomerAddress(params, { setErrors }) {
                    this.isStoring = true;

                    return this.$axios.post('{{ route('shop.api.customers.account.addresses.store') }}', params)
                        .then((response) => {
                            this.isStoring = false;

                            return response;
                        })
                        .catch(error => {
                            this.isStoring = false;

                            if (error.response.status == 422) {
                                let errors = {};

                                Object.keys(error.response.data.errors).forEach(key => {
                                    errors[this.activeAddressForm + '.' + key] = error.response.data.errors[key];
                                });

                                setErrors(errors);
                            }

                            return Promise.reject(error);
                        });
                },

                updateCustomerAddress(id, params, { setErrors }) {
                    this.isStoring = true;

                    return this.$axios.put('{{ route('shop.api.customers.account.addresses.update') }}/' + id, params)
                        .then((response) => {
                            this.isStoring = false;

                            return response;
                        })
                        .catch(error => {
                            this.isStoring = false;

                            if (error.response.status == 422) {
                                let errors = {};

                                Object.keys(error.response.data.errors).forEach(key => {
                                    errors[this.activeAddressForm + '.' + key] = error.response.data.errors[key];
                                });

                                setErrors(errors);
                            }

                            return Promise.reject(error);
                        });
                },

                addAddressToCart(params, { setErrors }) {
                    let payload = {
                        billing: {
                            ...this.getSelectedAddress('billing', params.billing.id),
                            use_for_shipping: this.useBillingAddressForShipping
                        },
                    };

                    if (params.shipping !== undefined) {
                        payload.shipping = this.getSelectedAddress('shipping', params.shipping.id);
                    }

                    this.isStoring = true;

                    this.moveToNextStep();

                    this.$axios.post('{{ route('shop.checkout.onepage.addresses.store') }}', payload)
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

                            this.$emit('processing', 'address');

                            if (error.response.status == 422) {
                                const billingRegex = /^billing\./;

                                if (Object.keys(error.response.data.errors).some(key => billingRegex.test(key))) {
                                    setErrors({
                                        'billing.id': error.response.data.message
                                    });
                                } else {
                                    setErrors({
                                        'shipping.id': error.response.data.message
                                    });
                                }
                            }
                        });
                },

                getSelectedAddress(type, id) {
                    let address = Object.assign({}, this.customerSavedAddresses[type].find(address => address.id == id));

                    if (id == 0) {
                        address.id = null;
                    }

                    return {
                        ...address,
                        default_address: 0,
                    };
                },

                moveToNextStep() {
                    if (this.cart.have_stockable_items) {
                        this.$emit('processing', 'shipping');
                    } else {
                        this.$emit('processing', 'payment');
                    }
                },
            }
        });
    </script>

    <style scoped>
        .form-check-input[type=radio]{
            border: 1px solid;
        }
    </style>
@endPushOnce