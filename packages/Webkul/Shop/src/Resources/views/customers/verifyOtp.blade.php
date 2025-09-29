@php
    $otp = session('otp');
    $phone = session('phone');
@endphp
@push('meta')
    <meta name="description" content="@lang('Verify OTP')"/>
    <meta name="keywords" content="@lang('vefiry OTP')"/>
@endPush

@push('styles')
<style>
    .wrapper {
        background-image: url("{{ bagisto_asset('/website/images/background-pattern.jpg') }}");
        background-position: bottom center;
        background-size: contain;
        background-attachment: fixed;
        height: 100vh;
        width: 100%;
    }
    input{
        border: 1px solid #7f7d7d !important;
    }

    .submit_button {        
        background-color: #29348E !important;        
    }
</style>
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>


<section class="wrapper py-5">
    <div class="container">
        <div class="login col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-5 offset-xl-3 text-center">
            <!-- Pills content -->
            <form class="rounded bg-white shadow p-5 text-start" method="post" action="{{ route('shop.customer.session.verifylogin') }}">
                @csrf
                <div class="text-center mb-4">
                    <img src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('website/images/logo.png') }}" class="img-fluid" alt="{{ config('app.name') }}">
                    <h3 class="text-dark fw-bold fs-4 mt-3">Verify OTP ({{ $otp ?? '' }})</h3>
                    <div class="fw-normal text-muted">Enter the verification code we sent to</div>
                </div>

                <div class="d-flex align-items-center justify-content-center fw-bold mb-4">
                    <!-- OTP dots -->
                    <span class="mx-1">*</span>
                    <span class="mx-1">*</span>
                    <span class="mx-1">*</span>
                    <span class="mx-1">*</span>
                    <span class="mx-1">*</span>
                    <span class="mx-1">*</span>
                    <span class="ms-3">{{ substr($phone, -4) }}</span>
                </div>

                <div class="otp_input mb-3">
                    <label for="digit" class="form-label">Type your 4 digit security code</label>
                    <div class="d-flex justify-content-between gap-5">
                        <input name="otp_1" type="text" class="form-control me-2 otp-input" maxlength="1">
                        <input name="otp_2" type="text" class="form-control me-2 otp-input" maxlength="1">
                        <input name="otp_3" type="text" class="form-control me-2 otp-input" maxlength="1">
                        <!-- <input type="text" class="form-control me-2" maxlength="1">
                                <input type="text" class="form-control me-2" maxlength="1"> -->
                        <input name="otp_4" type="text" class="form-control otp-input" maxlength="1">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 text-white my-3 submit_button">Submit</button>

                <div class="text-center text-muted">
                    Didn’t get the code?
                    <a href="#" class="text-decoration-none fw-bold">Resend</a>
                </div>
            </form>
            <!-- Pills content -->
        </div>
    </div>
</section>

</x-shop::layouts>    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const $inputs = $('.otp-input');

        $inputs.on('input', function () {
            const $this = $(this);
            const index = $inputs.index(this);

            if ($this.val().length === 1 && index < $inputs.length - 1) {
                $inputs.eq(index + 1).focus();
            }
        });

        $inputs.on('keydown', function (e) {
            const $this = $(this);
            const index = $inputs.index(this);

            if (e.key === 'Backspace') {
                if ($this.val() === '') {
                    if (index > 0) {
                        $inputs.eq(index - 1).focus();
                    }
                } else {
                    $this.val('');
                    e.preventDefault(); // Optional: stops default backspace behavior
                }
            }
        });
    });

</script>
