<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.customers.login-form.page-title')"/>
    <meta name="keywords" content="@lang('shop::app.customers.login-form.page-title')"/>
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
        max-width: 400px;
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

    .tab-content button {
        border-radius: 30px;
        background-color: #29348E;
        border-style: none;
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

    input{
        border: 1px solid #7f7d7d !important;
    }
</style>

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.login-form.page-title')
    </x-slot>

    <div class="container mt-5">        
    
        <div class="login-container ">

            {!! view_render_event('bagisto.shop.customers.login.logo.before') !!}
            <!-- Logo and Tabs -->
            <div class="text-center mb-4">
                <img src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('website/images/logo.png') }}" 
                class="logo" alt="{{ config('app.name') }}" />
            </div>
            
            {!! view_render_event('bagisto.shop.customers.login.logo.after') !!}

            <h4 style="text-align: center;">
                @lang('Log In')
            </h4> 
            
            <!-- Nav Pills -->
            <ul class="nav nav-pills justify-content-center mb-3" id="pills-tab" role="tablist">
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="login-tab" data-bs-toggle="pill" data-bs-target="#login"
                        type="button" role="tab" aria-controls="login" aria-selected="true">LOGIN</button>
                </li>             --}}
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Login Form -->
                <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">

                    {!! view_render_event('bagisto.shop.customers.login.before') !!}

                    <form action="{{route('shop.customer.session.sendotp')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <x-shop::form.control-group.label class="required">
                                    @lang('Mobile No.')
                                </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="text"
                                class="form-control"
                                name="phone"
                                rules="required"
                                value=""
                                :label="trans('phone')"
                                placeholder="9811XXXXXX"
                                :aria-label="trans('phone')"
                                aria-required="true"
                            />
                        </div>

                        <button type="submit" class="btn btn-primary w-100 text-white"
                            onclick="window.location.href='/verify-otp'">Log in</button>
                    </form>

                    {!! view_render_event('bagisto.shop.customers.login.after') !!}

                </div>

                <p class="mt-4 text-muted text-center">
                    @lang('shop::app.customers.login-form.new-customer')

                    <a
                        class="text-primary"
                        href="{{ route('shop.customers.register.index') }}"
                    >
                        @lang('shop::app.customers.login-form.create-your-account')
                    </a>
                </p>

                <div class="login-footer">
                    <p>Daawat is one of the best quality basmati rice brand in India.</p>
                </div>
            </div>
        </div>
        
    </div>

    
    
</x-shop::layouts>
