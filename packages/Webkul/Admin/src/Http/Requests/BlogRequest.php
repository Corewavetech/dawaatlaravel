<?php

namespace Webkul\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'author' => 'required|string|max:255',
            'title'  => 'required|string|max:500',
            'slug'   => 'required|string|max:500',
            'content'=> 'required|string',
            'image'  => 'sometimes|mimes:png,jpg,jpeg,webp,avif,gif',
            'seo_title' => 'required|string|max:255',
            'seo_description' => 'required|string|max:500',
            'seo_keywords' => 'required|string|max:500',
            'tags'          => 'nullable|string',
            'type'          => 'required|string|in:Recipe,Blog'
        ];

        if($this->routeIs('admin.marketing.blogs.store')) {
            $rules['image'] = 'required|mimes:png,jpg,jpeg,webp,avif,gif';
        } elseif ($this->routeIs('admin.marketing.blogs.update')) {
            $rules['image'] = 'nullable|mimes:png,jpg,jpeg,webp,avif,gif';
        }

        return $rules;
    }

}