<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.wishlist.page-title')
    </x-slot>    
    
    <section
        style="background-image: url('{{ bagisto_asset('website/images/background-pattern.jpg') }}');background-repeat: no-repeat;background-size: cover;">
        <div class="main-sections">
            <div class="container-fluid">
                <div class="hero_banner">
                    <img src="{{ bagisto_asset('website/images/png/heroBanner.png') }}" />
                </div>
            </div>
        </div>
    </section>

    <div class="mb-5">

        @include('shop::customers.account.wishlist.item')  
    </div>


</x-shop::layouts.account>
