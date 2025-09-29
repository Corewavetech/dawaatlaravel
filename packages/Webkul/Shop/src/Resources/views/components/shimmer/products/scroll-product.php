<section class="py-5 overflow-hidden">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between my-5">
                    <h2 class="section-title shimmer rounded" style="width: 200px; height: 24px;"></h2>
                    <div class="d-flex align-items-center">
                        <div class="swiper-buttons">
                            <button class="swiper-prev products-carousel-prev btn btn-primary shimmer" style="width: 30px; height: 30px;"></button> |
                            <button class="swiper-next products-carousel-next btn btn-primary shimmer" style="width: 30px; height: 30px;"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="products-carousel swiper">
                    <div class="swiper-wrapper d-flex justify-content-between">
                        <!-- Loop for loading skeleton product items (5 placeholders) -->
                        <div class="product-item swiper-slide" v-for="i in 5" :key="'skeleton-product-' + i" style="max-width:241px !important;">
                            <div class="shimmer rounded-pill position-absolute m-3" style="width: 50px; height: 20px;"></div> <!-- Sale Badge -->

                            <!-- Placeholder for Product Image -->
                            <div class="shimmer rounded" style="width: 100%; height: 180px;"></div>

                            <!-- Product Title Placeholder -->
                            <div class="shimmer rounded mt-3" style="width: 100%; height: 20px;"></div>

                            <!-- Rating Placeholder -->
                            <div class="d-flex gap-1 mt-2">
                                <div v-for="star in 5" :key="'skeleton-star-' + star" class="shimmer rounded" style="width: 20px; height: 20px;"></div>
                            </div>

                            <!-- Price Placeholder -->
                            <div class="price d-flex mt-2">
                                <div class="shimmer rounded" style="width: 80px; height: 20px;"></div>
                                <div class="shimmer rounded ms-2" style="width: 60px; height: 16px;"></div>
                            </div>

                            <!-- Buttons Placeholder -->
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <button type="button" class="btn btn-success btn-sm add_to_cart explore-btn shimmer" style="width: 100px; height: 30px;"></button>
                                <button type="button" class="btn btn-success btn-sm buy_now explore-btn shimmer" style="width: 100px; height: 30px;"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>