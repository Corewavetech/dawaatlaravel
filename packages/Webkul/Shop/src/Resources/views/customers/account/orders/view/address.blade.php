{{-- Desktop View --}}
<div class="d-none d-md-flex flex-column">
    <p class="fw-semibold text-dark mb-1">
        {{ $address->company_name ?? '' }}
    </p>

    <p class="fw-semibold text-dark mb-1">
        {{ $address->name }}
    </p>
    
    <p class="fw-semibold mb-0">
        {{ $address->address }}<br>
        {{ $address->city }}<br>
        {{ $address->state }}<br>
        {{ core()->country_name($address->country) }}
        @if ($address->postcode)
            ({{ $address->postcode }})
        @endif<br>
        {{ __('shop::app.customers.account.orders.view.contact') }} : {{ $address->phone }}
    </p>
</div>

{{-- Mobile View --}}
{{-- <div class="d-block d-md-none text-dark">
    <p class="fw-semibold mb-1">
        {{ $address->company_name ?? '' }}
    </p>

    <p class="small mb-0">
        {{ $address->name }}<br>
        {{ $address->address }}<br>
        {{ $address->city }}<br>
        {{ $address->state }}<br>
        {{ core()->country_name($address->country) }}
        @if ($address->postcode)
            ({{ $address->postcode }})
        @endif<br>
        <span>
            {{ __('shop::app.customers.account.orders.view.contact') }} : {{ $address->phone }}
        </span>
    </p>
</div> --}}
