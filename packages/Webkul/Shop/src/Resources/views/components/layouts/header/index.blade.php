{!! view_render_event('bagisto.shop.layout.header.before') !!}

{{-- @if(core()->getCurrentChannel()->locales()->count() > 1 || core()->getCurrentChannel()->currencies()->count() > 1 )
<div class="max-lg:hidden">
    <x-shop::layouts.header.desktop.top />
</div>
@endif --}}

{{-- <header class="shadow-gray sticky top-0 z-10 bg-white shadow-sm max-lg:shadow-none">
    <x-shop::layouts.header.desktop />

    <x-shop::layouts.header.mobile />
</header> --}}

@php
    $customer = auth('customer')->user();
  @endphp

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
    <div class="offcanvas-header justify-content-start ">
        <button type="button" class="btn-close text-end" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @if($customer != null)

            <div class="order-md-last">

                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Account Information</span>
                </h4>
                <div class="profile_item">
                    <a href="{{ route('shop.customers.account.profile.index') }}" class="active">
                        <button
                            class="btn btn-link w-100 {{ request()->is('*customer/account/profile') ? 'account-active-url' : '' }}"
                            type="button">View Profile</button>
                    </a>
                    <a href="{{ route('shop.customers.account.orders.index') }}">
                        <button
                            class="btn btn-link w-100 {{ request()->is('*customer/account/orders') ? 'account-active-url' : '' }}"
                            type="button">My Orders</button>
                    </a>
                    <a href="{{ route('shop.customers.account.addresses.index') }}">
                        <button
                            class="btn btn-link w-100 {{ request()->is('*customer/account/addresses') ? 'account-active-url' : '' }}"
                            type="button">Save Address</button>
                    </a>
                    <a href="/support.html"> <button class="btn btn-link w-100" type="button">Help & Support</button></a>
                </div>
                <form action="{{ route('shop.customer.session.destroy') }}" method="POST" id="customerLogout">
                    @csrf
                    @method('DELETE')
                </form>

                <a class="w-100 btn btn-primary btn-lg mt-3" href="{{ route('shop.customer.session.destroy') }}"
                    onclick="event.preventDefault(); document.getElementById('customerLogout').submit();">Logout</a>
            </div>

        @else

            <div class="order-md-last">

                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Welcome to Daawat</span>
                </h4>
                <div class="profile_item">
                    <p>For daily use, Daawat Rozana Gold Basmati Rice can be a good option
                        because of its good quality, affordability, and versatility in many
                        dishes, making it a suitable choice for everyday use.</p>
                </div>
                <div class="d-flex justify-content-between ">
                    <a href="{{ route('shop.customer.session.index') }}" class="w-100 btn btn-primary  mt-3 mx-2"
                        type="submit">Login</a>
                    <a href="{{ route('shop.customers.register.index') }}" class="w-100 btn btn-outline-primary mt-3"
                        type="submit">Sign up</a>
                </div>
            </div>

        @endif
    </div>
</div>

{{-- <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasSearch"
    aria-labelledby="Search">
    <div class="offcanvas-header justify-content-center">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Search</span>
            </h4>
            <form role="search" action="index.html" method="get" class="d-flex mt-3 gap-0">
                <input class="form-control rounded-start rounded-0 bg-light" type="email"
                    placeholder="What are you looking for?" aria-label="What are you looking for?">
                <button class="btn btn-dark rounded-end rounded-0" type="submit">Search</button>
            </form>
        </div>
    </div>
</div> --}}

<header>

    <div class="container-fluid">
        <div class="row py-3 border-bottom">

            <div class="col-sm-4 col-lg-3 text-center text-sm-start">
                <div class="main-logo">
                    <a href="{{ route('shop.home.index') }}">
                        <img src="{{ bagisto_asset('website/images/logo.png') }}" alt="logo" class="img-fluid">
                    </a>
                </div>
            </div>
            <div class="container-fluid col-sm-6 offset-sm-2 offset-md-0 col-lg-5  d-lg-block">

                <div class="d-lg-row ">
                    <div class="d-flex  justify-content-center justify-content-sm-between align-items-center">
                        <nav class="main-menu d-flex navbar navbar-expand-lg">

                            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                                aria-labelledby="offcanvasNavbarLabel">

                                <div class="offcanvas-header justify-content-start">
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>

                                <div class="offcanvas-body">
                                    <ul
                                        class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 mb-0">
                                        <li class="nav-item {{ request()->is('/') ? 'active' : '' }} hover-underline">
                                            <a href="{{route('shop.home.index')}}" class="nav-link ">Home</a>
                                        </li>
                                        <li
                                            class="nav-item {{ request()->is('*categories*') ? 'active' : '' }} hover-underline ">
                                            <a href="{{ route('shop.api.categories.all') }}"
                                                class="nav-link">Product</a>
                                        </li>
                                        <li class="nav-item hover-underline">
                                            <a href="{{ route('shop.subscriptions.plans.index') }}"
                                                class="nav-link">Subscription</a>
                                        </li>
                                        <li class="nav-item hover-underline">
                                            <a href="{{ route('shop.blogs.index') }}" class="nav-link">Blog</a>
                                        </li>

                                    </ul>

                                </div>

                            </div>
                    </div>
                </div>
            </div>

            <div
                class="col-sm-8 col-lg-4 d-flex justify-content-end gap-2 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">
                <div class="support-box text-end d-none d-xl-block">
                    <span class="fs-6 bg-white px-3 py-2 rounded-5 d-flex">
                        <img src="{{ bagisto_asset('website/images/png/lp logo.png') }}" class="lp_logo" />
                        <span id="loyality_text">Loyalty Points</span>
                    </span>

                </div>

                <form action="{{ route('shop.search.index') }}" role="search">
                    <div class="position-relative d-flex align-items-center">

                        <input type="text" name="query" value="{{ request('query') }}"
                            minlength="{{ core()->getConfigData('catalog.products.search.min_query_length') }}"
                            maxlength="{{ core()->getConfigData('catalog.products.search.max_query_length') }}"
                            placeholder="@lang('shop::app.components.layouts.header.search-text')"
                            aria-label="@lang('shop::app.components.layouts.header.search-text')" aria-required="true"
                            pattern="[^\\]+" id="searchInput" class="form-control search-input" placeholder="Search..."
                            required />

                        <button type="submit" class="hidden" style="display: none;"
                            aria-label="@lang('shop::app.components.layouts.header.submit')">

                        </button>
                        <a id="searchToggle" href="javascript:void(0);" class="rounded-circle bg-light mx-1">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#search"></use>
                            </svg>
                        </a>
                    </div>
                </form>

                <ul class="d-flex justify-content-end list-unstyled m-0">
                    <li>

                    </li>
                    <li>
                        <a href="{{ route('shop.checkout.cart.index') }}"
                            class="rounded-circle bg-light p-2 mx-1 position-relative">

                            @if(core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                                @include('shop::checkout.cart.mini-cart')
                            @endif

                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shop.customers.account.wishlist.index') }}"
                            class="rounded-circle bg-light p-2 mx-1  position-relative">
                            @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                                {{-- @lang('shop::app.components.layouts.header.wishlist') --}}
                                @include('shop::checkout.wishlist.wishlist')
                            @endif
                        </a>
                    </li>
                    <!-- <li class="d-lg-none">
              <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <use xlink:href="#cart"></use>
                </svg>
              </a>
            </li> -->
                    <!-- <li class="d-lg-none">
              <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <use xlink:href="#search"></use>
                </svg>
              </a>
            </li> -->
                    <div class="cart text-end d-none d-lg-block dropdown mt-1">
                        <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                            <span class="fs-6 text-muted dropdown-toggle"><svg width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <use xlink:href="#user"></use>
                                </svg></span>
                            <!-- <span class="cart-total fs-5 fw-bold">$1290.00</span> -->
                        </button>
                    </div>
                </ul>


            </div>

        </div>
    </div>


</header>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.body.addEventListener("click", function (e) {
                if (e.target.closest('#searchToggle')) {
                    const searchInput = document.getElementById("searchInput");
                    const loyalityText = document.getElementById("loyality_text");

                    if (searchInput && loyalityText) {
                        searchInput.classList.toggle("expanded");

                        if (searchInput.classList.contains("expanded")) {
                            loyalityText.style.display = "none";
                            searchInput.focus();
                        } else {
                            loyalityText.style.display = "inline-block";
                            searchInput.blur();
                        }
                    }
                }
            });
        });
    </script>

@endpush
{!! view_render_event('bagisto.shop.layout.header.after') !!}