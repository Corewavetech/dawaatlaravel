@php
    $title = request()->has('query')
            ? trans('shop::app.search.title', ['query' => request()->query('query')])
            : trans('shop::app.search.results');
@endphp

@push('meta')
    <meta
        name="description"
        content="{{ $title }}"
    />

    <meta
        name="keywords"
        content="{{ $title }}"
    />
@endPush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{ $title }}
    </x-slot>    

    <section
        style="background-image: url('{{ bagisto_asset('website/images/background-pattern.jpg') }}');background-repeat: no-repeat;background-size: cover;">
        <div class="main-sections">
            <div class="container-fluid">
                <div class="hero_banner">
                    <img src="{{ bagisto_asset('website/images/png/heroBanner.png') }}" />
                </div>
            </div>
        </div>
    </section>

    <div class="container px-4 px-md-5 px-lg-5">
        @if (request()->has('image-search'))
            @include('shop::search.images.results')
        @endif

        <div class="mt-4 d-flex justify-content-between align-items-center">
            <h1 class="h4 fw-medium">
                {{ preg_replace('/[,\\"\\\']+/', '', $title) }}
            </h1>
        </div>
    </div>
    
    <v-search>
        <x-shop::shimmer.categories.view />
    </v-search>    
    
    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-search-template"
        >
            <div class="container px-[60px] max-lg:px-8 max-sm:px-4">
                <div class="flex items-start gap-10 max-lg:gap-5 md:mt-10">
                    <!-- Product Listing Filters -->
                    

                    <!-- Product Listing Container -->
                    <div class="flex-1">                        

                        <div
                            class="mt-8 grid grid-cols-1 gap-6"                            
                        >

                            <template v-if="isLoading">
                                <x-shop::shimmer.products.cards.list count="12" />
                            </template>

                            <!-- Product Card Listing -->
                            <template v-else>
                                <template v-if="products && products.length">
                                    <section class="py-5 overflow-hidden" >
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
                                </template>
                                <!-- Empty Products Container -->
                                <template v-else>
                                    <div class="m-auto grid w-full place-content-center items-center justify-items-center py-32 text-center">
                                        <img
                                            class="max-sm:h-[100px] max-sm:w-[100px]"
                                            src="{{ bagisto_asset('images/thank-you.png') }}"
                                            alt="Empty result"
                                        />

                                        <p
                                            class="text-xl max-sm:text-sm"
                                            role="heading"
                                        >
                                            @lang('shop::app.categories.view.empty')
                                        </p>
                                    </div>
                                </template>
                            </template>
                        </div>                        

                        <!-- Load More Button -->
                        <button
                            class="secondary-button mx-auto mt-[60px] block w-max rounded-2xl px-11 py-3 text-center text-base max-md:rounded-lg max-md:text-sm max-sm:mt-7 max-sm:px-7 max-sm:py-2"
                            @click="loadMoreProducts"
                            v-if="links.next"
                        >
                            @lang('shop::app.categories.view.load-more')
                        </button>
                    </div>
                </div>
            </div>
    </script>

        <script type="module">
            app.component('v-search', {
                template: '#v-search-template',

                data() {
                    return {
                        isMobile: window.innerWidth <= 767,

                        products: [],
                        isLoading: true,

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

                        links: {},
                        searchKeyword: '',
                    }
                },

                mounted() {
                    this.searchKeyword = this.getSearchKeyword();                    
                    this.getProducts();
                },

                methods: {
                    getSearchKeyword() {
                        const params = new URLSearchParams(window.location.search);                        
                        return params.get('query') || '';
                    },

                    getProducts() {                        

                        this.$axios.get(("{{ route('shop.api.products.index') }}"), {
                            params: {
                                query: this.searchKeyword
                            }
                        })
                            .then(response => {
                                this.isLoading = false;

                                this.products = response.data.data;

                                this.links = response.data.links;
                            }).catch(error => {
                                console.log(error);
                            });
                    },

                    changePage(page){
                        if(page < 1 || page > this.totalPages) return;
                        this.currentPage = page;
                        this.getProducts();
                    },

                    getPercentage(regular, final){
                        if (regular && final && regular > 0) {                        
                            const percentage = ((regular - final) / regular) * 100;
                            return `-${percentage.toFixed(2)}%`;
                        }
                        return `-${(0).toFixed(2)}%`;
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
                                    showFlash('success', response.data.message);
                                    if (response.data.redirect) {
                                        window.location.href= response.data.redirect;
                                    }
                                } else {
                                    showFlash('warning', response.data.data.message);
                                    this.$emitter.emit('add-flash', { type: 'warning', message: response.data.data.message });
                                }

                                this.isStoring[operation] = false;
                            })
                            .catch(error => {
                                this.isStoring[operation] = false;

                                showFlash('warning', response.data.message);
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
                                    showFlash('success', response.data.data.message);
                                    // this.getProducts(); 
                                    const product = this.products.find((p) => p.id === productId);
                                    if (product) {
                                        product.is_wishlist = !product.is_wishlist; 
                                    }
                                })
                                .catch((error) => {
                                    showFlash('warning', 'Error updating wishlist');
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
                            showFlash('success', 'Something went wrong. Please try again.');
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
    @endPushOnce

    <!-- product section start  -->
    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3 p-3 feature_card  border-0">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <img src="{{ bagisto_asset('website/images/product-thumb-11.jpg') }}" class="img-fluid feature_img" alt="Card title">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body py-0 m-3">
                                    <span class="badge rounded-pill bg-primary mb-2">Subscription</span>

                                    <h5 class="text-muted mb-0">Purchase Subscription</h5>
                                    <p class="card-title">Save upto $40 on every purchase.</p>
                                    <button type="button" class="btn btn-success explore-btn">Subscribe Now ➜</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3 p-3 feature_card  border-0">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <img src="{{ bagisto_asset('website/images/product-thumb-12.jpg') }}" class="img-fluid feature_img" alt="Card title">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body py-0 m-3">
                                    <span class="badge rounded-pill mb-2 bg-primary">Free delivery</span>

                                    <h5 class="text-muted mb-0">Purchase Subscription</h5>
                                    <p class="card-title">Save upto $40 on every purchase.</p>
                                    <button type="button" class="btn btn-success explore-btn">View All Products ➜</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</x-shop::layouts>
