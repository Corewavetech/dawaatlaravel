<?php

namespace Webkul\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionPlanRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id'=> ['required'],
            'duration'  => ['required'],
            'frequency' => ['required'],
            'price'     => ['required']
        ];
    }

    public function messages()
    {
        return [
            'product_id.required'=> 'Please select a product',
            'duration.required'  => 'Duration of subscription required',
            'frequency.required' => 'Please select frequency',
            'price.required'     => 'Plan price required'
        ];
    }
}