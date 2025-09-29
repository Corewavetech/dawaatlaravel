<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.checkout.cart.index.cart')"/>

    <meta name="keywords" content="@lang('shop::app.checkout.cart.index.cart')"/>
@endPush

<x-shop::layouts    
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.cart.index.cart')
    </x-slot>

    <div class="flex-auto">
        <div class="container px-[60px] max-lg:px-8 max-md:px-4">
                        
            @php
                $errors = Cart::getErrors();                
            @endphp
            
            @if (! empty($errors) && $errors['error_code'] === 'MINIMUM_ORDER_AMOUNT')
                <div class="mt-5 w-full gap-12 rounded-lg bg-[#FFF3CD] px-5 py-3 text-[#383D41] max-sm:px-3 max-sm:py-2 max-sm:text-sm">
                    {{ $errors['message'] }}: {{ $errors['amount'] }}
                </div>
            @endif

        </div>
    </div>
    
    <v-cart ref="vCart">
        <!-- Cart Shimmer Effect -->
        <x-shop::shimmer.checkout.cart :count="3" />
    </v-cart>

    <x-shop::products.carousel
        :title="trans('Featured Products')"
        :src="route('shop.api.products.index', ['featured' => 1, 'sort' => 'name', 'limit' => 12])"
    />  

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

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-cart-template"
        >
            <div>
                <!-- Cart Shimmer Effect -->
                <template v-if="isLoading">
                    <x-shop::cart.cart-skeleton />                    
                </template>

                <!-- Cart Information -->
                <template v-else>
                    <section v-if="cart?.items?.length">
                        <div class="container-fluid">
                            <div class="cart_manage py-5">

                                <h5 class="mb-3">(@{{ cart?.items_count }}) Item in your cart</h5>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <!-- Cart Items -->
                                        <div class="card mb-4 cart-item-card">                                            
                                            <div v-for="item in cart?.items">
                                                <div class="card-body">
                                                    <div class="row cart-item mb-3">
                                                        <div class="col-md-3">
                                                            <div class="cart_product">
                                                                <a :href="'/'+item.product_url_key">
                                                                    <img :src="item.base_image.original_image_url" :alt="item.name"
                                                                        class="img-fluid rounded">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <h5 class="card-title">
                                                                <a :href="'/'+item.product_url_key">
                                                                     @{{ item.name }} 
                                                                </a>
                                                            </h5>
                                                            <div class="d-flex align-items-center ">
                                                                <div class="mx-2">
                                                                    
                                                                    <i 
                                                                    v-for="n in Math.floor(item.average_rating)"
                                                                    :key="'full-'+ n"
                                                                    class="bi bi-star-fill text-primary"
                                                                    ></i>   
                                                                    
                                                                    <i 
                                                                    v-if="(item.average_rating % 1) >= 0.5"
                                                                    class="bi bi-star-half text-primary"
                                                                    ></i>

                                                                    <i 
                                                                    v-for="n in 5 - Math.ceil(item.average_rating)"
                                                                    :key="'empty-'+ n"
                                                                    class="bi bi-star text-primary"
                                                                    ></i>
                                                                    
                                                                </div>

                                                                <p class="text-muted ">( @{{ item.review_count }} customer review)</p>
                                                            </div>
                                                            <p class="text-muted"> @{{ item.short_description }} </p>
                                                            <p class="fw-bold"> @{{ item.formatted_price }} <span
                                                                    class="badge bg-primary rounded-pill position-absolute m-2" v-if="item.special_price > item?.price"> -@{{ getPercentage(item?.special_price , item?.price) }}%</span>
                                                            </p>
                                                            <del v-if="item.special_price > item?.price"> @{{ item.formatted_special_price }} </del>
                                                            <br />
                                                            <div class="btn-group mt-3 " role="group" aria-label="Basic example">
                                                                <button type="button" class="btn custom-btn explore-btn" @click.prevent="decrease(item)">-</button>
                                                                <button type="button" class="btn custom-btn explore-btn"> @{{ item.quantity }}</button>
                                                                <button type="button" class="btn custom-btn explore-btn" @click.prevent="increase(item)">+</button>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="col-md-2 text-end d-flex flex-column justify-content-between align-items-end btn-class">
                                                            
                                                            @if (core()->getConfigData('customer.settings.wishlist.wishlist_option')) 
                                                                <a  href="#" 
                                                                    class="btn-wishlist"                                                 
                                                                    :style="item.is_wishlisted ? 'background-color: white !important; color: #dc3545 !important;' : ''"                                                
                                                                    @click.prevent="toggleWishlist(item.product_id)" >
                                                                    <i :class="item.is_wishlisted ? 'fa-regular fa-heart' : 'fa-regular fa-heart'"></i> 
                                                                </a>
                                                            @endif
                                                            
                                                            <a
                                                            href="javascript:void(0);"
                                                            class="btn btn-sm  btn-outline-danger remove_icons"
                                                            @click.prevent="removeItem(item.id)"
                                                            >                                                               
                                                                <i class="bi bi-trash"></i> 
                                                            </a>
                                                            
                                                        </div>
                                                    </div>
                                                    <hr>    
                                                </div>                                            

                                            </div>
                                        </div>
                                        <!-- Continue Shopping Button -->
                                        <div class="text-start mb-4">
                                            <a href="{{ route('shop.home.index') }}" class="btn btn-outline-primary rounded-pill">
                                                <i class="bi bi-arrow-left  me-2"></i>Continue Shopping
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <!-- Cart Summary -->
                                        <div class="card cart-summary">
                                            <div class="card-body">
                                                <h5 class="card-title mb-4">Cart Summary</h5>

                                                <h6>Price Details (@{{ cart?.items_count }} Items)</h6>
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span>Total MRP</span>
                                                    <span> @{{ cart?.formatted_sub_total }} </span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-3" v-if="cart.discount_amount && parseFloat(cart.discount_amount) > 0">
                                                    <span>
                                                        @lang('shop::app.checkout.cart.summary.discount-amount')
                                                    </span>                                                    
                                                    <span v-if="cart.discount_amount && parseFloat(cart.discount_amount) > 0"> @{{ cart?.formatted_discount_amount }} </span>
                                                </div>
                                                
                                                @include('shop::checkout.coupon')

                                                <div class="d-flex justify-content-between mb-3">
                                                    <span>Tax Amount</span>
                                                    <span> @{{ cart?.formatted_tax_total }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span>Shipping Charge</span>
                                                    <span class="free_shipping">Free</span>
                                                    <span v-if="cart?.shipping_amount > 0">@{{ cart?.formatted_shipping_amount }}</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between mb-4">
                                                    <strong>Total</strong>
                                                    <strong> @{{ cart?.formatted_grand_total }}</strong>
                                                </div>
                                                
                                                <a
                                                    href="{{ route('shop.checkout.onepage.index') }}"
                                                    class="btn btn-success w-100 explore-btn rounded-pill"
                                                >
                                                    @lang('shop::app.checkout.cart.summary.proceed-to-checkout')
                                                </a>
                                            </div>
                                        </div>
                                        <!-- Promo Code -->

                                    </div>
                                </div>


                            </div>
                        </div>
                    </section>                    

                    <!-- Empty Cart Section -->
                    <div
                        class="m-auto grid w-full place-content-center items-center justify-items-center py-32 text-center"
                        v-else
                    >
                        <img
                            class="max-md:h-[100px] max-md:w-[100px]"
                            src="{{ bagisto_asset('images/thank-you.png') }}"
                            alt="@lang('shop::app.checkout.cart.index.empty-product')"
                        />
                        
                        <p
                            class="text-xl max-md:text-sm"
                            role="heading"
                        >
                            @lang('shop::app.checkout.cart.index.empty-product')
                        </p>
                    </div>
                </template>
            </div>
        </script>

        <script type="module">
            app.component("v-cart", {
                template: '#v-cart-template',

                data() {
                    return  {
                        cart: [],

                        isCustomer: '{{ auth()->guard('customer')->check() }}',
                        allSelected: false,

                        applied: {
                            quantity: {},
                        },

                        displayTax: {
                            prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",

                            subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",
                            
                            shipping: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_shipping_amount') }}",
                        },

                        isLoading: true,

                        isStoring: false,
                    }
                },

                mounted() {
                    this.getCart();
                },

                computed: {
                    selectedItemsCount() {
                        return this.cart.items.filter(item => item.selected).length;
                    },   
                                        
                },

                methods: {

                    strippedDescription(item){                        
                        
                        item.replace(/<\/?[^>]+(>|$)/g, "");

                        if (item.length > 150) {
                            item = item.substring(0, 150) + '...';
                        }

                        return item;

                    },

                    getPercentage(regular, final){
                        if (regular && final && regular > 0) {                        
                            const percentage = ((regular - final) / regular) * 100;
                            return percentage.toFixed(2);
                        }
                        return 0.00;                     
                    },

                    getCart() {
                        this.$axios.get('{{ route('shop.api.checkout.cart.index') }}')
                            .then(response => {
                                this.cart = response.data.data;

                                this.isLoading = false;

                                if (response.data.message) {
                                    this.$emitter.emit('add-flash', { type: 'info', message: response.data.message });
                                }
                            })
                            .catch(error => {});
                    },

                    update() {
                        this.isStoring = true;

                        this.$axios.put('{{ route('shop.api.checkout.cart.update') }}', { qty: this.applied.quantity })
                            .then(response => {
                                this.cart = response.data.data;

                                if (response.data.message) {
                                    showFlash('success', response.data.message);                                            
                                } else {
                                    showFlash('warning', response.data.data.message);                                                                                
                                }
                                
                                this.getCart(); 
                                this.$emitter.emit('update-mini-cart', response.data.data);                                

                            })
                            .catch(error => {
                                this.isStoring = false;
                            });
                    },

                    setItemQuantity(itemId, quantity) {
                        this.applied.quantity[itemId] = quantity;
                    },

                    removeItem(itemId) {
                        
                        this.$emitter.emit('open-confirm-modal', {
                            title: 'Confirm Removal', 
                            message: 'Are you sure you want to remove this item from your cart?',
                            agree: () => {
                                this.$axios.post('{{ route('shop.api.checkout.cart.destroy') }}', {
                                        '_method': 'DELETE',
                                        'cart_item_id': itemId,
                                    })
                                    .then(response => {
                                        this.cart = response.data.data;

                                        this.$emitter.emit('update-mini-cart', response.data.data );
                                        showFlash('success', response.data.message);                                            

                                    })
                                    .catch(error => {});
                            }
                        });
                    },

                    toggleWishlist(productId) {
                        if (this.isCustomer) {
                            this.$axios
                                .post('{{ route('shop.api.customers.account.wishlist.store') }}', { product_id: productId })
                                .then((response) => {                                
                                    this.isWishlist = ! this.isWishlist;

                                    this.$emitter.emit('wishlist:updated');

                                    showFlash('success', response.data.data.message);                                    
                                    
                                    this.getCart(); 
                                    const product = this.cart.items.find((p) => p.id === productId);
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

                    increase(item) {
                        const newQuantity = item.quantity + 1;
                        this.setItemQuantity(item.id, newQuantity);                        
                        this.update();
                    },

                    decrease(item) {

                        if (item.quantity > 1) {
                            const newQuantity = item.quantity - 1;
                            this.setItemQuantity(item.id, newQuantity);                        
                            this.update();                            
                        }
                    },

                }
            });
        </script>

        <style scoped>
            .shimmer {
                background: #e0e0e0;
                position: relative;
                overflow: hidden;
                border-radius: 4px;
                animation: shimmer 1.5s infinite linear;
            }
            
            @keyframes shimmer {
                0% {
                    background-position: -1000px 0;
                }
                100% {
                    background-position: 1000px 0;
                }
            }
            
            .shimmer-rounded {
                border-radius: 50%;
            }
            
            .shimmer-text {
                height: 16px;
                margin-top: 5px;
                background-color: #e0e0e0;
                animation: loading 2.5s infinite ease-in-out;
            }

            .shimmer-item,
            .shimmer-line,
            .shimmer-img,
            .shimmer-btn {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: shimmer 2.5s infinite linear;
            }

            .shimmer-img {
                width: 80px;
                height: 80px;
            }

            .shimmer-line {
                height: 15px;
                border-radius: 4px;
            }

            .shimmer-btn {
                height: 40px;
                border-radius: 8px;
            }
            
            @keyframes loading {
                0% {
                    background-color: #e0e0e0;
                }
                50% {
                    background-color: #f0f0f0;
                }
                100% {
                    background-color: #e0e0e0;
                }
            }

            .cart-item-card .btn-wishlist {                
                width: 1.5rem;
                height: 1.5rem;
                padding: .2rem;
                border-radius: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #fff;
                border: 1px solid #d8d8d8;
                transition: all 0.3s ease-out;
            }

            .cart-item-card .btn-wishlist:hover{
                background-color: red;
                color: #fff;
            }
        </style>
    @endpushOnce
</x-shop::layouts>
