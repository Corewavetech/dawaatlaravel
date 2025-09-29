<!-- SEO Meta Content -->
@push('meta')
    <meta 
        name="description" 
        content="{{ trim($category->meta_description) != "" ? $category->meta_description : \Illuminate\Support\Str::limit(strip_tags($category->description), 120, '') }}"
    />

    <meta 
        name="keywords" 
        content="{{ $category->meta_keywords }}"
    />

    @if (core()->getConfigData('catalog.rich_snippets.categories.enable'))
        <script type="application/ld+json">
            {!! app('Webkul\Product\Helpers\SEO')->getCategoryJsonLd($category) !!}
        </script>
    @endif
@endPush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{ trim($category->meta_title) != "" ? $category->meta_title : $category->name }}
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
    
    @include('shop::products.index', ['category'=>$category])

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
