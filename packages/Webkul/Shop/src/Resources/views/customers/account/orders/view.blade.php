@php
    $customer = auth()->guard('customer')->user();    
@endphp

@push('styles')
    <style>
        .tab-content .invoicePrint {
            border-radius: 30px;
            background-color: #29348E;
            border-style: none;
        }
    </style>
@endpush

<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.orders.view.page-title', ['order_id' => $order->increment_id])
    </x-slot>    

    <section>
        <div class="container-fluid">

            <!------ Include the above in your HEAD tag ---------->

            <div class="py-5">
                <div class="card profile_setion">

                    <div class="row">

                        <div class="col-md-3 ">
                            <div class="list-group ">
                                <div class="show_profile_data">
                                    <img
                                        src="{{ $customer->image_url ?? asset('uploads/avatar.jpg') }}" />
                                    <h5>{{ $customer->first_name." ".$customer->last_name }}</h5>
                                    {{-- <p>rohini sectior 7 new delhi </p> --}}
                                </div>
                                <a href="{{ route('shop.customers.account.profile.index') }}" class="list-group-item list-group-item-action "><i
                                        class="fa-regular fa-user mr-2"></i> Profile</a>
                                <a href="{{ route('shop.customers.account.orders.index') }}" class="list-group-item list-group-item-action active"><i
                                        class="fa-solid fa-cart-arrow-down mr-2"></i></i> My Orders</a>
                                <!-- <a href="/wishlist.html" class="list-group-item list-group-item-action">Wishlist</a> -->
                                <a href="{{ route('shop.customers.account.addresses.index') }}" class="list-group-item list-group-item-action"><i
                                        class="fa-solid fa-location-dot mr-2"></i></i> Save Address</a>
                                <a href="{{ route('shop.customers.account.support') }}" class="list-group-item list-group-item-action"><i
                                        class="fa-solid fa-headphones mr-2"></i> Help &
                                    Support</a>
                            </div>
                        </div>

                        <div class="col-md-9">

                            <div class="card border-0">
                                <div class="card-body">

                                    <div class="d-flex justify-content-between mt-5">

                                        <div class="d-flex d-md-block align-items-center">                                    
                                            <a class="d-md-none me-2" href="{{ route('shop.customers.account.orders.index') }}">
                                                <span class="icon-arrow-left rtl:icon-arrow-right fs-4"></span>
                                            </a>

                                            <h2 class="fs-4 fw-medium ms-2 ms-md-0">
                                                @lang('shop::app.customers.account.orders.view.page-title', ['order_id' => $order->increment_id])
                                            </h2>
                                        </div>

                                        <div class="d-flex flex-wrap gap-2">
                                            {!! view_render_event('bagisto.shop.customers.account.orders.reorder_button.before', ['order' => $order]) !!}

                                            @if (
                                                $order->canReorder()
                                                && core()->getConfigData('sales.order_settings.reorder.shop')
                                            )
                                                <a
                                                    href="{{ route('shop.customers.account.orders.reorder', $order->id) }}"
                                                    class="btn btn-primary px-4 py-2 fw-normal d-none d-md-inline-block invoicePrint"
                                                >
                                                    @lang('shop::app.customers.account.orders.view.reorder-btn-title')
                                                </a>
                                            @endif

                                            {!! view_render_event('bagisto.shop.customers.account.orders.reorder_button.after', ['order' => $order]) !!}

                                            {!! view_render_event('bagisto.shop.customers.account.orders.cancel_button.before', ['order' => $order]) !!}

                                            @if ($order->canCancel())
                                                <form
                                                    method="POST"
                                                    ref="cancelOrderForm"
                                                    action="{{ route('shop.customers.account.orders.cancel', $order->id) }}"
                                                >
                                                    @csrf
                                                </form>

                                                <a
                                                    href="javascript:void(0);"
                                                    class="btn btn-outline-secondary px-4 py-2 fw-normal d-none d-md-inline-block"
                                                    {{-- onclick="$emitter.emit('open-confirm-modal', {
                                                        message: '@lang('shop::app.customers.account.orders.view.cancel-confirm-msg')',
                                                        agree: () => {
                                                            document.querySelector('[ref=cancelOrderForm]').submit();
                                                        }
                                                    })" --}}
                                                    onclick="if (confirm('@lang('shop::app.customers.account.orders.view.cancel-confirm-msg')')) { 
                                                        document.querySelector('[ref=cancelOrderForm]').submit(); 
                                                    }"
                                                >
                                                    @lang('shop::app.customers.account.orders.view.cancel-btn-title')
                                                </a>
                                            @endif

                                            {!! view_render_event('bagisto.shop.customers.account.orders.cancel_button.after', ['order' => $order]) !!}
                                        </div>


                                    </div>

                                    <div class="mt-4 mt-md-5 d-md-grid gap-md-4">                                        

                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Information</button>
                                            </li>

                                            @if ($order->invoices->count())
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Invoices</button>
                                                </li>                                            
                                            @endif

                                            @if ($order->shipments->count())
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                                                        @lang('shop::app.customers.account.orders.view.shipments.shipments')
                                                    </button>
                                                </li>                                            
                                            @endif

                                            @if ($order->refunds->count())
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-refund" type="button" role="tab" aria-controls="pills-refund" aria-selected="false">
                                                        @lang('shop::app.customers.account.orders.view.refunds.refunds')
                                                    </button>
                                                </li>                                            
                                            @endif

                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                <div class="fs-6 fw-medium">
                                                    @lang('shop::app.customers.account.orders.view.information.placed-on')

                                                    {{ core()->formatDate($order->created_at, 'd M Y') }}
                                                </div>

                                                <div class="table-responsive mt-4 border rounded">
                                                    <table class="table table-bordered align-middle mb-0">
                                                        <thead class="table-light text-black text-sm">
                                                            <tr>
                                                                <th scope="col">
                                                                    @lang('shop::app.customers.account.orders.view.information.sku')
                                                                </th>
                                                                <th scope="col">
                                                                    @lang('shop::app.customers.account.orders.view.information.product-name')
                                                                </th>
                                                                <th scope="col">
                                                                    @lang('shop::app.customers.account.orders.view.information.price')
                                                                </th>
                                                                <th scope="col">
                                                                    @lang('shop::app.customers.account.orders.view.information.item-status')
                                                                </th>
                                                                <th scope="col">
                                                                    @lang('shop::app.customers.account.orders.view.information.subtotal')
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($order->items as $item)
                                                                <tr class="bg-white fw-medium">
                                                                    <td>
                                                                        {{ $item->getTypeInstance()->getOrderedItem($item)->sku }}
                                                                    </td>

                                                                    <td>
                                                                        {{ $item->name }}

                                                                        @if (isset($item->additional['attributes']))
                                                                            <div class="mt-1">
                                                                                @foreach ($item->additional['attributes'] as $attribute)
                                                                                    <strong>{{ $attribute['attribute_name'] }}:</strong>
                                                                                    {{ $attribute['option_label'] }}<br>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                                                            {{ core()->formatPrice($item->price_incl_tax, $order->order_currency_code) }}
                                                                        @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                                                            {{ core()->formatPrice($item->price_incl_tax, $order->order_currency_code) }}
                                                                            <div class="small text-muted mt-1">
                                                                                @lang('shop::app.customers.account.orders.view.information.excl-tax')
                                                                                <strong>{{ core()->formatPrice($item->price, $order->order_currency_code) }}</strong>
                                                                            </div>
                                                                        @else
                                                                            {{ core()->formatPrice($item->price, $order->order_currency_code) }}
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        @if($item->qty_ordered)
                                                                            @lang('shop::app.customers.account.orders.view.information.ordered-item', ['qty_ordered' => $item->qty_ordered])<br>
                                                                        @endif
                                                                        @if($item->qty_invoiced)
                                                                            @lang('shop::app.customers.account.orders.view.information.invoiced-item', ['qty_invoiced' => $item->qty_invoiced])<br>
                                                                        @endif
                                                                        @if($item->qty_shipped)
                                                                            @lang('shop::app.customers.account.orders.view.information.item-shipped', ['qty_shipped' => $item->qty_shipped])<br>
                                                                        @endif
                                                                        @if($item->qty_refunded)
                                                                            @lang('shop::app.customers.account.orders.view.information.item-refunded', ['qty_refunded' => $item->qty_refunded])<br>
                                                                        @endif
                                                                        @if($item->qty_canceled)
                                                                            @lang('shop::app.customers.account.orders.view.information.item-canceled', ['qty_canceled' => $item->qty_canceled])<br>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                                                            {{ core()->formatPrice($item->total_incl_tax, $order->order_currency_code) }}
                                                                        @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                                                            {{ core()->formatPrice($item->total_incl_tax, $order->order_currency_code) }}
                                                                            <div class="small text-muted mt-1">
                                                                                @lang('shop::app.customers.account.orders.view.information.excl-tax')
                                                                                {{ core()->formatPrice($item->total, $order->order_currency_code) }}
                                                                            </div>
                                                                        @else
                                                                            {{ core()->formatPrice($item->total, $order->order_currency_code) }}
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="mt-4 d-flex flex-wrap gap-4">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-end">
                                                            <div class="d-grid text-body text-sm" style="max-width: max-content; gap: 0.5rem;">

                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.subtotal.before') !!}

                                                                {{-- Subtotal --}}
                                                                @if (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'including_tax')
                                                                    <div class="d-flex justify-content-between">
                                                                        @lang('shop::app.customers.account.orders.view.information.subtotal')
                                                                        <p class="mb-0">{{ core()->formatPrice($order->sub_total_incl_tax, $order->order_currency_code) }}</p>
                                                                    </div>
                                                                @elseif (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'both')
                                                                    <div class="d-flex justify-content-between">
                                                                        @lang('shop::app.customers.account.orders.view.information.subtotal-excl-tax')
                                                                        <p class="mb-0">{{ core()->formatPrice($order->sub_total, $order->order_currency_code) }}</p>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between">
                                                                        @lang('shop::app.customers.account.orders.view.information.subtotal-incl-tax')
                                                                        <p class="mb-0">{{ core()->formatPrice($order->sub_total_incl_tax, $order->order_currency_code) }}</p>
                                                                    </div>
                                                                @else
                                                                    <div class="d-flex justify-content-between">
                                                                        @lang('shop::app.customers.account.orders.view.information.subtotal')
                                                                        <p class="mb-0">{{ core()->formatPrice($order->sub_total, $order->order_currency_code) }}</p>
                                                                    </div>
                                                                @endif

                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.subtotal.after') !!}
                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.shipping.before') !!}

                                                                {{-- Shipping --}}
                                                                @if ($order->haveStockableItems())
                                                                    @if (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'including_tax')
                                                                        <div class="d-flex justify-content-between">
                                                                            @lang('shop::app.customers.account.orders.view.information.shipping-handling')
                                                                            <p class="mb-0">{{ core()->formatPrice($order->shipping_amount_incl_tax, $order->order_currency_code) }}</p>
                                                                        </div>
                                                                    @elseif (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'both')
                                                                        <div class="d-flex justify-content-between">
                                                                            @lang('shop::app.customers.account.orders.view.information.shipping-handling-excl-tax')
                                                                            <p class="mb-0">{{ core()->formatPrice($order->shipping_amount, $order->order_currency_code) }}</p>
                                                                        </div>
                                                                        <div class="d-flex justify-content-between">
                                                                            @lang('shop::app.customers.account.orders.view.information.shipping-handling-incl-tax')
                                                                            <p class="mb-0">{{ core()->formatPrice($order->shipping_amount_incl_tax, $order->order_currency_code) }}</p>
                                                                        </div>
                                                                    @else
                                                                        <div class="d-flex justify-content-between">
                                                                            @lang('shop::app.customers.account.orders.view.information.shipping-handling')
                                                                            <p class="mb-0">{{ core()->formatPrice($order->shipping_amount, $order->order_currency_code) }}</p>
                                                                        </div>
                                                                    @endif
                                                                @endif

                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.shipping.after') !!}
                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.tax-amount.before') !!}

                                                                {{-- Tax --}}
                                                                <div class="d-flex justify-content-between">
                                                                    @lang('shop::app.customers.account.orders.view.information.tax')
                                                                    <p class="mb-0">{{ core()->formatPrice($order->tax_amount, $order->order_currency_code) }}</p>
                                                                </div>

                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.tax-amount.after') !!}
                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.discount.before') !!}

                                                                {{-- Discount --}}
                                                                @if ($order->base_discount_amount > 0)
                                                                    <div class="d-flex justify-content-between">
                                                                        <p class="mb-0">
                                                                            @lang('shop::app.customers.account.orders.view.information.discount')
                                                                            @if ($order->coupon_code)
                                                                                ({{ $order->coupon_code }})
                                                                            @endif
                                                                        </p>
                                                                        <p class="mb-0">{{ core()->formatPrice($order->discount_amount, $order->order_currency_code) }}</p>
                                                                    </div>
                                                                @endif

                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.discount.after') !!}
                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.grand-total.before') !!}

                                                                {{-- Grand Total --}}
                                                                <div class="d-flex justify-content-between fw-semibold">
                                                                    @lang('shop::app.customers.account.orders.view.information.grand-total')
                                                                    <p class="mb-0">{{ core()->formatPrice($order->grand_total, $order->order_currency_code) }}</p>
                                                                </div>

                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.grand-total.after') !!}
                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.total-paid.before') !!}

                                                                {{-- Total Paid --}}
                                                                <div class="d-flex justify-content-between">
                                                                    @lang('shop::app.customers.account.orders.view.information.total-paid')
                                                                    <p class="mb-0">{{ core()->formatPrice($order->grand_total_invoiced, $order->order_currency_code) }}</p>
                                                                </div>

                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.total-paid.after') !!}
                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.total-refunded.before') !!}

                                                                {{-- Total Refunded --}}
                                                                <div class="d-flex justify-content-between">
                                                                    @lang('shop::app.customers.account.orders.view.information.total-refunded')
                                                                    <p class="mb-0">{{ core()->formatPrice($order->grand_total_refunded, $order->order_currency_code) }}</p>
                                                                </div>

                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.total-refunded.after') !!}
                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.total-due.before') !!}

                                                                {{-- Total Due --}}
                                                                <div class="d-flex justify-content-between">
                                                                    @lang('shop::app.customers.account.orders.view.information.total-due')
                                                                    <p class="mb-0">
                                                                        @if($order->status !== \Webkul\Sales\Models\Order::STATUS_CANCELED)
                                                                            {{ core()->formatPrice($order->total_due, $order->order_currency_code) }}
                                                                        @else
                                                                            {{ core()->formatPrice(0.00, $order->order_currency_code) }}
                                                                        @endif
                                                                    </p>
                                                                </div>

                                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.information.total-due.after') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                
                                                @if ($order->invoices->count())
                                                    @foreach ($order->invoices as $invoice)
                                                        <!-- Desktop View -->
                                                        <div class="d-none d-md-block">
                                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                                <label class="h6 mb-0 fw-medium">
                                                                    @lang('shop::app.customers.account.orders.view.invoices.individual-invoice', ['invoice_id' => $invoice->increment_id ?? $invoice->id])
                                                                </label>

                                                                <a href="{{ route('shop.customers.account.orders.print-invoice', $invoice->id) }}" class="btn btn-primary text-decoration-none fw-semibold d-flex align-items-center gap-2 invoicePrint">
                                                                    <span class="icon-download fs-5"></span>
                                                                    @lang('shop::app.customers.account.orders.view.invoices.print')
                                                                </a>
                                                            </div>

                                                            <div class="table-responsive border rounded">
                                                                <table class="table table-hover text-nowrap align-middle mb-0">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>@lang('shop::app.customers.account.orders.view.invoices.sku')</th>
                                                                            <th>@lang('shop::app.customers.account.orders.view.invoices.product-name')</th>
                                                                            <th>@lang('shop::app.customers.account.orders.view.invoices.price')</th>
                                                                            <th>@lang('shop::app.customers.account.orders.view.invoices.qty')</th>
                                                                            <th>@lang('shop::app.customers.account.orders.view.invoices.subtotal')</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($invoice->items as $item)
                                                                            <tr>
                                                                                <td>{{ $item->getTypeInstance()->getOrderedItem($item)->sku }}</td>
                                                                                <td>
                                                                                    {{ $item->name }}
                                                                                    @if (isset($item->additional['attributes']))
                                                                                        <div class="mt-1 small">
                                                                                            @foreach ($item->additional['attributes'] as $attribute)
                                                                                                <strong>{{ $attribute['attribute_name'] }}:</strong> {{ $attribute['option_label'] }}<br>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                                                                        {{ core()->formatPrice($item->price_incl_tax, $order->order_currency_code) }}
                                                                                    @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                                                                        {{ core()->formatPrice($item->price_incl_tax, $order->order_currency_code) }}
                                                                                        <div class="text-muted small">
                                                                                            @lang('shop::app.customers.account.orders.view.information.excl-tax'):
                                                                                            <span class="fw-medium">{{ core()->formatPrice($item->price, $order->order_currency_code) }}</span>
                                                                                        </div>
                                                                                    @else
                                                                                        {{ core()->formatPrice($item->price, $order->order_currency_code) }}
                                                                                    @endif
                                                                                </td>
                                                                                <td>{{ $item->qty }}</td>
                                                                                <td>
                                                                                    @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                                                                        {{ core()->formatPrice($item->total_incl_tax, $order->order_currency_code) }}
                                                                                    @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                                                                        {{ core()->formatPrice($item->total_incl_tax, $order->order_currency_code) }}
                                                                                        <div class="text-muted small">
                                                                                            @lang('shop::app.customers.account.orders.view.invoices.excl-tax'):
                                                                                            <span class="fw-medium">{{ core()->formatPrice($item->total, $order->order_currency_code) }}</span>
                                                                                        </div>
                                                                                    @else
                                                                                        {{ core()->formatPrice($item->total, $order->order_currency_code) }}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <!-- Summary -->
                                                            <div class="mt-4 d-flex justify-content-end">
                                                                <div class="d-grid" style="max-width: 400px; gap: 0.75rem; font-size: 0.9rem;">
                                                                    {!! view_render_event('bagisto.shop.customers.account.orders.view.invoices.subtotal.before') !!}

                                                                    @if (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'including_tax')
                                                                        <div class="d-flex justify-content-between">
                                                                            <span>@lang('shop::app.customers.account.orders.view.invoices.subtotal')</span>
                                                                            <span>{{ core()->formatPrice($invoice->sub_total_incl_tax, $order->order_currency_code) }}</span>
                                                                        </div>
                                                                    @elseif (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'both')
                                                                        <div class="d-flex justify-content-between">
                                                                            <span>@lang('shop::app.customers.account.orders.view.invoices.subtotal-excl-tax')</span>
                                                                            <span>{{ core()->formatPrice($invoice->sub_total, $order->order_currency_code) }}</span>
                                                                        </div>
                                                                        <div class="d-flex justify-content-between">
                                                                            <span>@lang('shop::app.customers.account.orders.view.invoices.subtotal-incl-tax')</span>
                                                                            <span>{{ core()->formatPrice($invoice->sub_total_incl_tax, $order->order_currency_code) }}</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="d-flex justify-content-between">
                                                                            <span>@lang('shop::app.customers.account.orders.view.invoices.subtotal')</span>
                                                                            <span>{{ core()->formatPrice($invoice->sub_total, $order->order_currency_code) }}</span>
                                                                        </div>
                                                                    @endif

                                                                    {!! view_render_event('bagisto.shop.customers.account.orders.view.invoices.subtotal.after') !!}
                                                                    {!! view_render_event('bagisto.shop.customers.account.orders.view.invoices.shipping.before') !!}

                                                                    <!-- Shipping -->
                                                                    @if (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'including_tax')
                                                                        <div class="d-flex justify-content-between">
                                                                            <span>@lang('shop::app.customers.account.orders.view.invoices.shipping-handling')</span>
                                                                            <span>{{ core()->formatPrice($invoice->shipping_amount_incl_tax, $order->order_currency_code) }}</span>
                                                                        </div>
                                                                    @elseif (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'both')
                                                                        <div class="d-flex justify-content-between">
                                                                            <span>@lang('shop::app.customers.account.orders.view.invoices.shipping-handling-excl-tax')</span>
                                                                            <span>{{ core()->formatPrice($invoice->shipping_amount, $order->order_currency_code) }}</span>
                                                                        </div>
                                                                        <div class="d-flex justify-content-between">
                                                                            <span>@lang('shop::app.customers.account.orders.view.invoices.shipping-handling-incl-tax')</span>
                                                                            <span>{{ core()->formatPrice($invoice->shipping_amount_incl_tax, $order->order_currency_code) }}</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="d-flex justify-content-between">
                                                                            <span>@lang('shop::app.customers.account.orders.view.invoices.shipping-handling')</span>
                                                                            <span>{{ core()->formatPrice($invoice->shipping_amount, $order->order_currency_code) }}</span>
                                                                        </div>
                                                                    @endif

                                                                    {!! view_render_event('bagisto.shop.customers.account.orders.view.invoices.shipping.after') !!}
                                                                    {!! view_render_event('bagisto.shop.customers.account.orders.view.invoices.discount.before') !!}

                                                                    @if ($invoice->base_discount_amount > 0)
                                                                        <div class="d-flex justify-content-between">
                                                                            <span>@lang('shop::app.customers.account.orders.view.invoices.discount')</span>
                                                                            <span>{{ core()->formatPrice($invoice->discount_amount, $order->order_currency_code) }}</span>
                                                                        </div>
                                                                    @endif

                                                                    {!! view_render_event('bagisto.shop.customers.account.orders.view.invoices.discount.after') !!}
                                                                    {!! view_render_event('bagisto.shop.customers.account.orders.view.invoices.tax-amount.before') !!}

                                                                    <div class="d-flex justify-content-between">
                                                                        <span>@lang('shop::app.customers.account.orders.view.invoices.tax')</span>
                                                                        <span>{{ core()->formatPrice($invoice->tax_amount, $order->order_currency_code) }}</span>
                                                                    </div>

                                                                    {!! view_render_event('bagisto.shop.customers.account.orders.view.invoices.tax-amount.after') !!}
                                                                    {!! view_render_event('bagisto.shop.customers.account.orders.view.invoices.grand-total.before') !!}

                                                                    <div class="d-flex justify-content-between fw-semibold">
                                                                        <span>@lang('shop::app.customers.account.orders.view.invoices.grand-total')</span>
                                                                        <span>{{ core()->formatPrice($invoice->grand_total, $order->order_currency_code) }}</span>
                                                                    </div>

                                                                    {!! view_render_event('bagisto.shop.customers.account.orders.view.invoices.grand-total.after') !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                @endif

                                            </div>

                                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                                @if ($order->shipments->count())
                                                    @foreach ($order->shipments as $shipment)
                                                        <div class="d-none d-md-block">
                                                            <!-- Tracking Number -->
                                                            <div class="mb-3">
                                                                <label class="h6 mb-1 fw-medium">
                                                                    @lang('shop::app.customers.account.orders.view.shipments.tracking-number')
                                                                </label> 
                                                                <span> {{ $shipment->track_number }}</span>
                                                            </div>

                                                            <!-- Shipment Title -->
                                                            <div class="mb-4 h6 fw-medium">
                                                                <span>
                                                                    @lang('shop::app.customers.account.orders.view.shipments.individual-shipment', ['shipment_id' => $shipment->id])
                                                                </span>
                                                            </div>

                                                            <!-- Table of Contents -->
                                                            <div class="table-responsive border rounded">
                                                                <table class="table align-middle text-nowrap mb-0">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>@lang('shop::app.customers.account.orders.view.shipments.sku')</th>
                                                                            <th>@lang('shop::app.customers.account.orders.view.shipments.product-name')</th>
                                                                            <th>@lang('shop::app.customers.account.orders.view.shipments.qty')</th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                        @foreach ($shipment->items as $item)
                                                                            <tr>
                                                                                <td>{{ $item->sku }}</td>
                                                                                <td>
                                                                                    {{ $item->name }}

                                                                                    @if (isset($item->additional['attributes']))
                                                                                        <div class="mt-1 small">
                                                                                            @foreach ($item->additional['attributes'] as $attribute)
                                                                                                <strong>{{ $attribute['attribute_name'] }}:</strong> {{ $attribute['option_label'] }}<br>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    @endif
                                                                                </td>
                                                                                <td>{{ $item->qty }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>

                                            <div class="tab-pane fade" id="pills-refund" role="tabpanel" aria-labelledby="pills-contact-tab">
                                                @if ($order->refunds->count())

                                                    @foreach ($order->refunds as $refund)
                                                        <div class="d-none d-md-block">
                                                            <!-- Refund Heading -->
                                                            <div class="mb-3 h6 fw-medium">
                                                                <span>
                                                                    @lang('shop::app.customers.account.orders.view.refunds.individual-refund', ['refund_id' => $refund->id])
                                                                </span>
                                                            </div>

                                                            <!-- Refund Items Table -->
                                                            <div class="table-responsive border rounded">
                                                                <table class="table align-middle text-nowrap mb-0">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>@lang('shop::app.customers.account.orders.view.refunds.sku')</th>
                                                                            <th>@lang('shop::app.customers.account.orders.view.refunds.product-name')</th>
                                                                            <th>@lang('shop::app.customers.account.orders.view.refunds.price')</th>
                                                                            <th>@lang('shop::app.customers.account.orders.view.refunds.qty')</th>
                                                                            <th>@lang('shop::app.customers.account.orders.view.refunds.subtotal')</th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                        @foreach ($refund->items as $item)
                                                                            <tr>
                                                                                <td>
                                                                                    {{ $item->child ? $item->child->sku : $item->sku }}
                                                                                </td>

                                                                                <td>
                                                                                    {{ $item->name }}
                                                                                    @if (isset($item->additional['attributes']))
                                                                                        <div class="mt-1 small">
                                                                                            @foreach ($item->additional['attributes'] as $attribute)
                                                                                                <strong>{{ $attribute['attribute_name'] }}:</strong> {{ $attribute['option_label'] }}<br>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    @endif
                                                                                </td>

                                                                                <td>
                                                                                    @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                                                                        {{ core()->formatPrice($item->price_incl_tax, $order->order_currency_code) }}
                                                                                    @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                                                                        {{ core()->formatPrice($item->price_incl_tax, $order->order_currency_code) }}
                                                                                        <div class="text-muted small">
                                                                                            @lang('shop::app.customers.account.orders.view.information.excl-tax'):
                                                                                            <strong>{{ core()->formatPrice($item->price, $order->order_currency_code) }}</strong>
                                                                                        </div>
                                                                                    @else
                                                                                        {{ core()->formatPrice($item->price, $order->order_currency_code) }}
                                                                                    @endif
                                                                                </td>

                                                                                <td>
                                                                                    {{ $item->qty }}
                                                                                </td>

                                                                                <td>
                                                                                    @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                                                                        {{ core()->formatPrice($item->total_incl_tax, $order->order_currency_code) }}
                                                                                    @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                                                                        {{ core()->formatPrice($item->total_incl_tax, $order->order_currency_code) }}
                                                                                        <div class="text-muted small">
                                                                                            @lang('shop::app.customers.account.orders.view.information.excl-tax'):
                                                                                            <strong>{{ core()->formatPrice($item->total, $order->order_currency_code) }}</strong>
                                                                                        </div>
                                                                                    @else
                                                                                        {{ core()->formatPrice($item->total, $order->order_currency_code) }}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach

                                                                        @if (! $refund->items->count())
                                                                            <tr>
                                                                                <td colspan="5">@lang('shop::app.customers.account.orders.view.refunds.no-result-found')</td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>


                                                    @endforeach

                                                @endif
                                            </div>
                                        </div>

                                        <!-- Desktop View -->
                                        <div class="mt-5 pt-4 border-top d-none d-md-flex flex-wrap justify-content-between gap-4">
                                            <!-- Billing Address -->
                                            @if ($order->billing_address)
                                                <div class="d-grid" style="max-width: 200px; gap: 1rem;">
                                                    <p class="text-muted mb-0">
                                                        @lang('shop::app.customers.account.orders.view.billing-address')
                                                    </p>

                                                    <div class="d-grid" style="gap: 0.75rem;">
                                                        <p class="mb-0 small">
                                                            @php
                                                                // dd($order->billing_address);
                                                            @endphp
                                                            @include ('shop::customers.account.orders.view.address', ['address' => $order->billing_address])
                                                        </p>
                                                    </div>

                                                    {!! view_render_event('bagisto.shop.customers.account.orders.view.billing_address_details.after', ['order' => $order]) !!}
                                                </div>
                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.billing_address.after', ['order' => $order]) !!}
                                            @endif

                                            <!-- Shipping Address -->
                                            @if ($order->shipping_address)
                                                <div class="d-grid" style="max-width: 200px; gap: 1rem;">
                                                    <p class="text-muted mb-0">
                                                        @lang('shop::app.customers.account.orders.view.shipping-address')
                                                    </p>

                                                    <div class="d-grid" style="gap: 0.75rem;">
                                                        <p class="mb-0 small">
                                                            @include ('shop::customers.account.orders.view.address', ['address' => $order->shipping_address])
                                                        </p>
                                                    </div>

                                                    {!! view_render_event('bagisto.shop.customers.account.orders.view.shipping_address_details.after', ['order' => $order]) !!}
                                                </div>
                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.shipping_address.after', ['order' => $order]) !!}

                                                <!-- Shipping Method -->
                                                <div class="d-grid align-self-start" style="max-width: 200px; gap: 1rem;">
                                                    <p class="text-muted mb-0">
                                                        @lang('shop::app.customers.account.orders.view.shipping-method')
                                                    </p>

                                                    <p class="mb-0 small">
                                                        {{ $order->shipping_title }}
                                                    </p>

                                                    {!! view_render_event('bagisto.shop.customers.account.orders.view.shipping_method_details.after', ['order' => $order]) !!}
                                                </div>
                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.shipping_method.after', ['order' => $order]) !!}
                                            @endif

                                            <!-- Payment Method -->
                                            <div class="d-grid align-self-start" style="max-width: 200px; gap: 1rem;">
                                                <p class="text-muted mb-0">
                                                    @lang('shop::app.customers.account.orders.view.payment-method')
                                                </p>

                                                <p class="mb-0 small">
                                                    {{ core()->getConfigData('sales.payment_methods.' . $order->payment->method . '.title') }}
                                                </p>

                                                @if (! empty($additionalDetails))
                                                    <div class="instructions">
                                                        <label>{{ $additionalDetails['title'] }}</label>
                                                    </div>
                                                @endif

                                                {!! view_render_event('bagisto.shop.customers.account.orders.view.payment_method_details.after', ['order' => $order]) !!}
                                            </div>
                                            {!! view_render_event('bagisto.shop.customers.account.orders.view.payment_method.after', ['order' => $order]) !!}
                                        
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</x-shop::layouts.account>
