<!-- Coupon Vue Component -->
<v-coupon 
    :cart="cart"
    @coupon-applied="getCart"
    @coupon-removed="getCart"
></v-coupon>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-coupon-template"
    >
        <div class="d-flex justify-content-between text-end mb-3">
            <p class="text-base">
                fvnjvsjkd
                @{{ cart.coupon_code ? "@lang('shop::app.checkout.coupon.applied')" : "@lang('shop::app.checkout.coupon.discount')" }}
            </p>

            {!! view_render_event('bagisto.shop.checkout.cart.coupon.before') !!}

            <p class="text-base fw-medium">
                <!-- Apply Coupon Form -->
                <x-shop::form v-slot="{ meta, errors, handleSubmit }" as="div">
                    <form @submit="handleSubmit($event, applyCoupon)">
                        {!! view_render_event('bagisto.shop.checkout.cart.coupon.coupon_form_controls.before') !!}

                        <!-- Trigger Button -->
                        <span 
                            class="text-primary cursor-pointer"
                            role="button"
                            tabindex="0"
                            data-bs-toggle="modal"
                            data-bs-target="#couponModal"
                            v-if="! cart.coupon_code"
                        >
                            @lang('shop::app.checkout.coupon.apply')
                        </span>

                        <!-- Bootstrap Modal -->
                        <div 
                            class="modal fade"
                            id="couponModal"
                            tabindex="-1"
                            role="dialog"
                            aria-labelledby="couponModalLabel"
                            aria-hidden="true"
                            ref="couponModal"
                        >
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    <!-- Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="couponModalLabel">
                                            @lang('shop::app.checkout.coupon.apply')
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <!-- Body -->
                                    <div class="modal-body">
                                        <x-shop::form.control-group>
                                            <x-shop::form.control-group.control
                                                type="text"
                                                class="form-control"
                                                name="code"
                                                rules="required"
                                                placeholder="Enter your code"
                                            />
                                            <x-shop::form.control-group.error control-name="code" />
                                        </x-shop::form.control-group>
                                    </div>

                                    <!-- Footer -->
                                    <div class="modal-footer justify-content-between">
                                        <div>
                                            <p class="text-muted small mb-1">@lang('shop::app.checkout.coupon.subtotal')</p>
                                            <p class="h5 mb-0">@{{ cart.formatted_sub_total }}</p>
                                        </div>
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                            :disabled="isStoring"
                                        >
                                            @{{ isStoring ? 'applying' : 'apply coupon' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! view_render_event('bagisto.shop.checkout.cart.coupon.coupon_form_controls.after') !!}
                    </form>
                </x-shop::form>

                <!-- Coupon Info (when applied) -->
                <div v-if="cart.coupon_code" class="d-flex justify-content-between align-items-center text-sm">
                    <span class="fw-medium">@{{ cart.coupon_code }}</span>
                    <i 
                        class="bi bi-x-circle-fill fs-5 cursor-pointer"
                        title="@lang('shop::app.checkout.coupon.remove')"
                        @click="destroyCoupon"
                    ></i>
                </div>
                
            </p>

            {!! view_render_event('bagisto.shop.checkout.cart.coupon.after') !!}
        </div>
    </script>

    <script type="module">
        app.component('v-coupon', {
            template: '#v-coupon-template',
            
            props: ['cart'],

            data() {
                return {
                    isStoring: false,
                }
            },

            methods: {
                applyCoupon(params, { resetForm }) {
                    this.isStoring = true;

                    this.$axios.post("{{ route('shop.api.checkout.cart.coupon.apply') }}", params)
                        .then((response) => {
                            this.isStoring = false;
                            this.$emit('coupon-applied');
                            showFlash("success", response.data.message); 
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                       
                            document.querySelector('[data-bs-dismiss="modal"]').click();

                            resetForm();
                        })
                        .catch((error) => {
                            this.isStoring = false;
                            
                            document.querySelector('[data-bs-dismiss="modal"]').click();

                            if ([400, 422].includes(error.response.request.status)) {
                                showFlash("warning", error.response.data.message);                                
                                resetForm();
                                return;
                            }

                            showFlash("warning", error.response.data.message);                                                            
                        });
                },

                destroyCoupon() {
                    this.$axios.delete("{{ route('shop.api.checkout.cart.coupon.remove') }}", {
                            '_token': "{{ csrf_token() }}"
                        })
                        .then((response) => {
                            this.$emit('coupon-removed');
                            showFlash("warning", response.data.message);                                                            
                        })
                        .catch(error => console.log(error));
                },
            }
        })
    </script>

@endPushOnce
