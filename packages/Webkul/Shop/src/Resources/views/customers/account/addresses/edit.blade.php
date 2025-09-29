@php
    $customer = auth()->guard('customer')->user();    
@endphp

<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.addresses.edit.edit')
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
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h4>Edit Address</h4>
                                                <a
                                                    href="{{ route('shop.customer.session.destroy') }}" 
                                                    onclick="event.preventDefault(); document.getElementById('customerLogout').submit();"
                                                    class="btn btn-outline-danger">
                                                    Logout
                                                </a>
                                            </div>                                           

                                            <hr>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <v-edit-customer-address>
                                                    <!--Address Shimmer-->
                                                    <x-shop::shimmer.form.control-group :count="10" />
                                                </v-edit-customer-address>
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

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-edit-customer-address-template"
        >

            <template v-if="isLoading">
                                              
            </template>

            <template v-else>                
                <x-shop::form method="PUT" :action="route('shop.customers.account.addresses.update',  $address->id)">

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.before') !!}

                    <!-- Company Name -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label>
                            @lang('shop::app.customers.account.addresses.create.company-name')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="company_name"
                            :value="old('company_name') ?? $address->company_name"
                            :label="trans('shop::app.customers.account.addresses.create.company-name')"
                            :placeholder="trans('shop::app.customers.account.addresses.create.company-name')"
                            class="form-control"
                        />

                        <x-shop::form.control-group.error control-name="company_name" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.company_name.after') !!}

                    <!-- First Name -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.account.addresses.create.first-name')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="first_name"
                            rules="required"
                            :value="old('first_name') ?? $address->first_name"
                            :label="trans('shop::app.customers.account.addresses.create.first-name')"
                            :placeholder="trans('shop::app.customers.account.addresses.create.first-name')"
                            class="form-control"
                        />

                        <x-shop::form.control-group.error control-name="first_name" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.first_name.after') !!}

                    <!-- Last Name -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.account.addresses.create.last-name')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="last_name"
                            rules="required"
                            :value="old('last_name') ?? $address->last_name"
                            :label="trans('shop::app.customers.account.addresses.create.last-name')"
                            :placeholder="trans('shop::app.customers.account.addresses.create.last-name')"
                            class="form-control"
                        />

                        <x-shop::form.control-group.error control-name="last_name" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.last_name.after') !!}

                    <!-- E-mail -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.account.addresses.create.email')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="email"
                            rules="required|email"
                            :value="old('email') ?? $address->email"
                            :label="trans('shop::app.customers.account.addresses.create.email')"
                            :placeholder="trans('shop::app.customers.account.addresses.create.email')"
                            class="form-control"
                        />

                        <x-shop::form.control-group.error control-name="email" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.email.after') !!}

                    <!-- Vat Id -->
                    <div style="display:none;">
                        <x-shop::form.control-group >
                            <x-shop::form.control-group.label>
                                @lang('shop::app.customers.account.addresses.create.vat-id')
                            </x-shop::form.control-group.label>
    
                            <x-shop::form.control-group.control
                                type="text"
                                name="vat_id"
                                :value="old('vat_id') ?? $address->vat_id"
                                :label="trans('shop::app.customers.account.addresses.create.vat-id')"
                                :placeholder="trans('shop::app.customers.account.addresses.create.vat-id')"
                                class="form-control"
                            />
    
                            <x-shop::form.control-group.error control-name="vat_id" />
                        </x-shop::form.control-group>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.vat_id.after') !!}

                    @php
                        $addresses = explode(PHP_EOL, $address->address);
                    @endphp

                    <!-- Street Address -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.account.addresses.create.street-address')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="address[]"
                            rules="required|address"
                            :value="collect(old('address'))->first() ?? $addresses[0]"
                            :label="trans('shop::app.customers.account.addresses.create.street-address')"
                            :placeholder="trans('shop::app.customers.account.addresses.create.street-address')"
                            class="form-control"
                        />

                        <x-shop::form.control-group.error control-name="address[]" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.street_address.after') !!}

                    @if (
                        core()->getConfigData('customer.address.information.street_lines')
                        && core()->getConfigData('customer.address.information.street_lines') > 1
                    )
                        @for ($i = 1; $i < core()->getConfigData('customer.address.information.street_lines'); $i++)
                            <x-shop::form.control-group.control
                                type="text"
                                name="address[{{ $i }}]"
                                :value="old('address[{{ $i }}]', $addresses[$i] ?? '')"
                                rules="address"
                                :label="trans('shop::app.customers.account.addresses.create.street-address')"
                                :placeholder="trans('shop::app.customers.account.addresses.create.street-address')"
                                class="form-control"
                            />

                            <x-shop::form.control-group.error
                                class="mb-2"
                                name="address[{{ $i }}]"
                            />
                        @endfor
                    @endif

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.street_address.after') !!}

                    <!-- Country List -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="{{ core()->isCountryRequired() ? 'required' : '' }}">
                            @lang('shop::app.customers.account.addresses.create.country')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="select"
                            name="country"
                            rules="{{ core()->isCountryRequired() ? 'required' : '' }}"
                            v-model="addressData.country"
                            :aria-label="trans('shop::app.customers.account.addresses.create.country')"
                            :label="trans('shop::app.customers.account.addresses.create.country')"
                            class="form-select"
                        >
                            <option value="">
                                @lang('shop::app.customers.account.addresses.create.select-country')
                            </option>

                            @foreach (core()->countries() as $country)
                                <option 
                                        {{ $country->code === config('app.default_country') ? 'selected' : '' }}  
                                        value="{{ $country->code }}"
                                    >
                                        {{ $country->name }}
                                    </option>
                            @endforeach
                        </x-shop::form.control-group.control>

                        <x-shop::form.control-group.error control-name="country" />
                    </x-shop::form.control-group>

                    <!-- State Name -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="{{ core()->isStateRequired() ? 'required' : '' }}">
                            @lang('shop::app.customers.account.addresses.create.state')
                        </x-shop::form.control-group.label>

                        <template v-if="haveStates()">
                            <x-shop::form.control-group.control
                                type="select"
                                id="state"
                                name="state"
                                rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                                v-model="addressData.state"
                                :label="trans('shop::app.customers.account.addresses.edit.state')"
                                :placeholder="trans('shop::app.customers.account.addresses.edit.state')"
                                class="form-select"
                            >                            
                                <option value="">
                                    Select State
                                </option>

                                <option
                                    v-for="(state, index) in countryStates[addressData.country] || []"
                                    :value="state.code"
                                    :key="index"
                                >
                                    @{{ state.default_name }}
                                </option>

                            </x-shop::form.control-group.control>
                        </template>

                        <template v-else>
                            <x-shop::form.control-group.control
                                type="text"
                                name="state"
                                rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                                :value="old('state') ?? $address->state"
                                :label="trans('shop::app.customers.account.addresses.edit.state')"
                                :placeholder="trans('shop::app.customers.account.addresses.edit.state')"
                            />
                        </template>

                        <x-shop::form.control-group.error control-name="state" />
                    </x-shop::form.control-group>

                    <!-- City -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.account.addresses.create.city')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="city"
                            rules="required"
                            :value="old('city') ?? $address->city"
                            :label="trans('shop::app.customers.account.addresses.create.city')"
                            :placeholder="trans('shop::app.customers.account.addresses.create.city')"
                            class="form-control"
                        />

                        <x-shop::form.control-group.error control-name="city" />
                    </x-shop::form.control-group>

                    <!-- Zip/Postal Code -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.account.addresses.create.post-code')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="postcode"
                            rules="required"
                            :value="old('postcode') ?? $address->postcode"
                            :label="trans('shop::app.customers.account.addresses.create.post-code')"
                            :placeholder="trans('shop::app.customers.account.addresses.create.post-code')"
                            class="form-control"
                        />

                        <x-shop::form.control-group.error control-name="postcode" />
                    </x-shop::form.control-group>

                    <!-- Phone -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.account.addresses.create.phone')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="phone"
                            rules="required"
                            :value="old('phone') ?? $address->phone"
                            :label="trans('shop::app.customers.account.addresses.create.phone')"
                            :placeholder="trans('shop::app.customers.account.addresses.create.phone')"
                            class="form-control"
                        />

                        <x-shop::form.control-group.error control-name="phone" />
                    </x-shop::form.control-group>                    

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >
                        @lang('shop::app.customers.account.addresses.create.save')
                    </button>
                </x-shop::form>
            </template>

        </script>

        <script type="module">
            app.component('v-edit-customer-address', {
                template: '#v-edit-customer-address-template',

                data() {
                    return {
                        addressData: {
                            country: "{{ old('country') ?? $address->country }}",

                            state: "{{ old('state') ?? $address->state }}",
                        },

                        countryStates: @json(core()->groupedStatesByCountries()),
                    };
                },
    
                methods: {
                    haveStates() {
                        return !!this.countryStates[this.addressData.country]?.length;
                    },
                },
            });
        </script>

    @endPushOnce
    
</x-shop::layouts.account>
