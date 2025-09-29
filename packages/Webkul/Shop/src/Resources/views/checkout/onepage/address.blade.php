{!! view_render_event('bagisto.shop.checkout.onepage.address.before') !!}

<div class="accordion mb-4" id="addressAccordion">
    <div class="accordion-item">
        <h2 class="accordion-header" id="addressHeading">
            <button
                class="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#addressCollapse"
                aria-expanded="true"
                aria-controls="addressCollapse"
            >
                {{ __('shop::app.checkout.onepage.address.title') }}
            </button>
        </h2>

        <div
            id="addressCollapse"
            class="accordion-collapse collapse show"
            aria-labelledby="addressHeading"
            data-bs-parent="#addressAccordion"
        >
            <div class="accordion-body">
                <!-- Vue conditional rendering -->
                <template v-if="cart.is_guest">
                    @include('shop::checkout.onepage.address.guest')
                </template>

                <template v-else>
                    @include('shop::checkout.onepage.address.customer')
                </template>
            </div>
        </div>
    </div>
</div>

{!! view_render_event('bagisto.shop.checkout.onepage.address.after') !!}
