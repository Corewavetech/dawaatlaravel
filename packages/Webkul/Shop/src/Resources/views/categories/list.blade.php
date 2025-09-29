<v-category-list>
    
</v-category-list>

@pushOnce('scripts')

    <script type="text/x-template" id="v-category-list-template">

        <template v-if="isLoading">
            
        </template>

        <template v-else>
            
            <div class="col-md-3 col-sm-6" v-for="category in categories" :key="category.id">
                <div class="category_item">
                    <img class="pic-1" :src="getCategoryImageUrl(category)" :alt="category.name" />
                    <div class="category_content">
                        <h6 v-html="category.name"></h6>
                        <p>@{{ category.product_count }} Items</p>
                    </div>
                    <button type="button" class="btn btn-success explore-btn">
                        <a :href="getCategoryUrl(category.slug)">View All Products ➜</a>
                    </button>
                </div>
            </div>

        </template>
    </script>

    <script type="module">
        app.component('v-category-list', {
            template: '#v-category-list-template',

        data(){
            return {
                categories : [],
                isLoading: false, 
            }
        },

        mounted(){
            this.getCategories();

            this.$emitter.on('update-category', (categories) => {
                this.categories = categories;
            });
        },

        methods: {

            getCategories(){
                this.isLoading = true;

                this.$axios
                .get('{{ route('shop.api.categories.index') }}')
                .then((response) => {                    
                    this.categories = response.data.data.filter(category => category.parent_id !== null);
                    this.isLoading = false;
                    // console.log(response);
                })
                .catch((error) => {
                    console.error('Error fetching products:', error);
                    this.isLoading = false;
                });

            },

            getCategoryImageUrl(category) {                
                if (category.logo && category.logo.original_image_url) {
                    return category.logo.original_image_url;
                }
                return '{{ bagisto_asset("website/images/png/category_product.png") }}';
            },

            getCategoryUrl(slug) {
                return `{{ route('shop.home.index') }}/${slug}`;
            },


        }
        

        });
                    
    </script>

<style scoped>    
    .category_item {
        position: relative;        
    }

    .category_content {
        position: absolute;
        bottom: 0;
        left: 38%;
        text-align: center;        
    }

    .category_content h6 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 2px;
    }

    .category_content p {
        font-size: 12px;
        margin-top: 0;
        margin-bottom: 5px; 
    }
</style>
@endpushOnce