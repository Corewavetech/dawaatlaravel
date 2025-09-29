<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.success.thanks')
    </x-slot>

    {!! view_render_event('bagisto.shop.checkout.onepage.header.before') !!}

    <!-- Page Header -->
    <div class="d-flex justify-content-between border-bottom px-4 py-3">
        {{-- <div class="d-flex align-items-center gap-4">
            <a
                href="{{ route('shop.home.index') }}"
                class="d-flex min-vh-30"
                aria-label="@lang('shop::checkout.onepage.index.bagisto')"
            >
                <img
                    src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                    alt="{{ config('app.name') }}"
                    width="131"
                    height="29"
                >
            </a>
        </div> --}}

        {{-- @guest('customer')
            @include('shop::checkout.login')
        @endguest --}}
    </div>

    {!! view_render_event('bagisto.shop.checkout.onepage.header.after') !!}

    <!-- Page content -->
    <div class="container mt-5 mb-5">
        <div class="text-center">
            {{ view_render_event('bagisto.shop.checkout.success.image.before', ['order' => $order]) }}

            <img 
                class="img-fluid"
                src="{{ bagisto_asset('images/thank-you.png') }}" 
                alt="thankyou" 
                title=""
            >

            {{ view_render_event('bagisto.shop.checkout.success.image.after', ['order' => $order]) }}

            <p class="fs-4 mt-3">
                @if (auth()->guard('customer')->user())
                    @lang('shop::app.checkout.success.order-id-info', [
                        'order_id' => '<a class="text-primary" href="' . route('shop.customers.account.orders.view', $order->id) . '">' . $order->increment_id . '</a>'
                    ])
                @else
                    @lang('shop::app.checkout.success.order-id-info', ['order_id' => $order->increment_id]) 
                @endif
            </p>

            <p class="fs-2 fw-medium mt-3">
                @lang('shop::app.checkout.success.thanks')
            </p>
            
            <p class="fs-4 text-muted mt-3">
                @if (! empty($order->checkout_message))
                    {!! nl2br($order->checkout_message) !!}
                @else
                    @lang('shop::app.checkout.success.info')
                @endif
            </p>

            {{ view_render_event('bagisto.shop.checkout.success.continue-shopping.before', ['order' => $order]) }}

            <a href="{{ route('shop.home.index') }}">
                <div class="mx-auto btn btn-primary rounded-pill px-4 py-2 mt-4">
                    @lang('shop::app.checkout.cart.index.continue-shopping')
                </div> 
            </a>
            
            {{ view_render_event('bagisto.shop.checkout.success.continue-shopping.after', ['order' => $order]) }}
        </div>
    </div>
</x-shop::layouts>
