<v-mini-wishlist>
    <svg width="24" height="24" viewBox="0 0 24 24">
        <use xlink:href="#heart"></use>        
    </svg>
</v-mini-wishlist>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-mini-wishlist-template"
    >

        <template v-if="isLoading">
            <svg width="24" height="24" viewBox="0 0 24 24">
                <use xlink:href="#heart"></use>
            </svg>
            <span class="cart_badge position-absolute top-20 start-60 translate-middle badge rounded-pill ">
              0
            </span>
        </template>

        <template v-else>
        {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.before') !!}
        
            {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.before') !!}

                <span class="relative">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <use xlink:href="#heart"></use>                            
                    </svg>
                    <span class="cart_badge position-absolute top-20 start-60 translate-middle badge rounded-pill ">
                        @{{ wishlist }}
                    </span>                        
                </span>                                        

            {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.after') !!}

        {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.after') !!}
        </template>
    </script>

    <script type="module">
        app.component('v-mini-wishlist', {
            template: '#v-mini-wishlist-template',

            data() {
                return  {
                    wishlist: null,

                    isLoading:true                   
                }
            },

            mounted() {                
                this.getWishlist();

                /**
                 * To Do: Implement this.
                 *
                 * Action.
                 */
                this.$emitter.on('update-mini-wishlist', (wishlist) => {
                    this.wishlist = wishlist;
                });

                this.$emitter.on('wishlist:updated', () => {
                    this.getWishlist(); 
                });

            },

            methods: {
                getWishlist() {  
                    this.isLoading = true,                  
                    this.$axios.get('{{ route('shop.checkout.wishlist.index') }}')
                        .then(response => {       
                            this.wishlist = response.data.data;                            
                            this.isLoading = false;
                        })
                        .catch(error => {});
                },

                updateItem(quantity, item) {
                    this.isLoading = true;

                    let qty = {};

                    qty[item.id] = quantity;

                    this.$axios.put('{{ route('shop.checkout.wishlist.update') }}', { qty })
                        .then(response => {
                            if (response.data.message) {
                                this.wishlist = response.data.data;
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

                            this.$axios.post('{{ route('shop.checkout.wishlist.destroy') }}', {
                                '_method': 'DELETE',
                                'cart_item_id': itemId,
                            })
                            .then(response => {
                                this.wishlist = response.data.data;

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