<v-mini-cart>
    <span class="relative">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <use xlink:href="#cart"></use>
        </svg>        
    </span>
</v-mini-cart>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-mini-cart-template"
    >

        <template v-if="isLoading">
            <svg width="24" height="24" viewBox="0 0 24 24">
                <use xlink:href="#cart"></use>        
            </svg>                                     
        </template>

        <template v-else>
        {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.before') !!}
        
            <a href="{{ route('shop.checkout.cart.index') }}">
                {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.before') !!}

                    <span class="relative">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <use xlink:href="#cart"></use>
                        </svg>
                        <span class="cart_badge position-absolute top-20 start-60 translate-middle badge rounded-pill ">
                            @{{ cart?.items_count || 0 }}
                        </span>                        
                    </span>
                    
                    <span></span>

                {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.after') !!}
            </a>        

        {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.after') !!}
        </template>
    </script>

    <script type="module">
        app.component('v-mini-cart', {
            template: '#v-mini-cart-template',

            data() {
                return  {
                    cart: null,

                    isLoading:true,

                    displayTax: {
                        prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",
                        subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",
                    },
                }
            },

            mounted() {                
                this.getCart();

                /**
                 * To Do: Implement this.
                 *
                 * Action.
                 */
                this.$emitter.on('update-mini-cart', (cart) => {
                    this.cart = cart;
                });
            },

            methods: {
                getCart() {  
                    isLoading:true,                  
                    this.$axios.get('{{ route('shop.api.checkout.cart.index') }}')
                        .then(response => {                            
                            this.cart = response.data.data;
                            this.isLoading = false;
                        })
                        .catch(error => {});
                },

                updateItem(quantity, item) {
                    this.isLoading = true;

                    let qty = {};

                    qty[item.id] = quantity;

                    this.$axios.put('{{ route('shop.api.checkout.cart.update') }}', { qty })
                        .then(response => {
                            if (response.data.message) {
                                this.cart = response.data.data;
                            } else {
                                this.$emitter.emit('add-flash', { type: 'warning', message: response.data.data.message });
                            }

                            this.isLoading = false;
                        }).catch(error => this.isLoading = false);
                },

                removeItem(itemId) {
                    this.$emitter.emit('open-confirm-modal', {
                        agree: () => {
                            this.isLoading = true;

                            this.$axios.post('{{ route('shop.api.checkout.cart.destroy') }}', {
                                '_method': 'DELETE',
                                'cart_item_id': itemId,
                            })
                            .then(response => {
                                this.cart = response.data.data;

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                
                                this.isLoading = false;
                            })
                            .catch(error => {
                                this.$emitter.emit('add-flash', { type: 'error', message: response.data.message });

                                this.isLoading = false;
                            });
                        }
                    });
                },
            },
        });
    </script>
@endpushOnce