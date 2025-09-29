<?php

namespace Webkul\Shop\Http\Controllers\Customer;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Shop\Http\Requests\Customer\LoginRequest;
use Webkul\Shop\Http\Requests\Customer\MobileLoginRequest;
use Illuminate\Foundation\Http\FormRequest;
use Webkul\Customer\Models\Customer;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    /**
     * Display the resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (auth()->guard('customer')->check()) {
            return redirect()->route('shop.home.index');
        }

        return view('shop::customers.sign-in');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $loginRequest)
    {
        if (! auth()->guard('customer')->attempt($loginRequest->only(['email', 'password']))) {
            session()->flash('error', trans('shop::app.customers.login-form.invalid-credentials'));

            return redirect()->back();
        }

        if (! auth()->guard('customer')->user()->status) {
            auth()->guard('customer')->logout();

            session()->flash('warning', trans('shop::app.customers.login-form.not-activated'));

            return redirect()->back();
        }

        if (! auth()->guard('customer')->user()->is_verified) {
            session()->flash('info', trans('shop::app.customers.login-form.verify-first'));

            Cookie::queue(Cookie::make('enable-resend', 'true', 1));

            Cookie::queue(Cookie::make('email-for-resend', $loginRequest->get('email'), 1));

            auth()->guard('customer')->logout();

            return redirect()->back();
        }

        /**
         * Event passed to prepare cart after login.
         */
        Event::dispatch('customer.after.login', auth()->guard()->user());

        if (core()->getConfigData('customer.settings.login_options.redirected_to_page') == 'account') {
            return redirect()->route('shop.customers.account.profile.index');
        }

        return redirect()->route('shop.home.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        auth()->guard('customer')->logout();

        Event::dispatch('customer.after.logout', $id);

        return redirect()->route('shop.home.index');
    }

    public function mobileLogin(MobileLoginRequest $request)
    {        
        
        $otp = rand(1000, 9999); 

        $customer = Customer::where('phone', $request->phone)->first();
        if (! $customer) {
            return back()->withErrors(['mobile' => 'Mobile number not registered.']);
        }

        $addTime = \Carbon\Carbon::now()->addMinutes(10);
        $customer->otp = $otp;
        $customer->otp_expires_at = $addTime;
        $customer->save();

        Session::put('otp', $otp);
        Session::put('phone', $request->phone);
        $phone = $request->phone;

        return redirect()->route('shop.customers.session.verify.form');
        
    }

    public function showVerifyForm()
    {
        return view('shop::customers.verifyOtp');
    }

    public function verify_login(FormRequest $request)
    {
        
        $request->validate([
            'otp_1' => 'required|digits:1',
            'otp_2' => 'required|digits:1',
            'otp_3' => 'required|digits:1',
            'otp_4' => 'required|digits:1',
        ]);
        
        $otp = $request->input('otp_1') .
        $request->input('otp_2') .
        $request->input('otp_3') .
        $request->input('otp_4');                
        
        $nowDateTime = now()->format('Y-m-d H:i');
        $inputOTP = $otp;
        $generatedOTP = Session::get('otp');
        $phone = Session::get('phone');
        $customer = Customer::where('phone', $phone)->where('otp', $inputOTP)->first();

        if (! $customer) {            
            return back()->with('error', 'Invalid OTP.');
        }

        if($nowDateTime <= $customer->otp_expires_at){

            $customer->otp = null;
            $customer->is_phone_verified = $nowDateTime;
            $customer->save();

            Auth::guard('customer')->login($customer);
            Session::forget('otp');
            Session::forget('phone');

            Event::dispatch('customer.after.login', auth()->guard()->user());

            if (core()->getConfigData('customer.settings.login_options.redirected_to_page') == 'account') {
                return redirect()->route('shop.customers.account.profile.index');
            }

            return redirect()->route('shop.home.index');

        }else{            
            return redirect()->route('shop.customer.session.index')->with('error', 'OTP Expired');
        }

        

    }

}
