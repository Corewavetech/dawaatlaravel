@php
    $customer = auth()->guard('customer')->user();    
@endphp

<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        Help & Support 
    </x-slot>
    
    <section>
        <div class="container-fluid">

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
                                <a href="{{ route('shop.customers.account.orders.index') }}" class="list-group-item list-group-item-action"><i
                                        class="fa-solid fa-cart-arrow-down mr-2"></i></i> My Orders</a>
                                <!-- <a href="/wishlist.html" class="list-group-item list-group-item-action">Wishlist</a> -->
                                <a href="{{ route('shop.customers.account.addresses.index') }}" class="list-group-item list-group-item-action"><i
                                        class="fa-solid fa-location-dot mr-2"></i></i> Save Address</a>
                                <a href="{{ route('shop.customers.account.support') }}" class="list-group-item list-group-item-action active"><i
                                        class="fa-solid fa-headphones mr-2"></i> Help &
                                    Support</a>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="card border-0">
                                <div class="card-body">
                            
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h4>Help & Support</h4>
                                                <a
                                                    href="{{ route('shop.customer.session.destroy') }}" 
                                                    onclick="event.preventDefault(); document.getElementById('customerLogout').submit();"
                                                    class="btn btn-outline-danger">
                                                    Logout
                                                </a>
                                            </div>                                           
                                            <hr>
                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div style="height: 50vh">
                                                    <h5 class="mt-5">If you need any kind of help please contact us at</h5> 
                                                    <a href="mailto:{{ $admin->email }}"><h4> <u class=""> {{ $admin->email }} </u></h4></a>
                                                </div>
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