@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')
@inject ('productViewHelper', 'Webkul\Product\Helpers\View')

@php
    $avgRatings = $reviewHelper->getAverageRating($product);
    $avgRatingsCount = $reviewHelper->getTotalReviews($product);

    $percentageRatings = $reviewHelper->getPercentageRating($product);

    $customAttributeValues = $productViewHelper->getAdditionalData($product);

    $attributeData = collect($customAttributeValues)->filter(fn($item) => !empty($item['value']));

    $fullStars = floor($avgRatings);
    $halfStar = ($avgRatings - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

    $reviewRating = $reviewHelper->getReviewsAndRatings($product);

@endphp

<!-- SEO Meta Content -->
@push('meta')
<meta name="description"
    content="{{ trim($product->meta_description) != "" ? $product->meta_description : \Illuminate\Support\Str::limit(strip_tags($product->description), 120, '') }}" />

<meta name="keywords" content="{{ $product->meta_keywords }}" />

@if (core()->getConfigData('catalog.rich_snippets.products.enable'))
    <script type="application/ld+json">
                                                            {!! app('Webkul\Product\Helpers\SEO')->getProductJsonLd($product) !!}
                                                        </script>
@endif

<?php $productBaseImage = product_image()->getProductBaseImage($product); ?>

<meta name="twitter:card" content="summary_large_image" />

<meta name="twitter:title" content="{{ $product->name }}" />

<meta name="twitter:description" content="{!! htmlspecialchars(trim(strip_tags($product->description))) !!}" />

<meta name="twitter:image:alt" content="" />

<meta name="twitter:image" content="{{ $productBaseImage['medium_image_url'] }}" />

<meta property="og:type" content="og:product" />

<meta property="og:title" content="{{ $product->name }}" />

<meta property="og:image" content="{{ $productBaseImage['medium_image_url'] }}" />

<meta property="og:description" content="{!! htmlspecialchars(trim(strip_tags($product->description))) !!}" />

<meta property="og:url" content="{{ route('shop.product_or_category.index', $product->url_key) }}" />
@endPush

<!-- Page Layout -->
<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{ trim($product->meta_title) != "" ? $product->meta_title : $product->name }}
        </x-slot>

        {!! view_render_event('bagisto.shop.products.view.before', ['product' => $product]) !!}

        <!-- Breadcrumbs -->
        <section>
            <div class="show_breadcrumb">
                <div class="container-fluid">

                    <nav aria-label="breadcrumb" class="m-5 my-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('shop.home.index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>

        @php
            $product_images = product_image()->getGalleryImages($product) ?? [];
            $product_videos = product_video()->getVideos($product) ?? [];
            $product_media = array_merge($product_images, $product_videos);
        @endphp

        <section>
            <div class="product_details">

                <div class="container-fluid mt-5">
                    <div class="row">
                        <!-- Product Images -->
                        <div class="col-md-6 mb-4">
                            <div class="magnify_product">
                                <div class="main_product_img">
                                    @php
                                        $firstMedia = $product_media[0];
                                    @endphp

                                    @if ($firstMedia && isset($firstMedia->type) && $firstMedia->type === 'videos')
                                        <video width="320" height="240" controls>
                                            <source src="{{ $firstMedia->video_url }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @elseif ($firstMedia && isset($firstMedia['original_image_url']))
                                        <img src="{{ $firstMedia['original_image_url'] }}" alt="Product"
                                            class="img-fluid rounded mb-3 product-image" id="mainImage">
                                    @else
                                        <img src="{{ bagisto_asset('website/images/png/product_img.png') }}" alt="Product"
                                            class="img-fluid rounded mb-3 product-image" id="mainImage">
                                    @endif

                                </div>
                                <div class="details_mobile d-flex flex-column justify-content-between  gap-2">

                                    @foreach ($product_media as $media)
                                        @if ($media && isset($media->type) && $media->type == 'videos')
                                            <video width="320" height="240" controls>
                                                <source src="{{ $media->video_url }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <img src="{{ $media['original_image_url'] }}" alt="Thumbnail"
                                                class="thumbnail rounded active" onclick="changeImage(event, this.src)">
                                        @endif

                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="col-md-6">
                            <div class="product_details_content">


                                <h2 class="mb-3">{{ $product->name }}</h2>
                                <h5>
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="bi bi-star-fill text-primary"></i>
                                    @endfor

                                    @if ($halfStar)
                                        <i class="bi bi-star-half text-primary"></i>
                                    @endif

                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="bi bi-star text-primary"></i>
                                    @endfor

                                    <a href="#">({{ $avgRatingsCount }} customer review)</a>
                                </h5>
                                <p class="mb-2">{!! $product->short_description !!}</p>

                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="product_decs_item">
                                                <p>Category :</p>
                                                <p>{{ optional($product->categories)->first()->name }} </p>
                                            </div>
                                            <div class="product_decs_item">
                                                <p>Stock :</p>
                                                @if($product->type !== 'configurable')
                                                    <p>{{ $product->totalQuantity() > 0 ? 'In Stock' : 'Out of Stock' }}
                                                    </p>
                                                @else
                                                    @php
                                                        $hasStock = false;
                                                    @endphp
                                                    @foreach ($product->variants as $variant)
                                                        @if ($variant->totalQuantity() > 0)
                                                            @php
                                                                $hasStock = true;
                                                                break;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    @if ($hasStock)
                                                        <p>In Stock</p>
                                                    @else
                                                        <p style="color: red">Out Of Stock</p>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="product_decs_item">
                                                <p>Farm :</p>
                                                <p>Grocery Farm Fields </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="product_decs_item">
                                                <p>Buy by :</p>
                                                <p>kgs </p>
                                            </div>
                                            <div class="product_decs_item">
                                                <p>Delivery :</p>
                                                <p>in 2 days </p>
                                            </div>
                                            <div class="product_decs_item">
                                                <p>Delivery area :</p>
                                                <p>Pan India </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @php

                                    $groupCodeAttribute = Webkul\Attribute\Models\Attribute::where('code', 'weight_options')->first();
                                    $variants = collect();

                                    if ($groupCodeAttribute && $product->weight_options) {

                                        $productIds = Webkul\Product\Models\ProductAttributeValue::where('attribute_id', $groupCodeAttribute->id)
                                            ->pluck('product_id');

                                        $variants = Webkul\Product\Models\ProductFlat::whereIn('product_id', $productIds)
                                            // ->where('product_id', '!=', $product->id)
                                            ->where('status', 1)
                                            ->get();
                                    }


                                @endphp

                                @if ($variants->isNotEmpty())
                                    <div class="mb-4">
                                        <h5>Size</h5>
                                        <div class="btn-group" role="group" aria-label="Product size variants">
                                            @foreach ($variants as $index => $variant)
                                                <input type="radio" class="btn-check" name="btnradio" id="btnradio-{{ $index }}"
                                                    {{ $variant->product_id == $product->id ? 'checked' : '' }}>
                                                <label class="btn btn-outline-primary" for="btnradio-{{ $index }}">
                                                    @if ($variant->product_id == $product->id)
                                                        {{ number_format($variant->weight, 2) }} KG
                                                    @else
                                                        <a href="{{ url('/', $variant->url_key) }}" class="text-decoration-none"
                                                            style="color: inherit;">
                                                            {{ number_format($variant->weight, 2) }} KG
                                                        </a>
                                                    @endif
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if (Webkul\Product\Helpers\ProductType::hasVariants($product->type))
                                    @include('shop::products.view.types.varients')
                                @else
                                    @include('shop::products.view.types.simple')

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- <section>
            <div class="online_available">
                <h5>Also Available On: </h5>
                <div class="delivery_icons">
                    <img src="{{bagisto_asset('website/images/png/amazon.png')}}" />
                    <img src="{{bagisto_asset('website/images/png/flipcart.png')}}" />
                    <img src="{{bagisto_asset('website/images/png/swigy.png')}}" />
                    <img src="{{bagisto_asset('website/images/png/blinkit.png')}}" />
                    <img src="{{bagisto_asset('website/images/png/zepto.png')}}" />
                </div>
            </div>
        </section> --}}


        <section class="product-tabs py-5">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <div class="bootstrap-tabs ">
                            <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a href="#" class="nav-link text-uppercase fs-6 active" id="nav-all-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-description">Description</a>
                                        <a href="#" class="nav-link text-uppercase fs-6" id="nav-fruits-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-review">Reviews</a>
                                        <a href="#" class="nav-link text-uppercase fs-6" id="nav-juices-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-faq">Faq's</a>
                                    </div>
                                </nav>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                                    aria-labelledby="nav-all-tab">

                                    {!! $product->description !!}

                                </div>

                                <div class="tab-pane fade" id="nav-review" role="tabpanel"
                                    aria-labelledby="nav-fruits-tab">


                                    <div class="container-fluid ">
                                        <h2 class="mb-3">{{ $avgRatingsCount }} reviews</h2>
                                        <div class="show_rating">
                                            <div class="rating_item">
                                                <div class="row">
                                                    <div class="col-md-6 ">
                                                        <div class="d-flex align-items-center ">
                                                            <div class="mb-3 mx-4">
                                                                <h5>
                                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                                        <i class="bi bi-star-fill text-primary"></i>
                                                                    @endfor

                                                                    @if ($halfStar)
                                                                        <i class="bi bi-star-half text-primary"></i>
                                                                    @endif

                                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                                        <i class="bi bi-star text-primary"></i>
                                                                    @endfor
                                                                </h5>
                                                            </div>
                                                            <h5 class="mx-2">{{$avgRatings}}</h5>
                                                            <h6 class="text-muted ">overall rating</h6>
                                                        </div>
                                                        <hr class="w-50" />
                                                        <div class="total_review_rate">
                                                            <p><strong>{{ floor((94.8 / 100) * $avgRatingsCount) }}</strong>
                                                                out of <strong>{{ $avgRatingsCount }}</strong> (94.8%)
                                                                our
                                                                customer <br /> recommendede this product to all users
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="rating-bars">

                                                            @foreach ($percentageRatings as $keyPercentage => $percentage)
                                                                <div class="rating-bar mb-3">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center mb-1">
                                                                        <p class="mb-0">

                                                                            <i class="bi bi-star-fill text-primary"></i>
                                                                            <span>{{$keyPercentage}} stars</span>
                                                                        </p>
                                                                        <small class="text-muted">{{$percentage}}%</small>
                                                                    </div>
                                                                    <div class="progress" style="height: 10px;">
                                                                        <div class="progress-bar bg-primary"
                                                                            role="progressbar"
                                                                            style="width: {{$percentage}}%;"
                                                                            aria-valuenow="70" aria-valuemin="0"
                                                                            aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>

                                                @if (auth()->guard('customer')->user())
                                                    <!-- Rating Modal -->
                                                    <div class="modal fade" id="ratingModal" tabindex="-1"
                                                        aria-labelledby="ratingModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form id="reviewRatingForm" enctype="multipart/form-data">
                                                                    <input type="hidden" name="attachments[]"
                                                                        id="attachments" multiple>
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="ratingModalLabel">Write
                                                                            a Review</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="rating" class="form-label">Your
                                                                                Rating</label>
                                                                            <div class="star-rating">
                                                                                <i class="bi bi-star-fill k-rating-star"
                                                                                    data-rating="1"></i>
                                                                                <i class="bi bi-star-fill k-rating-star"
                                                                                    data-rating="2"></i>
                                                                                <i class="bi bi-star-fill k-rating-star"
                                                                                    data-rating="3"></i>
                                                                                <i class="bi bi-star-fill k-rating-star"
                                                                                    data-rating="4"></i>
                                                                                <i class="bi bi-star-fill k-rating-star"
                                                                                    data-rating="5"></i>
                                                                            </div>
                                                                            <input type="hidden" id="rating" name="rating"
                                                                                value="5">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="mb-3">
                                                                                    <label for="title"
                                                                                        class="form-label">Title</label>
                                                                                    <input class="form-control" name="title"
                                                                                        id="title" rows="3"
                                                                                        required></input>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label for="comment" class="form-label">Your
                                                                                Review</label>
                                                                            <textarea class="form-control" name="comment"
                                                                                id="comment" rows="3" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" id="submit-review"
                                                                            class="btn btn-primary">Submit Review</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <x-shop::products.review-rating :title="$avgRatingsCount"
                                                    :src="route('shop.api.products.reviews.index', $product->id)" />

                                                @if (auth()->guard('customer')->user())
                                                    <div class="text-center ">
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#ratingModal">Write a Review</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="tab-pane fade" id="nav-faq" role="tabpanel"
                                    aria-labelledby="nav-juices-tab">
                                    <div class="show_faq">

                                        <div class="accordion" id="accordionExample">
                                            <div class="card mb-2">
                                                <div class="card-header" id="headingOne">
                                                    <h2 class="mb-0">
                                                        <button
                                                            class="btn btn-link text-decoration-none d-flex justify-content-between w-100 align-items-center"
                                                            type="button" data-toggle="collapse"
                                                            data-target="#collapseOne" aria-expanded="true"
                                                            aria-controls="collapseOne">
                                                            What types of rice does Dawat offer?
                                                            <i class="fas fa-chevron-down rotate-icon"></i>
                                                        </button>

                                                    </h2>
                                                </div>

                                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        Dawat offers a wide variety of premium rice including Basmati,
                                                        Sella
                                                        Basmati, Brown Basmati, and Everyday Rice suitable for different
                                                        cuisines and cooking styles.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card mb-2">
                                                <div class="card-header" id="headingTwo">
                                                    <h2 class="mb-0">
                                                        <button
                                                            class="btn btn-link text-decoration-none d-flex justify-content-between w-100 align-items-center"
                                                            type="button" data-toggle="collapse"
                                                            data-target="#collapseTwo" aria-expanded="true"
                                                            aria-controls="collapseTwo">
                                                            What is the best way to cook Dawat Basmati Rice?
                                                            <i class="fas fa-chevron-down rotate-icon"></i>
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        For best results, rinse the rice 2-3 times, soak for 30 minutes,
                                                        then cook with 1.5 to 2 cups of water per cup of rice on medium
                                                        heat
                                                        until fluffy.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card mb-2">
                                                <div class="card-header" id="headingThree">
                                                    <h2 class="mb-0">
                                                        <button
                                                            class="btn btn-link text-decoration-none d-flex justify-content-between w-100 align-items-center"
                                                            type="button" data-toggle="collapse"
                                                            data-target="#collapseThree" aria-expanded="true"
                                                            aria-controls="collapseThree">
                                                            How should I store rice after opening the package?
                                                            <i class="fas fa-chevron-down rotate-icon"></i>
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        Store rice in an airtight container in a cool, dry place away
                                                        from
                                                        moisture and direct sunlight to maintain freshness.


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-2">
                                                <div class="card-header" id="headingTwo">
                                                    <h2 class="mb-0">
                                                        <button
                                                            class="btn btn-link text-decoration-none d-flex justify-content-between w-100 align-items-center"
                                                            type="button" data-toggle="collapse"
                                                            data-target="#collapseFour" aria-expanded="true"
                                                            aria-controls="collapseFour">
                                                            Is Dawat rice gluten-free?
                                                            <i class="fas fa-chevron-down rotate-icon"></i>
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseFour" class="collapse" aria-labelledby="headingTwo"
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        Yes, all Dawat rice varieties are naturally gluten-free and
                                                        suitable
                                                        for people with gluten intolerance or celiac disease.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card mb-2">
                                                <div class="card-header" id="headingThree">
                                                    <h2 class="mb-0">
                                                        <button
                                                            class="btn btn-link text-decoration-none d-flex justify-content-between w-100 align-items-center"
                                                            type="button" data-toggle="collapse"
                                                            data-target="#collapseFive" aria-expanded="true"
                                                            aria-controls="collapseFive">
                                                            Can I use Dawat rice for biryani or pulao?
                                                            <i class="fas fa-chevron-down rotate-icon"></i>
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseFive" class="collapse" aria-labelledby="headingThree"
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        Absolutely! Dawat Basmati and Sella Basmati are perfect for
                                                        biryani,
                                                        pulao, and other festive rice dishes due to their long grains
                                                        and
                                                        aromatic flavor.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-2">
                                                <div class="card-header" id="headingTwo">
                                                    <h2 class="mb-0">
                                                        <button
                                                            class="btn btn-link text-decoration-none d-flex justify-content-between w-100 align-items-center"
                                                            type="button" data-toggle="collapse"
                                                            data-target="#collapseSix" aria-expanded="true"
                                                            aria-controls="collapseSix">
                                                            Is Dawat rice aged?
                                                            <i class="fas fa-chevron-down rotate-icon"></i>
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseSix" class="collapse" aria-labelledby="headingTwo"
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        Yes, Dawat Basmati Rice is aged for up to 12-24 months to
                                                        enhance
                                                        its aroma, texture, and cooking performance.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card mb-2">
                                                <div class="card-header" id="headingThree">
                                                    <h2 class="mb-0">
                                                        <button
                                                            class="btn btn-link text-decoration-none d-flex justify-content-between w-100 align-items-center"
                                                            type="button" data-toggle="collapse"
                                                            data-target="#collapseSeven" aria-expanded="true"
                                                            aria-controls="collapseSeven">
                                                            Where is Dawat rice sourced from?
                                                            <i class="fas fa-chevron-down rotate-icon"></i>
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseSeven" class="collapse" aria-labelledby="headingThree"
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        Dawat rice is primarily sourced from the foothills of the
                                                        Himalayas,
                                                        known for producing the finest quality Basmati rice in the
                                                        world.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- @include('shop::products.carousal') --}}

        <x-shop::products.carousel :title="trans('shop::app.products.view.related-product-title')"
            :src="route('shop.api.products.related.index', ['id' => $product->id])" />

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

        <x-shop::products.carousel :title="trans('Featured Products')" :src="route('shop.api.products.index', ['featured' => 1, 'sort' => 'name', 'limit' => 4])" />
        {{-- @include('shop::products.carousal') --}}
        <script>
            function changeImage(event, src) {
                document.getElementById('mainImage').src = src;
                document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
                event.target.classList.add('active');
            }
        </script>

        {!! view_render_event('bagisto.shop.products.view.after', ['product' => $product]) !!}

</x-shop::layouts>
<script>
    $(document).ready(function () {
        $('body').on('click', '.k-rating-star', function () {
            var rating = parseInt($(this).data('rating'));
            var $stars = $(this).closest('.star-rating').find('.k-rating-star');
            $('#rating').val(rating);

            $stars.removeClass('bi-star-fill').addClass('bi-star');

            $stars.each(function (index) {
                if (index < rating) {
                    $(this).removeClass('bi-star').addClass('bi-star-fill');
                }
            });
        });

        $(document).on('submit', '#reviewRatingForm', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            let url = "{{ route('shop.api.products.reviews.store', $product->id) }}";
            let token = '{{ csrf_token() }}';

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function (response) {
                    window.app.config.globalProperties.$emitter.emit('add-flash', {
                        type: 'success',
                        message: response.data.message
                    });

                    alert('Review submitted successfully!');
                    document.getElementById('reviewRatingForm').reset();

                },
                error: function (xhr) {
                    window.app.config.globalProperties.$emitter.emit('add-flash', {
                        type: 'error',
                        message: response.data.message
                    });
                }
            });

        });

    });
</script>