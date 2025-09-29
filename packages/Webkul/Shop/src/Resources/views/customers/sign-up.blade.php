<!-- SEO Meta Content -->
@push('meta')
    <meta
        name="description"
        content="@lang('shop::app.customers.signup-form.page-title')"
    />

    <meta
        name="keywords"
        content="@lang('shop::app.customers.signup-form.page-title')"
    />
@endPush

<style>
    body {
        background-color: #f8f9fa;
    }

    .login-footer {
        text-align: center;
        color: gray;
    }

    .login-container {
        max-width: 500px;
        margin: 50px auto;
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .tab-content input {
        border-radius: 30px;
    }

    .nav-pills .nav-link {
        border-radius: 0;
        font-weight: 500;
        color: #000;
    }

    .nav-pills .nav-link.active {
        background-color: transparent;
        border-bottom: 2px solid #29348E;
        color: #29348E;
    }

    .submit_button {
        border-radius: 30px;
        background-color: #29348E !important;
        border-style: none;
    }

    .submit_button:hover{
        /* background-color: unset !important; */
    }

    .form-check-label,
    .forgot-link {
        font-size: 0.9rem;
    }

    .forgot-link {
        text-decoration: none;
        float: right;
    }

    .logo {
        width: 120px;
    }

    .form-control, .form-check-input{
        border: 1px solid #7f7d7d !important;
    }

</style>

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>
        @lang('Register')
    </x-slot>

    <div class="container mt-5">
        
        <div class="login-container ">

            {!! view_render_event('bagisto.shop.customers.sign-up.logo.before') !!}
            <!-- Logo and Tabs -->
            <div class="text-center mb-4">
                <img src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('website/images/logo.png') }}" 
                    class="logo" alt="{{ config('app.name') }}" />
            </div>

            {!! view_render_event('bagisto.shop.customers.sign-up.logo.after') !!}

            <h4 style="text-align: center;">
                @lang('Register')
            </h4>        

            <form method="post" action="{{ route('shop.customers.register.add') }}">
                @csrf
                {!! view_render_event('bagisto.shop.customers.signup_form_controls.before') !!}
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="form-label required">
                        @lang('shop::app.customers.signup-form.first-name')*
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        class="form-control"
                        name="first_name"
                        rules="required"
                        :value="old('first_name')"
                        :label="trans('shop::app.customers.signup-form.first-name')"
                        :placeholder="trans('shop::app.customers.signup-form.first-name')"
                        :aria-label="trans('shop::app.customers.signup-form.first-name')"
                        aria-required="true"
                    />

                    <x-shop::form.control-group.error control-name="first_name" />
                </x-shop::form.control-group>

                <!-- Last Name -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="form-label required">
                        @lang('shop::app.customers.signup-form.last-name')*
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        class="form-control"
                        name="last_name"
                        rules="required"
                        :value="old('last_name')"
                        :label="trans('shop::app.customers.signup-form.last-name')"
                        :placeholder="trans('shop::app.customers.signup-form.last-name')"
                        :aria-label="trans('shop::app.customers.signup-form.last-name')"
                        aria-required="true"
                    />

                    <x-shop::form.control-group.error control-name="last_name" />
                </x-shop::form.control-group>

                <!-- Phone -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="form-label required">
                        @lang('Phone')*
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        class="form-control"
                        name="phone"
                        rules="required"
                        :value="old('phone')"
                        :label="trans('Phone')"
                        placeholder="9811XXXX35"
                        :aria-label="trans('Phone')"
                        aria-required="true"
                    />

                    <x-shop::form.control-group.error control-name="phone" />
                </x-shop::form.control-group>

                <!-- Email -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="form-label required">
                        @lang('shop::app.customers.signup-form.email')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="email"
                        class="form-control"
                        name="email"
                        rules="required|email"
                        :value="old('email')"
                        :label="trans('shop::app.customers.signup-form.email')"
                        placeholder="email@example.com"
                        :aria-label="trans('shop::app.customers.signup-form.email')"
                        aria-required="true"
                    />

                    <x-shop::form.control-group.error control-name="email" />
                </x-shop::form.control-group>  
                
                @if (core()->getConfigData('customer.settings.create_new_account_options.news_letter'))
                    <div class="form-check mb-3">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            id="is-subscribed"
                            name="is_subscribed"
                        />
                        <label class="form-check-label" for="is-subscribed">
                            @lang('shop::app.customers.signup-form.subscribe-to-newsletter')
                        </label>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary w-100 text-white submit_button"
                    onclick="window.location.href='/verify-otp'">Sign - Up</button>
            </form>

            <p class="text-center text-muted mt-3">
                @lang('shop::app.customers.signup-form.account-exists')
                <a href="{{ route('shop.customer.session.index') }}">
                    @lang('Log In')
                </a>
            </p>
            <br>

            <div class="login-footer">
                <p>Daawat is one of the best quality basmati rice brand in India.</p>
            </div>        
        </div>

    </div>    

</x-shop::layouts>

