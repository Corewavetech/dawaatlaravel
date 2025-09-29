<v-category-product>    
    <x-shop::shimmer.products.cards.list count="12" />
</v-category-product>

@pushOnce('scripts')
    <script type="text/x-template" id="v-category-product-template">
        <template v-if="isLoading">
            <x-shop::shimmer.products.cards.list count="12" />
        </template>

        <template v-else>

            <section class="py-5 overflow-hidden" v-if="products && products.length">
                <div class="container-fluid">    
                    <div class="all_product_list">
                        <div class="product-item" v-for="product in products" :key="product.index">
                            <span class="badge bg-primary rounded-pill position-absolute m-3" v-html="getPercentage(product?.prices?.regular?.price , product?.prices?.final?.price)"></span>

                            @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))                                            
                                <a  href="#" 
                                    class="btn-wishlist"                                                 
                                    :style="product.is_wishlist ? 'background-color: white !important; color: #dc3545 !important;' : ''"                                                
                                    @click.prevent="toggleWishlist(product.id)" >
                                    <i :class="product.is_wishlist ? 'fa-solid fa-heart' : 'fa-regular fa-heart'"></i> 
                                </a>                    
                            @endif
                            
                            <figure>
                                <a :href="'/'+ product.url_key" :title="product.name">
                                    <img
                                        :src="product.base_image.original_image_url"
                                        class="tab-image"
                                        :alt="product.name"
                                    />
                                </a>
                            </figure>

                            <h6 v-text="product.name"></h6>
                            <span class="qty"></span>
                            
                            <span class="rating">
                                <svg width="24" height="24" class="text-primary">
                                    <use xlink:href="#star-solid"></use>
                                </svg>
                                @{{ product.ratings.average || '0.0' }}
                            </span>

                            <div class="price d-flex justify-between">

                                <span v-html="product?.prices?.final?.formatted_price"></span>
                                
                                <small                                    
                                    class="text-muted text-decoration-line-through small ms-2"
                                >
                                    @{{ product?.prices?.regular?.formatted_price }}
                                </small>
                            </div>  

                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <button type="button" class="btn btn-success btn-sm add_to_cart explore-btn"
                                :disabled="isStoring.addToCart"
                                @click="addToCart(product)"
                                >
                                    Add to Cart
                                    <svg width="16" height="16" viewBox="0 0 24 24">
                                        <use xlink:href="#cart"></use>
                                    </svg>
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-success btn-sm buy_now explore-btn"
                                    :disabled="isStoring.buyNow"
                                    @click="is_buy_now=1;buyNow(product)"
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

            <section class="py-5 overflow-hidden" v-else>
                <div class="container-fluid">
                    
                        <p class="mb-5 mt-5 text-center">This Category Do Not Have Any Product Right Now</p>
                    
                </div>
            </section>

        </template>
    </script>

    <script type="module">
        app.component('v-category-product', {
            template: '#v-category-product-template',

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
                    perPage: 12

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

                this.$emitter.on('update-featured-product', (products) => {
                    this.products = products;
                });
            },

            methods: {
                getProducts() {
                    this.isLoading = true;

                    this.$axios
                        .get('{{ route('shop.api.products.index', ['category_id' => $category->id]) }}', {
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

                addToCart(product) {                                        

                    const operation = this.is_buy_now ? 'buyNow' : 'addToCart';

                    this.isStoring[operation] = true;

                    let formData = new FormData();
                    
                    formData.append('product_id', product.id); 
                    formData.append('quantity', 1);            
                    formData.append('is_buy_now', this.is_buy_now); 

                    this.$axios.post('{{ route("shop.api.checkout.cart.store") }}', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then(response => {
                            if (response.data.message) {
                                this.$emitter.emit('update-mini-cart', response.data.data);

                                this.$emitter.emit('add-flash', {
                                    type: 'success',
                                    message: response.data.message
                                });
                                
                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                if (response.data.redirect) {
                                    window.location.href= response.data.redirect;
                                }
                            } else {
                                this.$emitter.emit('add-flash', { type: 'warning', message: response.data.data.message });
                            }

                            this.isStoring[operation] = false;
                        })
                        .catch(error => {
                            this.isStoring[operation] = false;

                            this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                        });
                },


                toggleWishlist(productId) {
                    if (this.isCustomer) {
                        this.$axios
                            .post('{{ route('shop.api.customers.account.wishlist.store') }}', { product_id: productId })
                            .then((response) => {

                                this.isWishlist = ! this.isWishlist;

                                this.$emitter.emit('wishlist:updated');

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                                
                                // this.getProducts(); 
                                const product = this.products.find((p) => p.id === productId);
                                if (product) {
                                    product.is_wishlist = !product.is_wishlist; 
                                }
                            })
                            .catch((error) => {
                                console.error('Error updating wishlist:', error);
                            });
                    } else {
                        window.location.href = "{{ route('shop.customer.session.index') }}";
                    }
                },

                async buyNow(product) {
                    const operation = this.is_buy_now ? 'buyNow' : 'addToCart';

                    this.isStoring[operation] = true;

                    try {
                        const response = await axios.post('{{ route("shop.api.checkout.cart.store") }}', {
                            product_id: product.id,
                            quantity: 1,
                            is_buy_now: this.is_buy_now
                        });

                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {                            
                            window.location.href = "/checkout/onepage";
                        }
                    } catch (error) {
                        console.error("Buy Now failed", error);
                        alert("Something went wrong. Please try again.");
                    } finally {
                        this.isStoring.buyNow = false;
                    }
                }

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
