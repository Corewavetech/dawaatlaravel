<?php

namespace Webkul\Shop\Http\Controllers\Customer;

use Cookie;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Webkul\Core\Repositories\SubscribersListRepository;
use Webkul\Customer\Models\Customer;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Shop\Http\Requests\Customer\RegistrationRequest;
use Webkul\Shop\Http\Requests\Customer\SignupRequest;
use Webkul\Shop\Mail\Customer\EmailVerificationNotification;
use Webkul\Shop\Mail\Customer\RegistrationNotification;

class RegistrationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CustomerRepository $customerRepository,
        protected CustomerGroupRepository $customerGroupRepository,
        protected SubscribersListRepository $subscriptionRepository
    ) {}

    /**
     * Opens up the user's sign up form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (auth()->guard('customer')->check()) {
            return redirect()->route('shop.home.index');
        }
        
        return view('shop::customers.sign-up');
    }

    /**
     * Method to store user's sign up form data to DB.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RegistrationRequest $registrationRequest)
    {
        $customerGroup = core()->getConfigData('customer.settings.create_new_account_options.default_group');

        $data = array_merge($registrationRequest->only([
            'first_name',
            'last_name',
            'email',
            'password_confirmation',
            'is_subscribed',
        ]), [
            'password'                  => bcrypt(request()->input('password')),
            'api_token'                 => Str::random(80),
            'is_verified'               => ! core()->getConfigData('customer.settings.email.verification'),
            'customer_group_id'         => $this->customerGroupRepository->findOneWhere(['code' => $customerGroup])->id,
            'channel_id'                => core()->getCurrentChannel()->id,
            'token'                     => md5(uniqid(rand(), true)),
            'subscribed_to_news_letter' => (bool) request()->input('is_subscribed'),
        ]);

        Event::dispatch('customer.registration.before');

        $customer = $this->customerRepository->create($data);

        if (isset($data['is_subscribed'])) {
            $subscription = $this->subscriptionRepository->findOneWhere(['email' => $data['email']]);

            if ($subscription) {
                $this->subscriptionRepository->update([
                    'customer_id' => $customer->id,
                ], $subscription->id);
            } else {
                Event::dispatch('customer.subscription.before');

                $subscription = $this->subscriptionRepository->create([
                    'email'         => $data['email'],
                    'customer_id'   => $customer->id,
                    'channel_id'    => core()->getCurrentChannel()->id,
                    'is_subscribed' => 1,
                    'token'         => uniqid(),
                ]);

                Event::dispatch('customer.subscription.after', $subscription);
            }
        }

        Event::dispatch('customer.create.after', $customer);

        Event::dispatch('customer.registration.after', $customer);

        if (core()->getConfigData('emails.general.notifications.emails.general.notifications.verification')) {
            session()->flash('success', trans('shop::app.customers.signup-form.success-verify'));
        } else {
            session()->flash('success', trans('shop::app.customers.signup-form.success'));
        }

        return redirect()->route('shop.customer.session.index');
    }

    /**
     * Method to verify account.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function verifyAccount($token)
    {
        $customer = $this->customerRepository->findOneByField('token', $token);

        if ($customer) {
            $this->customerRepository->update([
                'is_verified' => 1,
                'token'       => null,
            ], $customer->id);

            if ((bool) core()->getConfigData('emails.general.notifications.emails.general.notifications.registration')) {
                Mail::queue(new RegistrationNotification($customer));
            }

            $this->customerRepository->syncNewRegisteredCustomerInformation($customer);

            session()->flash('success', trans('shop::app.customers.signup-form.verified'));
        } else {
            session()->flash('warning', trans('shop::app.customers.signup-form.verify-failed'));
        }

        return redirect()->route('shop.customer.session.index');
    }

    /**
     * Resend verification email.
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function resendVerificationEmail($email)
    {
        $verificationData = [
            'email' => $email,
            'token' => md5(uniqid(rand(), true)),
        ];

        $customer = $this->customerRepository->findOneByField('email', $email);

        $this->customerRepository->update(['token' => $verificationData['token']], $customer->id);

        try {
            Mail::queue(new EmailVerificationNotification($verificationData));

            if (Cookie::has('enable-resend')) {
                \Cookie::queue(\Cookie::forget('enable-resend'));
            }

            if (Cookie::has('email-for-resend')) {
                \Cookie::queue(\Cookie::forget('email-for-resend'));
            }
        } catch (\Exception $e) {
            report($e);

            session()->flash('error', trans('shop::app.customers.signup-form.verification-not-sent'));

            return redirect()->back();
        }

        session()->flash('success', trans('shop::app.customers.signup-form.verification-sent'));

        return redirect()->back();
    }

    public function newUserStore(SignupRequest $request)
    {

        $existingCustomer = Customer::where('status', 1)->where('is_verified', 1)->where('phone', $request->phone)->first();

        if($existingCustomer){
            return redirect()->back()->with('error', 'Customer already registered');
        }

        $previousregistered = Customer::where('status', 0)->where('is_verified', 0)->where('phone', $request->phone)->first();
        if(!$previousregistered){
            $data = array_merge($request->only([
                'first_name',
                'last_name',
                'email',
                'phone',
                'is_subscribed',
            ]), [           
                'status'                    => 0, 
                'api_token'                 => Str::random(80),            
                'customer_group_id'         => 2,
                'channel_id'                => core()->getCurrentChannel()->id,
                'token'                     => md5(uniqid(rand(), true)),
                'subscribed_to_news_letter' => (bool) request()->input('is_subscribed'),
            ]);

            Event::dispatch('customer.registration.before');
            $customer = $this->customerRepository->create($data);
        }else{
            $customer = $previousregistered;
        }           

        $otp = rand(1000, 9999); 
        Session::put('otp', $otp);
        Session::put('phone', $request->phone);
        $phone = $request->phone;

        $addTime = \Carbon\Carbon::now()->addMinutes(10);
        $customer->otp = $otp;
        $customer->otp_expires_at = $addTime;
        $customer->save();

        if (isset($data['is_subscribed'])) {
            $subscription = $this->subscriptionRepository->findOneWhere(['phone' => $data['phone']]);

            if ($subscription) {
                $this->subscriptionRepository->update([
                    'customer_id' => $customer->id,
                ], $subscription->id);
            } else {
                Event::dispatch('customer.subscription.before');

                $subscription = $this->subscriptionRepository->create([
                    'phone'         => $data['phone'],
                    'email'         => $data['email'],
                    'customer_id'   => $customer->id,
                    'channel_id'    => core()->getCurrentChannel()->id,
                    'is_subscribed' => 1,
                    'token'         => uniqid(),
                ]);

                Event::dispatch('customer.subscription.after', $subscription);
            }
        }

        Event::dispatch('customer.create.after', $customer);

        Event::dispatch('customer.registration.after', $customer);
        

        return redirect()->route('shop.customers.register.verify.form');

    }

    public function showVerifyForm()
    {
        return view('shop::customers.registerverifyOtp');
    }


    public function verify_register(FormRequest $request)
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
            $customer->status = 1;
            $customer->is_verified = 1;
            $customer->save();

            Auth::guard('customer')->login($customer);
            Session::forget('otp');
            Session::forget('phone');            

            session()->flash('success', trans('shop::app.customers.signup-form.success'));
            return redirect()->route('shop.customer.session.index');

        }else{            
            return redirect()->route('shop.customers.register.index')->with('error', 'OTP Expired');
        }

    }

}
