<x-admin::layouts>            

    <x-slot:title>
        Edit - Subscription Plan
    </x-slot>

    <x-admin::form :action="route('admin.subscription.plans.update', ['plan'=>$plan->id])" method="POST">
        <!-- Header -->
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap mb-[20px]">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                Edit Subscription Plan
            </p>

            <div class="flex items-center gap-x-2.5">
                <a href="{{ route('admin.subscription.plans.index') }}" class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800">
                    Back
                </a>

                <button type="submit" class="primary-button">
                    Save Plan
                </button>
            </div>
        </div>

        <!-- Main Panel -->
        <div class="flex gap-2.5 max-xl:flex-wrap" style="margin-top: 20px;">
            <!-- Left Card -->
            <div class="flex flex-1 flex-col gap-4 max-xl:flex-auto">
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        Plan Details
                    </p>

                    <!-- Product -->
                    <input type="hidden" name="product_id" value="{{ $plan->product_id }}" />
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            Product
                        </x-admin::form.control-group.label>

                        <select 
                            name="product_id" 
                            id="select_product_id" 
                            class="custom-select w-full rounded-md border bg-white px-3 py-2.5 text-sm font-normal text-gray-600 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400"  
                            required
                            {{-- onchange="updateProductImage()" --}}
                            disabled
                        >
                            <option value="">-- Select Product --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    data-image="{{ $product->base_image_url ?? '' }}"
                                    data-price="{{ $product->price ?? '' }}"
                                    {{ $plan->product_id == $product->id ? 'selected' : '' }}    
                                >
                                    {{ $product->name }} ({{ $product->sku }})
                                </option>
                            @endforeach
                        </select>

                        <x-admin::form.control-group.error control-name="product_id" />
                    </x-admin::form.control-group>

                    <!-- Duration -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            Duration (Months)
                        </x-admin::form.control-group.label>

                        <select name="duration" id="duration" 
                            class="custom-select w-full rounded-md border bg-white px-3 py-2.5 text-sm font-normal text-gray-600 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400" 
                        required>

                            <option value="1" {{ $plan->duration == 1 ? 'selected' : '' }}>1 Month</option>
                            <option value="3" {{ $plan->duration == 3 ? 'selected' : '' }}>3 Months</option>
                            <option value="6" {{ $plan->duration == 6 ? 'selected' : '' }}>6 Months</option>
                            <option value="12" {{ $plan->duration == 12 ? 'selected' : '' }}>1 Year</option>
                        </select>

                        <x-admin::form.control-group.error control-name="frequency" />
                    </x-admin::form.control-group>

                    <!-- Frequency -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            Frequency
                        </x-admin::form.control-group.label>

                        <select name="frequency" id="frequency" class="custom-select w-full rounded-md border bg-white px-3 py-2.5 text-sm font-normal text-gray-600 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400" required>
                            <option value="1" {{ $plan->frequency == 1 ? 'selected' : '' }}>Monthly</option>
                            <option value="2" {{ $plan->frequency == 2 ? 'selected' : '' }}>Weekly</option>
                            <option value="3" {{ $plan->frequency == 3 ? 'selected' : '' }}>Daily</option>
                        </select>

                        <x-admin::form.control-group.error control-name="frequency" />
                    </x-admin::form.control-group>

                </div>
            </div>

            <!-- Right Card -->
            <div class="flex w-[360px] max-w-full flex-col gap-4">
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        Settings
                    </p>                    

                    <!-- Price -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            Subscription Price (₹)
                        </x-admin::form.control-group.label>
                        
                        @php
                            $formattedPrice = number_format($plan->price ?? 0, 2, '.', '') ?? 0.00;                            
                            $sub_product = $product->where('id', $plan->product_id)->first();                            
                        @endphp

                        <input 
                            type="number" 
                            step="0.01" 
                            min="0" 
                            id="price" 
                            name="price" 
                            class="w-full rounded-md border px-3 py-2.5 text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                            onkeyup="changeprice()"                            
                            value="{{ $formattedPrice }}"
                        >

                        <x-admin::form.control-group.error control-name="price" />
                    </x-admin::form.control-group>

                    <p>Price: <span id="actual-cost">₹ {{ number_format($sub_product->price, 2, '.', '') ?? 0.00}}</span></p>

                </div>

                <!-- Product Preview -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-2 text-base font-semibold text-gray-800 dark:text-white">
                        Product Preview
                    </p>

                    <div class="flex items-center justify-center h-[200px] border rounded bg-gray-50 dark:bg-gray-800">
                        <img
                            id="product-preview"
                            src="{{ $sub_product->base_image_url }}"
                            alt="Product Image"
                            class="h-full max-h-full object-contain"
                            onerror="this.src = ''"
                        />
                    </div>
                </div>
            </div>
        </div>
    </x-admin::form>     
    
</x-admin::layouts>
<script>

    $(document).off().on('change', '#select_product_id', function(){
        let selected = $(this).find(':selected');
        let imageUrl = selected.data('image');
        let price = selected.data('price');
        let actualCost = $('#actual-cost');
        let preview = $('#product-preview');

        actualCost.text(price ? '₹ ' + parseFloat(price).toFixed(2) : '0.00');

        if (imageUrl) {
            preview.attr('src', imageUrl + '?t=' + new Date().getTime());
        } else {
            preview.attr('src', '');
        }

    });

</script>
