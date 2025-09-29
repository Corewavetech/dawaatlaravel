@php
    $currencySymbol = core()->getCurrentChannel()->currencies->first()->symbol;    
    $isWishlisted = auth()->guard('customer')->check() &&
        auth()->guard('customer')->user()
            ->wishlist_items
            ->where('product_id', $product->id)
            ->where('channel_id', core()->getCurrentChannel()->id)
            ->count() > 0;
@endphp

<v-simple-product
    :product="{{ json_encode($product) }}"
    :final-price="{{ $product->getTypeInstance()->getFinalPrice() }}"
    :currency-symbol="{{ json_encode($currencySymbol) }}"
    :is-wishlist="{{ $isWishlisted ? 'true' : 'false' }}"
    :is-customer="{{ auth()->guard('customer')->check() ? 'true' : 'false' }}"
    :wishlist-enabled="{{ core()->getConfigData('customer.settings.wishlist.wishlist_option') ? 'true' : 'false' }}">
</v-simple-product>

@pushOnce('scripts')

    <script type="text/x-template" id="v-simple-product-template">

        <template v-if="isLoading">
            
        </template> 

        <template v-else>
            <div class="add_to_cart_checkout">
                <div class="product_price">
                    <h4 class="final-price">
                        @{{ formatPrice(product.price) }}
                    </h4>

                    <small v-if="finalPrice < product.price" class="text-muted text-decoration-line-through ms-2">
                        @{{ formatPrice(finalPrice) }}
                    </small>
                </div>

                <div class="add_wish_now mt-3">
                    <button @click="addToCart(product)" class="btn btn-success explore-btn btn-lg me-2">
                        <i class="bi bi-cart-plus"></i> Add to Cart ➜
                    </button>

                    <button
                        v-if="wishlistEnabled"
                        @click="toggleWishlist(product.id)"
                        class="btn btn-success explore-btn btn-lg"
                        :class="{ 'wishlist-active': isWishlistState }">
                        <i class="bi bi-heart"></i>
                        @{{ isWishlistState ? 'Wishlisted' : 'Add to Wishlist ➜' }}
                    </button>
                </div>
            </div>
        </template>

    </script>

    <script type="module">
        app.component('v-simple-product', {
            template: '#v-simple-product-template',

            props: {
                product: Object,
                finalPrice: Number,
                currencySymbol: String,
                isWishlist: Boolean,
                isCustomer: Boolean,
                wishlistEnabled: Boolean
            },

            data() {
                return {
                    isWishlistState: this.isWishlist,
                    isStoring: {
                        addToCart: false,
                        buyNow: false
                    },
                    is_buy_now: 0
                };
            },

            methods: {
                
                formatPrice(amount) {                       
                    amount = parseFloat(amount);
                    
                    if (isNaN(amount)) {
                        return `${this.currencySymbol} 0.00`; 
                    }
                    
                    return `${this.currencySymbol} ${amount.toFixed(2)}`;
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
                    }).then(response => {
                        this.$emitter.emit('update-mini-cart', response.data.data);
                        showFlash('success', response.data.message);
                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                        if (response.data.redirect) {
                            window.location.href = response.data.redirect;
                        }

                        this.isStoring[operation] = false;
                    }).catch(error => {
                        this.isStoring[operation] = false;
                        showFlash('warning', error.response.data.message);
                        this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                    });
                },

                toggleWishlist(productId) {                    
                    if (this.isCustomer) {
                        this.$axios.post('{{ route('shop.api.customers.account.wishlist.store') }}', {
                            product_id: productId
                        }).then(response => {
                            this.isWishlistState = !this.isWishlistState;
                            
                            this.$emitter.emit('wishlist:updated');
                            showFlash('success', response.data.data.message);
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                        }).catch(error => {
                            console.error('Wishlist Error:', error);
                        });
                    } else {
                        window.location.href = '{{ route("shop.customer.session.index") }}';
                    }
                }
            }

        });
    </script>

    <style scoped>
        .wishlist-active {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>

@endpushOnce
