<x-admin::layouts>
    <x-slot:title>
        @lang('Coupons')
    </x-slot>

    <div class="mt-3 flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('Coupons')
        </p>

        <div class="flex items-center gap-x-2.5">
            @if (bouncer()->hasPermission('marketing.promotions.cart_rules.create'))
                <a 
                    href="{{ route('admin.marketing.promotions.cart_rules.create') }}"
                    class="primary-button"
                >
                    @lang('Create Coupon')
                </a>
            @endif
        </div>
    </div>
    
    {!! view_render_event('bagisto.admin.marketing.promotions.cart-rules.list.before') !!}

    <x-admin::datagrid :src="route('admin.marketing.promotions.cart_rules.index')" />

    {!! view_render_event('bagisto.admin.marketing.promotions.cart-rules.list.after') !!}

</x-admin::layouts>