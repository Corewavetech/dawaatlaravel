<x-admin::layouts>
    <!-- Page Title -->
    <x-slot:title>
        Subscription Plan
    </x-slot>

    <div class="flex items-center justify-between">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            Subscription Plans
        </p>
        
        <div class="flex items-center gap-x-2.5">            
            <a 
                href="{{ route('admin.subscription.plans.create') }}"
                class="primary-button"
            >
                Create Subscription Plan
            </a>            
        </div>
    </div>

    <x-admin::datagrid :src="route('admin.subscription.plans.index')" />

</x-admin::layouts>