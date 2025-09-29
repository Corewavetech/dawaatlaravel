@if (Webkul\Product\Helpers\ProductType::hasVariants($product->type))
{!! view_render_event('bagisto.shop.products.view.configurable-options.before', ['product' => $product]) !!}
<v-product-varients-options :errors="errors"></v-product-varients-options>

{!! view_render_event('bagisto.shop.products.view.configurable-options.after', ['product' => $product]) !!}

@pushOnce('scripts')

    <script type="text/x-template" id="v-product-varients-options-template">

        <template v-if="isLoading">
            
        </template> 

        <template v-else>
            <div v-for="(attribute, index) in childAttributes">                                        
                <input
                    type="hidden"
                    name="selected_configurable_option"
                    id="selected_configurable_option"
                    :value="selectedOptionVariant"
                    ref="selected_configurable_option"
                >

                <h5>@{{ attribute.label }}</h5>

                <div class="mb-4">                
                    
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <template v-for="(option, index) in attribute.options">                        
                            <template v-if="option.id">
                                <input 
                                    type="radio" 
                                    class="btn-check"                         
                                    :value="option.id"
                                    :name="'super_attribute[' + attribute.id + ']'"
                                    :id="'attribute_' + attribute.id + '_option_' + option.id"
                                    @click="configure(attribute, $event.target.value)" 
                                    :checked="selectedOptionVariant == option.products[0]"   
                                >

                                <label 
                                    class="btn btn-outline-primary" 
                                    :for="'attribute_' + attribute.id + '_option_' + option.id"                                    
                                    :title="option.label"
                                > 
                                    @{{ option.label }}
                                </label>
                            </template>
                        </template>
                    </div>
                </div>

                <p class="price-label text-sm text-zinc-500 max-sm:text-xs" style="display: none;"> As low as</p>
                <div class="add_to_cart_checkout">
                    <div class="product_price">
                        <h4 class="final-price">@{{ mainPrice }}</h4>
                        <h6 class="regular-price text-muted text-decoration-line-through small ms-2"
                            >
                            @{{ oldPrice }}
                        </h6>
                    </div>
                    <div class="add_wish_now">
                        <button class="btn btn-success explore-btn btn-lg  me-2"
                        type="button"
                        
                        >
                            <i class="bi bi-cart-plus"></i> Add to Cart ➜
                        </button>                        
                        <button 
                            type="button"
                            class="btn btn-success explore-btn btn-lg wishlist-btn"
                            :class="{ 'wishlist-active': isCurrentVariantWishlisted }"
                            :disabled="!selectedOptionVariant"
                            @click.prevent="toggleWishlist(selectedOptionVariant)"
                        >
                            <i class="bi bi-heart"></i>
                            <span v-if="isCurrentVariantWishlisted">Wishlisted</span>
                            <span v-else>Add to Wishlist ➜</span>
                        </button>
                    </div>
                </div>
            </div>
        </template>

    </script>

    <script type="module">

        app.component('v-product-varients-options', {
            template: '#v-product-varients-options-template',

            props: ['errors'],

            data() {
                return {
                    config: @json(app('Webkul\Product\Helpers\ConfigurableOption')->getConfigurationConfig($product)),
                    
                    wishlistedVariants: [],
                    childAttributes: [],

                    possibleOptionVariant: null,

                    selectedOptionVariant: '',

                    galleryImages: [],
                    mainPrice: '',
                    oldPrice: '',
                    isCustomer: '{{ auth()->guard('customer')->check() }}',
                    isWishlist: Boolean("{{ (boolean) auth()->guard()->user()?->wishlist_items->where('channel_id', core()->getCurrentChannel()->id)->where('product_id', $product->id)->count() }}"),
                    wishlistLoaded: false,                   
                };
            },

            mounted(){                                
                
                this.oldPrice = this.config.old_price ?? '';
                this.mainPrice = this.config.main_price ?? '';

                const firstVariantId = Object.keys(this.config.variant_prices)[0];

                if (firstVariantId) {
                    const variantPrice = this.config.variant_prices[firstVariantId];

                    this.oldPrice = variantPrice.regular.formatted_price;
                    this.mainPrice = variantPrice.final.formatted_price;

                    this.selectedOptionVariant = firstVariantId;
                }

                this.fetchWishlistedVariants();

                let attributes = JSON.parse(JSON.stringify(this.config)).attributes.slice();
                let index = attributes.length;
                                
                while (index--) {
                    let attribute = attributes[index];

                    attribute.options = [];

                    if (index) {
                        attribute.disabled = true;
                    } else {
                        this.fillAttributeOptions(attribute);
                    }

                    attribute = Object.assign(attribute, {
                        childAttributes: this.childAttributes.slice(),
                        prevAttribute: attributes[index - 1],
                        nextAttribute: attributes[index + 1]
                    });

                    this.childAttributes.unshift(attribute);
                }                
                                
            },

            computed: {
                isCurrentVariantWishlisted() {
                    const val = parseInt(this.selectedOptionVariant);
                    const result = this.wishlistLoaded && this.wishlistedVariants.includes(val);                    
                    return result;
                }
            },

            watch: {
                selectedOptionVariant(newVal) {
                    console.log('Selected variant changed:', newVal);
                },
                wishlistedVariants(newVal) {
                    console.log('Wishlisted variants updated:', newVal);
                }
            },

            methods: {

                fetchWishlistedVariants() {
                    if (!this.isCustomer) return;

                    this.$axios
                        .get('{{ route('shop.api.customers.account.wishlist.index') }}')
                        .then((response) => {
                            this.wishlistedVariants = response.data.data.map(item => item.product.id);
                            this.wishlistLoaded = true;
                            console.log(this.wishlistedVariants);
                        })                        
                },

                configure(attribute, optionId) {
                    this.possibleOptionVariant = this.getPossibleOptionVariant(attribute, optionId);

                    if (optionId) {
                        attribute.selectedValue = optionId;
                        
                        if (attribute.nextAttribute) {
                            attribute.nextAttribute.disabled = false;

                            this.clearAttributeSelection(attribute.nextAttribute);

                            this.fillAttributeOptions(attribute.nextAttribute);

                            this.resetChildAttributes(attribute.nextAttribute);
                        } else {
                            this.selectedOptionVariant = this.possibleOptionVariant;
                        }
                    } else {
                        this.clearAttributeSelection(attribute);

                        this.clearAttributeSelection(attribute.nextAttribute);

                        this.resetChildAttributes(attribute);
                    }

                    this.reloadPrice();
                    
                    // this.reloadImages();
                },

                getPossibleOptionVariant(attribute, optionId) {
                    let matchedOptions = attribute.options.filter(option => option.id == optionId);

                    if (matchedOptions[0]?.allowedProducts) {
                        return matchedOptions[0].allowedProducts[0];
                    }

                    return undefined;
                },

                fillAttributeOptions(attribute) {
                    let options = this.config.attributes.find(tempAttribute => tempAttribute.id === attribute.id)?.options;

                    attribute.options = [{
                        'id': '',
                        'label': "@lang('shop::app.products.view.type.configurable.select-options')",
                        'products': []
                    }];

                    if (! options) {
                        return;
                    }

                    let prevAttributeSelectedOption = attribute.prevAttribute?.options.find(option => option.id == attribute.prevAttribute.selectedValue);

                    let index = 1;

                    for (let i = 0; i < options.length; i++) {
                        let allowedProducts = [];

                        if (prevAttributeSelectedOption) {
                            for (let j = 0; j < options[i].products.length; j++) {
                                if (prevAttributeSelectedOption.allowedProducts && prevAttributeSelectedOption.allowedProducts.includes(options[i].products[j])) {
                                    allowedProducts.push(options[i].products[j]);
                                }
                            }
                        } else {
                            allowedProducts = options[i].products.slice(0);
                        }

                        if (allowedProducts.length > 0) {
                            options[i].allowedProducts = allowedProducts;

                            attribute.options[index++] = options[i];
                        }
                    }
                },

                resetChildAttributes(attribute) {
                    if (! attribute.childAttributes) {
                        return;
                    }

                    attribute.childAttributes.forEach(function (set) {
                        set.selectedValue = null;

                        set.disabled = true;
                    });
                },

                clearAttributeSelection (attribute) {
                    if (! attribute) {
                        return;
                    }

                    attribute.selectedValue = null;

                    this.selectedOptionVariant = null;
                },

                reloadPrice () {
                    let selectedOptionCount = this.childAttributes.filter(attribute => attribute.selectedValue).length;

                    let finalPrice = document.querySelector('.final-price');

                    let regularPrice = document.querySelector('.regular-price');                    

                    let configVariant = this.config.variant_prices[this.possibleOptionVariant];

                    if (this.childAttributes.length == selectedOptionCount) {
                        document.querySelector('.price-label').style.display = 'none';

                        if (parseInt(configVariant.regular.price) > parseInt(configVariant.final.price)) {
                            regularPrice.style.display = 'block';

                            finalPrice.innerHTML = configVariant.final.formatted_price;

                            regularPrice.innerHTML = configVariant.regular.formatted_price;
                        } else {
                            finalPrice.innerHTML = configVariant.regular.formatted_price;

                            regularPrice.style.display = 'none';
                        }

                        this.$emitter.emit('configurable-variant-selected-event',this.possibleOptionVariant);
                    } else {
                        document.querySelector('.price-label').style.display = 'inline-block';

                        finalPrice.innerHTML = this.config.regular.formatted_price;

                        this.$emitter.emit('configurable-variant-selected-event', 0);
                    }
                },

                reloadImages () {
                    galleryImages.splice(0, galleryImages.length)

                    if (this.possibleOptionVariant) {
                        this.config.variant_images[this.possibleOptionVariant].forEach(function(image) {
                            galleryImages.push(image);
                        });

                        this.config.variant_videos[this.possibleOptionVariant].forEach(function(video) {
                            galleryImages.push(video);
                        });
                    }

                    this.galleryImages.forEach(function(image) {
                        galleryImages.push(image);
                    });

                    if (galleryImages.length) {
                        this.$parent.$parent.$refs.gallery.media.images =  [...galleryImages];
                    }

                    this.$emitter.emit('configurable-variant-update-images-event', galleryImages);
                },

                toggleWishlist(productId) {
                    if (this.isCustomer) {
                        this.$axios
                            .post('{{ route('shop.api.customers.account.wishlist.store') }}', { product_id: productId })
                            .then((response) => {                                
                                const message = response.data.data.message;
                                if (message.toLowerCase().includes('added')) {
                                    if (!this.wishlistedVariants.includes(productId)) {
                                        this.wishlistedVariants.push(productId);
                                    }
                                } else if (message.toLowerCase().includes('removed')) {
                                    this.wishlistedVariants = this.wishlistedVariants.filter(id => id !== productId);
                                }

                                this.$emitter.emit('wishlist:updated');

                                showFlash('success', response.data.data.message);
                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                                
                            })
                            .catch((error) => {
                                console.error('Error updating wishlist:', error);
                            });
                    } else {
                        window.location.href = "{{ route('shop.customer.session.index') }}";
                    }
                },

            }


        });
    </script>
        
    <style scoped>
        .wishlist-active {
            background-color: #29348E !important;
            color: #fff !important;
        }
        .btn-outline-primary.wishlist-active {
            border-color: #29348E;
            background-color: #e8ecff;
            color: #29348E;
        }
    </style>
@endPushOnce


@endif