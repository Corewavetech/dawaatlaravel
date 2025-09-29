<v-dashboard-latest-orders>
    <x-admin::shimmer.dashboard.stock-threshold-products />
</v-dashboard-latest-orders>

@pushOnce('scripts')

    <script type="text/x-template" id="v-dashboard-latest-orders-template">
        <div id="app-k">                        
            <div class="box-shadow rounded">

                <template v-if="isLoading">
                    <x-admin::shimmer.dashboard.stock-threshold-products />
                </template>

                <template v-else>
                    <div class="relative">
                        <div v-for="order in orders" :key="order.id" class="row grid grid-cols-3 gap-y-6 border-b bg-white p-4 transition-all hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:hover:bg-gray-950 max-sm:grid-cols-[1fr_auto]">
                            <!-- Product Image and Info -->                        
                            <div class="flex gap-2.5">
                                <div v-html="order.items"></div>                                
                                <div class="flex flex-col gap-1.5">
                                    <p class="text-base font-semibold text-gray-800 dark:text-white"># @{{ order.increment_id }}</p>
                                    <p class="text-gray-600 dark:text-gray-300">@{{ order.created_at }}</p>
                                    <p v-html="order.status"></p>
                                </div>
                            </div>
                            
                            <!-- Price, Stock, and Action -->
                            <div class="flex items-center justify-between gap-1.5">
                                <div class="flex flex-col gap-1.5">
                                    <p class="text-base font-semibold text-gray-800 dark:text-white">₹ @{{ order.base_grand_total }}</p>
                                    <p class="text-emerald-500">Pay By - @{{ order.method }}</p>
                                </div>                                    
                            </div>
                            
                            <!-- Customer Details Column -->
                            <div class="flex gap-1.5 items-center justify-between">    
                                <div class="flex flex-col gap-1.5">
                                    <p class="text-gray-600 dark:text-gray-300"> @{{ order.full_name }}</p>                                    
                                    <p class="text-gray-600 dark:text-gray-300"> @{{ order.customer_email }}</p>                                          
                                </div>                                
                                <a :href="order.view_url">
                                    <span class="icon-sort-right rtl:icon-sort-left cursor-pointer p-1.5 text-2xl hover:rounded-md hover:bg-gray-200 dark:hover:bg-gray-800 ltr:ml-1 rtl:mr-1"></span>
                                </a>                                  
                            </div>                        
                        </div>
                    </div>
                </template>                                                        
            </div> 
        </div> 
    </script>

    <script type="module">
        
        const ordersUrl = @json(route('admin.sales.orders.index')); // Directly pass the URL from Blad

        app.component('v-dashboard-latest-orders', {
            template: '#v-dashboard-latest-orders-template',

            data() {
                return {
                    orders: [],
                    pagination: {          
                        page: 1,
                        per_page: 5,       
                    },
                    isLoading: true,
                    ordersUrl: ordersUrl,
                }
            },

            mounted() {                
                this.getOrders();

                this.$emitter.on('reporting-filter-updated', this.getOrders);
            },

            methods: {
                getOrders() {                        
                    this.isLoading = true;                                                                        

                    this.$axios.get(this.ordersUrl, {
                        params: {
                                'pagination[page]': this.pagination.page,   
                                'pagination[per_page]': this.pagination.per_page,  
                            }   
                        })
                        .then(response => {                           
                            
                            this.orders = response.data.records.map(order => ({
                                id: order.id,
                                increment_id: order.increment_id,
                                base_grand_total: order.base_grand_total,
                                status: order.status,
                                method: order.method,
                                full_name: order.full_name,
                                customer_email: order.customer_email,
                                location: order.location,
                                items: order.items,
                                created_at: order.created_at,
                                view_url: order.actions[0] ? order.actions[0].url : '',                                
                            }));
                            
                            this.isLoading = false;
                        })
                        .catch(error => {
                            console.error("Error fetching orders:", error);
                            this.isLoading = false;
                        });
                }

                // extractItemImageUrl(itemsHtml) {
                //     const div = document.createElement('div');
                //     div.innerHTML = itemsHtml;
                //     const img = div.querySelector('img');
                //     return img ? img.src : '';
                // }
            }
        });
    </script>

@endPushOnce