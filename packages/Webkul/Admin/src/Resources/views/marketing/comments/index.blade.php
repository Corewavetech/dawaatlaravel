<x-admin::layouts>
    <x-slot:title>
        @lang('Blog Comments')
    </x-slot>
    
    <x-admin::datagrid :src="route('admin.marketing.blogs.comment.index')" />

</x-admin::layouts>