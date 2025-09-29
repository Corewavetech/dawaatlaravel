<v-wishlist-items>    
     <x-shop::shimmer.products.scroll-product />
</v-wishlist-items>

@pushOnce('scripts')
    <script type="text/x-template" id="v-wishlist-items-template">
        <template v-if="isLoading">
             <x-shop::shimmer.products.scroll-product />
        </template>

        <template v-else>

            <template v-if="products && products.length > 0">                
                <section class="py-5 overflow-hidden">
                    <div class="container-fluid">    
                        <div class="all_product_list">
                            <div class="product-item" v-for="product in products" :key="product.index">                            
                                <span class="badge bg-primary rounded-pill position-absolute m-3" v-html="getPercentage(product?.product?.prices?.regular?.price , product?.product?.prices?.final?.price)"></span>

                                @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))                                            
                                    <a  href="#" 
                                        class="btn-wishlist"                                                 
                                        :style="product?.product?.is_wishlist ? 'background-color: white !important; color: #dc3545 !important;' : ''"                                                
                                        @click.prevent="toggleWishlist(product?.product?.id)" >
                                        <i :class="product?.product?.is_wishlist ? 'fa-solid fa-heart' : 'fa-regular fa-heart'"></i> 
                                    </a>                    
                                @endif
                                
                                <figure>
                                    <a :href="'/'+ product?.product?.url_key" :title="product?.product?.name">
                                        <img
                                            :src="product.product.base_image.original_image_url"
                                            class="tab-image"
                                            :alt="product?.product?.name"
                                        />
                                    </a>
                                </figure>

                                <h6 v-text="product?.product?.name"></h6>
                                <span class="qty"></span>
                                
                                <span class="rating">
                                    <svg width="24" height="24" class="text-primary">
                                        <use xlink:href="#star-solid"></use>
                                    </svg>
                                    @{{ '0.0' }}
                                </span>

                                <div class="price d-flex justify-between">

                                    <span v-html="product?.product?.prices?.final?.formatted_price"></span>
                                    
                                    <small                                    
                                        class="text-muted text-decoration-line-through small ms-2"
                                    >
                                        @{{ product?.product?.prices?.regular?.formatted_price }}
                                    </small>
                                </div>  

                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <button type="button" class="btn btn-success btn-sm add_to_cart explore-btn"
                                    :disabled="isStoring.addToCart"
                                    @click="moveToCart(product.id, product?.product)"
                                    >
                                        Move to Cart
                                        <svg width="16" height="16" viewBox="0 0 24 24">
                                            <use xlink:href="#cart"></use>
                                        </svg>
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-success btn-sm buy_now explore-btn"
                                    >
                                        Buy Now
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="paginations">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                                        <a class="page-link" href="#" aria-label="Previous" @click.prevent="changePage(currentPage - 1)">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item" v-for="page in pagNumbers" :key="page">
                                        <a class="page-link" href="#" @click.prevent="changePage(page)"> @{{ page }} </a>
                                    </li>
                                    
                                    <li class="page-item" :class="{ 'disabled': currentPage === totalPages}">
                                        <a class="page-link" href="#" aria-label="Next" @click.prevent="changePage(page+1)">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>                
                    </div>
                </section>
            </template>
            
            <template v-else>
                <div class="m-auto grid w-full place-content-center items-center justify-items-center py-32 text-center">
                    <img
                        class="max-md:h-[100px] max-md:w-[100px]"
                        src="{{ bagisto_asset('images/wishlist.png') }}"
                        alt="Empty wishlist"
                    >

                    <p
                        class="text-xl max-md:text-sm"
                        role="heading"
                    >
                        @lang('shop::app.customers.account.wishlist.empty')
                    </p>
                </div>
            </template>
            
        </template>
    </script>

    <script type="module">
        app.component('v-wishlist-items', {
            template: '#v-wishlist-items-template',

            data() {
                return {
                    products: [],
                    isLoading: false,  
                    isCustomer: '{{ auth()->guard('customer')->check() }}',
                    
                    is_buy_now: 0,

                    isStoring: {
                        addToCart: false,

                        buyNow: false,
                    },

                    currentPage: 1,
                    totalPages: 1,
                    totalProducts: 0,
                    perPage: 12,

                    movingToCart: false,

                };
            },

            computed: {
                pagNumbers(){
                    let pages = [];
                    for(let i=1; i <= this.totalPages; i++){
                        pages.push(i);
                    }

                    return pages;
                }
            },

            mounted() {
                this.getProducts();
                
            },

            methods: {
                getProducts() {
                    this.isLoading = true;

                    this.$axios
                        .get('{{ route('shop.api.customers.account.wishlist.index') }}', {
                            params: {
                                page: this.currentPage,
                                limit: this.perPage,                                
                                mode: 'grid'
                            }
                        })
                        .then((response) => {
                            this.products = response.data.data;
                            this.isLoading = false;                            
                            
                            this.totalPages = response.data.meta.last_page;                            

                        })
                        .catch((error) => {
                            console.error('Error fetching products:', error);
                            this.isLoading = false;
                        });
                },

                getPercentage(regular, final){
                    if (regular && final && regular > 0) {                        
                        const percentage = ((regular - final) / regular) * 100;
                        return `-${percentage.toFixed(2)}%`;
                    }
                    return `-${(0).toFixed(2)}%`;
                },

                changePage(page){
                    if(page < 1 || page > this.totalPages) return;
                    this.currentPage = page;
                    this.getProducts();
                },

                toggleWishlist(productId) {
                    if (this.isCustomer) {
                        this.$axios
                            .post('{{ route('shop.api.customers.account.wishlist.store') }}', { product_id: productId })
                            .then((response) => {

                                this.isWishlist = ! this.isWishlist;

                                this.$emitter.emit('wishlist:updated');

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                                showFlash("success", response.data.data.message);
                                // this.getProducts(); 
                                const product = this.products.find((p) => p.id === productId);
                                if (product) {
                                    product.is_wishlist = !product.is_wishlist; 
                                }

                                window.location.reload();
                            })
                            .catch((error) => {
                                console.error('Error updating wishlist:', error);
                            });
                    } else {
                        window.location.href = "{{ route('shop.customer.session.index') }}";
                    }
                },

                moveToCart(whishlistId, productId) {
                    this.movingToCart = true;

                    const endpoint = `{{ route('shop.api.customers.account.wishlist.move_to_cart', ':wishlistId:') }}`.replace(':wishlistId:', whishlistId);

                    this.$axios.post(endpoint, {
                            quantity: 1,
                            product_id: productId,
                        })
                        .then(response => {
                            if (response.data?.redirect) {
                                this.$emitter.emit('add-flash', { type: 'warning', message: response.data.message });

                                window.location.href = response.data.data;

                                return;
                            }

                            this.getProducts();                            

                            this.$emitter.emit('update-mini-cart', response.data.data.cart);
                            this.$emitter.emit('wishlist:updated');

                            showFlash("success", response.data.message);
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                            this.movingToCart = false;

                        })
                        .catch(error => {
                            this.movingToCart = false;

                            this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                        });
                },
            
            },
        });
    </script>

    <style scoped>
        .all_product_list {
            display: grid;
            grid-template-columns: repeat(
                auto-fill,
                minmax(clamp(220px, 12vw, 12vw), 1fr)
            );
            gap: 2rem;
        }
    </style>

@endpushOnce
