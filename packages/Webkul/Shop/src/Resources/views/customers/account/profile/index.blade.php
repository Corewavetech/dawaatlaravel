<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.profile.index.title')
    </x-slot>

    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs name="profile" />
        @endSection
    @endif

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
                                    <h5>{{ $customer->first_name." ".$customer->last_name }} </h5>
                                    {{-- <p>rohini sectior 7 new delhi </p> --}}
                                </div>
                                <a href="{{ route('shop.customers.account.profile.index') }}" class="list-group-item list-group-item-action active"><i
                                        class="fa-regular fa-user mr-2"></i> Profile</a>
                                <a href="{{ route('shop.customers.account.orders.index') }}" class="list-group-item list-group-item-action"><i
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
                                    <div class="row">
                                        <div class="col-md-12">

                                            <form action="{{ route('shop.customer.session.destroy') }}" method="POST" id="customerLogout">
                                            @csrf
                                            @method('DELETE')
                                            </form>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <h4>My Profile</h4>
                                                <a href="{{ route('shop.customer.session.destroy') }}" 
                                                    onclick="event.preventDefault(); document.getElementById('customerLogout').submit();"
                                                    class="btn btn-outline-danger">
                                                    Logout
                                                </a>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="{{ route('shop.customers.account.profile.update') }}" method="post" enctype="multipart/form-data">   
                                                @csrf 
                                                <div class="form-group row mb-2">
                                                    <label for="name" class="col-4 col-form-label">Update Image</label>
                                                    <div class="col-8">                                                                                                                
                                                        <input id="image" name="image[]" placeholder="Image"
                                                            class="form-control here" type="file" value="">
                                                        @error('image')
                                                            <p style="color: red;">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-2">
                                                    <label for="name" class="col-4 col-form-label">First Name</label>
                                                    <div class="col-8">
                                                        <input id="first_name" name="first_name" placeholder="First Name"
                                                            class="form-control here" type="text" value="{{ $customer->first_name }}">
                                                        @error('first_name')
                                                            <p style="color: red;">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-2">
                                                    <label for="last_name" class="col-4 col-form-label">Last Name</label>
                                                    <div class="col-8">
                                                        <input id="last_name" name="last_name" placeholder="Last Name"
                                                            class="form-control here" type="text" value="{{ $customer->last_name }}">
                                                        @error('last_name')
                                                            <p style="color: red;">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-2">
                                                    <label for="last_name" class="col-4 col-form-label">Gender</label>
                                                    <div class="col-8">
                                                        <select name="gender" id="gender" class="form-control" required> 
                                                            <option value="Male" {{ $customer->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                            <option value="Female" {{ $customer->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                            <option value="Other" {{ $customer->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                                        </select>    
                                                        @error('gender')
                                                            <p style="color: red;">{{ $message }}</p>
                                                        @enderror                                                    
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-2">
                                                    <label for="email" class="col-4 col-form-label">Mobile*</label>
                                                    <div class="col-8">
                                                        <input id="phone" name="phone" placeholder="Mobile"
                                                            class="form-control here" required="required" type="text" value="{{ $customer->phone }}" >
                                                        @error('phone')
                                                            <p style="color: red;">{{ $message }}</p>
                                                        @enderror   
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-2">
                                                    <label for="email" class="col-4 col-form-label">Email*</label>
                                                    <div class="col-8">
                                                        <input id="email" name="email" placeholder="Email"
                                                            class="form-control here" required="required" type="text" value="{{ $customer->email }}">
                                                        @error('email')
                                                            <p style="color: red;">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-2">
                                                    <label for="publicinfo" class="col-4 col-form-label">Date Of Birth
                                                    </label>
                                                    <div class="col-8">
                                                        <input class="form-control" type="date" name="date_of_birth" value="{{ $customer->date_of_birth }}" id="date_of_birth" placeholder="YYYY-MM-DD">
                                                        @error('date_of_birth')
                                                            <p style="color: red;">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-2">
                                                    <div class="offset-4 col-8">
                                                        <button name="submit" type="submit"
                                                            class="btn btn-primary">Update
                                                            My Profile</button>
                                                    </div>
                                                </div>
                                            </form>
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
