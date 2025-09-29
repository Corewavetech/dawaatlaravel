<x-admin::layouts>
    <x-slot:title>
        @lang('Blogs')
    </x-slot>

    <div class="mt-3 flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('Blogs')
        </p>

        <div class="flex items-center gap-x-2.5">            
            <a 
                href="{{ route('admin.marketing.blogs.create') }}"
                class="primary-button"
            >
                @lang('Create Blog')
            </a>            
        </div>
    </div>
    
    {!! view_render_event('bagisto.admin.marketing.promotions.cart-rules.list.before') !!}

    <x-admin::datagrid :src="route('admin.marketing.blogs.index')" />

    {!! view_render_event('bagisto.admin.marketing.promotions.cart-rules.list.after') !!}

</x-admin::layouts>