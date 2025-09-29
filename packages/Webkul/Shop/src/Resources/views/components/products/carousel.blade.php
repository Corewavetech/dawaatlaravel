<v-products-carousel src="{{ $src }}" title="{{ $title }}" navigation-link="{{ $navigationLink ?? '' }}">
    <x-shop::shimmer.products.scroll-product />
</v-products-carousel>

@pushOnce('scripts')
    <script type="text/x-template" id="v-products-carousel-template">

                            <template v-if="isLoading">
                                <x-shop::shimmer.products.scroll-product />
                            </template>

                            <template v-else>
                                <section class="py-5 overflow-hidden">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="section-header d-flex flex-wrap justify-content-between my-5">
                                                    <h2 class="section-title" v-html="title"></h2>
                                                    <div class="d-flex align-items-center">
                                                        <div class="swiper-buttons">
                                                            <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button> |
                                                            <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="products-carousel swiper">
                                                    <div class="swiper-wrapper">
                                                        <div
                                                            class="product-item swiper-slide"
                                                            v-for="product in products"
                                                            :key="product.index"
                                                        >
                                                            <span class="badge bg-primary rounded-pill position-absolute m-3" v-html="getPercentage(product?.prices?.regular?.price , product?.prices?.final?.price)"></span>

                                                            <span v-if="product.on_sale" class="badge bg-primary rounded-pill position-absolute m-3">Sale</span>



                                                            @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))

                                                                <a  href="#"
                                                                    class="btn-wishlist"
                                                                    :style="product.is_wishlist ? 'background-color: white !important; color: #dc3545 !important;' : ''"
                                                                    @click.prevent="toggleWishlist(product.id)" >
                                                                    <i :class="product.is_wishlist ? 'fa-solid fa-heart' : 'fa-regular fa-heart'"></i>
                                                                </a>

                                                            @endif

                                                         <figure class="product-image-wrapper">
                                                            <a :href="'/' + product.url_key" :title="product.name">
                                                                <img
                                                                    :src="product.base_image.original_image_url"
                                                                    class="tab-image product-img"
                                                                    :alt="product.name"
                                                                />
                                                            </a>
                                                        </figure>


                                                            <h6 v-text="product.name"></h6>

                                                            <span class="rating">
                                                                <svg width="24" height="24" class="text-primary">
                                                                    <use xlink:href="#star-solid"></use>
                                                                </svg>
                                                                @{{ product.ratings.average || '0.0' }}
                                                            </span>

                                                            <div class="price d-flex">

                                                                <span v-html="product.prices.final.formatted_price"></span>

                                                                <small
                                                                    v-if="product.prices.regular.price !== product.prices.final.price"
                                                                    class="text-muted text-decoration-line-through small ms-2"
                                                                >
                                                                    @{{ product.prices.regular.formatted_price }}
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </template>

                        </script>

    <script type="module">
        app.component('v-products-carousel', {
            template: '#v-products-carousel-template',

            props: [
                'src',
                'title',
                'navigationLink',
            ],

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
                };
            },

            mounted() {
                this.getProducts();

                this.$emitter.on('update-featured-product', (products) => {
                    this.products = products;
                });
            },

            created() {
                window.addEventListener('resize', this.updateScreenSize);
            },

            beforeDestroy() {
                window.removeEventListener('resize', this.updateScreenSize);
            },

            methods: {
                getProducts() {
                    this.isLoading = true;

                    this.$axios
                        .get(this.src)
                        .then((response) => {

                            console.log(this.$emitter);
                            this.products = response.data.data;
                            this.isLoading = false;

                            this.$nextTick(() => {
                                new Swiper('.products-carousel', {
                                    slidesPerView: 5,
                                    spaceBetween: 20,
                                    navigation: {
                                        nextEl: '.products-carousel-next',
                                        prevEl: '.products-carousel-prev',
                                    },
                                    loop: true,
                                    breakpoints: {
                                        320: { slidesPerView: 1 },
                                        768: { slidesPerView: 2 },
                                        1024: { slidesPerView: 5 },
                                        1400: { slidesPerView: 5 },
                                    },
                                });
                            });
                        })
                        .catch((error) => {
                            console.error('Error fetching products:', error);
                            this.isLoading = false;
                        });
                },

                getPercentage(regular, final) {
                    if (regular && final && regular > 0) {
                        const percentage = ((regular - final) / regular) * 100;
                        return percentage.toFixed(2);
                    }
                    return 0.00;
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

                                showFlash("success", response.data.data.message);
                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                if (response.data.redirect) {
                                    window.location.href = response.data.redirect;
                                }
                            } else {
                                showFlash("warning", response.data.data.message);
                                this.$emitter.emit('add-flash', { type: 'warning', message: response.data.data.message });
                            }

                            this.isStoring[operation] = false;
                        })
                        .catch(error => {
                            this.isStoring[operation] = false;

                            showFlash("warning", error.response.data.message);
                            this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                        });
                },


                toggleWishlist(productId) {
                    if (this.isCustomer) {
                        this.$axios
                            .post('{{ route('shop.api.customers.account.wishlist.store') }}', { product_id: productId })
                            .then((response) => {
                                this.isWishlist = !this.isWishlist;

                                this.$emitter.emit('wishlist:updated');

                                showFlash('success', response.data.data.message);
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
@endPushOnce