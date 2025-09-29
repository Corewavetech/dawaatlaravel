@php
    $customer = auth()->guard('customer')->user();    
@endphp

<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        User Addresses
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
                                <a href="{{ route('shop.customers.account.addresses.index') }}" class="list-group-item list-group-item-action active"><i
                                        class="fa-solid fa-location-dot mr-2"></i></i> Save Address</a>
                                <a href="{{ route('shop.customers.account.support') }}" class="list-group-item list-group-item-action"><i
                                        class="fa-solid fa-headphones mr-2"></i> Help &
                                    Support</a>
                            </div>
                        </div>
                        
                        <div class="col-md-9">
                            <div class="card border-0">
                                <div class="card-body">
                                    <div class="row">

                                        <form action="{{ route('shop.customer.session.destroy') }}" method="POST" id="customerLogout">
                                        @csrf
                                        @method('DELETE')
                                        </form>
                                        
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h4>All Saved Addresses</h4>
                                                <a
                                                    href="{{ route('shop.customer.session.destroy') }}" 
                                                    onclick="event.preventDefault(); document.getElementById('customerLogout').submit();"
                                                    class="btn btn-outline-danger">
                                                    Logout
                                                </a>
                                            </div>
                                            <a
                                                href="{{ route('shop.customers.account.addresses.create') }}"
                                                class="btn btn-outline-secondary px-4 py-2 fw-normal"
                                            >
                                                @lang('shop::app.customers.account.addresses.index.add-address')
                                            </a>

                                            <hr>
                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="wrapper wrapper-content animated fadeInRight">
                                                    <div class="address_list">

                                                        @foreach ($addresses as $address)
                                                            <div class="forum-item active">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <div class="forum-icon">
                                                                            <i class="fa-solid fa-location-dot"></i>
                                                                        </div>
                                                                        <h5 class="text-muted">{{ $address->first_name }} {{ $address->last_name }} 

                                                                             @if ($address->company_name)
                                                                                ({{ $address->company_name }})
                                                                            @endif

                                                                            @if ($address->default_address)                                                                                
                                                                                (@lang('shop::app.customers.account.addresses.index.default-address') )                                                                                
                                                                            @endif

                                                                        </h5>
                                                                        <div class="forum-sub-title">                                                                            
                                                                            <p class="text-muted">
                                                                                {{ $address->address }},

                                                                                {{ $address->city }}, 
                                                                                {{ $address->state }}, {{ $address->country }}, 
                                                                                {{ $address->postcode }}
                                                                            </p>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1 forum-info">
                                                                        <a href="{{ route('shop.customers.account.addresses.edit', $address->id) }}"
                                                                            class="btn btn-link rounded-pill  ">
                                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                                        </a>

                                                                    </div>                                                                                                                                      

                                                                    <div class="col-md-1 forum-info">
                                                                        <a 
                                                                            href="javascript:void(0);"                                                                               
                                                                            data-bs-toggle="modal"                                            
                                                                            data-bs-target="#deleteAddressModal" 
                                                                            class="btn btn-link display-4  rounded-pill">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </a>

                                                                    </div>

                                                                    <div class="col-md-2 forum-info">
                                                                        @if (!$address->default_address)
                                                                            <button type="button"
                                                                                href="javascript:void(0);"                                                                               
                                                                                data-bs-toggle="modal"                                            
                                                                                data-bs-target="#setDefaultAddressModal" 
                                                                                class="btn btn-primary invoiceButton">                                                                            
                                                                                @lang('shop::app.customers.account.addresses.index.set-as-default')
                                                                            </button>
                                                                        @endif

                                                                        @if ($address->default_address)
                                                                            <div class="badge bg-primary text-white">
                                                                                @lang('shop::app.customers.account.addresses.index.default-address')
                                                                            </div>
                                                                        @endif

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            
                                                            <div class="modal fade" id="deleteAddressModal" tabindex="-1"
                                                                aria-labelledby="deleteAddressModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form method="POST" ref="addressDelete" 
                                                                            class="w-100 rounded-1 p-4 border bg-white"
                                                                            action="{{ route('shop.customers.account.addresses.delete', $address->id) }}">

                                                                            @method('DELETE')
                                                                            @csrf
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="deleteAddressModalLabel">Warning
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">                                                                                
                                                                                <p>Are you sure want to delete this address</p>                                                                                
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Delete
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            
                                                            <div class="modal fade" id="setDefaultAddressModal" tabindex="-1"
                                                                aria-labelledby="setDefaultAddressModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form method="POST" ref="" 
                                                                            class="w-100 rounded-1 p-4 border bg-white"
                                                                            action="{{ route('shop.customers.account.addresses.update.default', $address->id) }}">
                                                                            @method('PATCH')
                                                                            @csrf
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="setDefaultAddressModalLabel">Confirm
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">                                                                                
                                                                                <p>Are you sure want to make this address default</p>                                                                                
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Confirm
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div> 

                                                        @endforeach                                                        

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
            </div>
    </section>

</x-shop::layouts.account>
