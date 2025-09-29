@php
  $channel = core()->getCurrentChannel();
@endphp

<!-- SEO Meta Content -->
@push ('meta')
<meta name="title" content="{{ $channel->home_seo['meta_title'] ?? '' }}" />

<meta name="description" content="{{ $channel->home_seo['meta_description'] ?? '' }}" />

<meta name="keywords" content="{{ $channel->home_seo['meta_keywords'] ?? '' }}" />


@endPush

<x-shop::layouts>
  <!-- Page Title -->
  <x-slot:title>
    {{  $channel->home_seo['meta_title'] ?? '' }}
    </x-slot>

    <section
      style="background-image: url('{{bagisto_asset('website/images/background-pattern.jpg')}}');background-repeat: no-repeat;background-size: cover;">
      <div class="main-section">

        <div class="container-fluid">
          <div class="banner-blocks">
            <div class="row">

              <div class="col-md-5 large p-2  block-1">

                <div class="swiper main-swiper">
                  <div class="swiper-wrapper">

                    <div class="swiper-slide">
                      <div class="row banner-content ">
                        <div class="content-wrapper col-md-12">
                          <div class="categories my-3">100% natural</div>
                          <h3 class="display-5 title_color">Every Grain, A Story of Perfection.</h3>
                          <p>From Farm to Fork, Relish the Aroma, Taste, and Quality of Daawat Basmati Rice.
                          </p>
                          <div class="input-group mb-3 search_input">
                            <input type="text" class="form-control input-group-lg search_racipe"
                              placeholder="Search here..." aria-label="Recipient's username"
                              aria-describedby="basic-addon2">
                            <span class="input-group-text " id="find_racipe">
                              <svg class="mx-2" width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#search"></use>
                              </svg> Find Racipe</span>
                          </div>
                          <div class="show_seach_tag">
                            <button type="button" class="btn btn-success explore-btn">For Lunch</button>
                            <button type="button" class="btn btn-success explore-btn">For Dinner</button>
                            <button type="button" class="btn btn-success expre-btn">For Breakfast</button>
                            <button type="button" class="btn btn-success explore-btn">For Snack</button>
                            <button type="button" class="btn btn-success explore-btn">For Kids</button>
                            <button type="button" class="btn btn-success explore-btn">For Party</button>
                          </div>
                          <div class="show_whatsapp_btn">
                            <button type="button" class="btn btn-success explore-btn"><img
                                src="{{ bagisto_asset('website/images/png/whatsapp_icon.png') }}" />
                              Click Here to Join Our WhatsApp
                              Community</button>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="swiper-pagination"></div>

                </div>
              </div>

              <div class="col-md-7  block-2  show_banner_img">
                <!-- Gallery -->
                <div class="row">
                  <div class="col-lg-4 col-md-12 mb-4 mb-lg-0 ">
                    <img src="{{ bagisto_asset('website/images/png/banner1.jpg') }}"
                      class="w-100 shadow-1-strong  mb-4  banner1" alt="Boat on Calm Water" />
                    <img src="{{ bagisto_asset('website/images/png/banner2.jpg') }}"
                      class="w-100 shadow-1-strong  mb-4   banner2" alt="Boat on Calm Water" />
                    <img src="{{ bagisto_asset('website/images/png/banner3.jpg') }}"
                      class="w-100 shadow-1-strong  mb-4  banner2" alt="Boat on Calm Water" />
                    <!-- <img src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain1.webp"
                        class="w-100 shadow-1-strong  mb-4" alt="Wintry Mountain Landscape" /> -->


                  </div>

                  <div class="col-lg-4 mb-4 mb-lg-0">
                    <img src="{{ bagisto_asset('website/images/png/banner4.jpg') }}"
                      class="w-100 shadow-1-strong  mb-4  banner3" alt="Boat on Calm Water" />
                    <img src="{{ bagisto_asset('website/images/png/banenr5.jpg') }}"
                      class="w-100 shadow-1-strong  mb-4  banner2" alt="Boat on Calm Water" />
                    <img src="{{ bagisto_asset('website/images/png/banner6.jpg') }}"
                      class="w-100 shadow-1-strong  banner4 mb-4" alt="Boat on Calm Water" />
                  </div>

                  <div class="col-lg-4 mb-4 mb-lg-0">
                    <img src="{{ bagisto_asset('website/images/png/banner7.jpg') }}"
                      class="w-100 shadow-1-strong banner5 mb-4" alt="Waves at Sea" />

                    <img src="{{ bagisto_asset('website/images/png/banner8.jpg') }}"
                      class="w-100 shadow-1-strong banner6 mb-4" alt="Yosemite National Park" />
                  </div>
                </div>
                <!-- Gallery -->
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="expore_product">
        <div class="expore_product_img">
          <img src="{{ bagisto_asset('website/images/png/banner3.jpg') }}" />
        </div>
        <div class="expore_product_content">
          <h4>Lorem ipsum, dolor sit amet consectetur adipisicing elit. </h4>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat eveniet, illum hic eaque vitae ipsam nobis
            saepe molestias laudantium nesciunt.</p>
          <a href="{{ route('shop.api.categories.all') }}"><button type="button" class="btn btn-success explore-btn">
              Explore Products Now ➜
            </button></a>

        </div>
      </div>
    </section>

    <section class="py-2 overflow-hidden">
      <div class="container-fluid ">
        <div class="row">
          <div class="col-md-12">

            <div class="section-header d-flex  flex-wrap justify-content-between mb-5">

              <h2 class="section-title">Featured Section</h2>

              <div class="d-flex align-items-center">
                <!-- <a href="#" class="btn-link text-decoration-none">View All Categories →</a> -->
                <div class="swiper-buttons">
                  <button class="swiper-prev brand-carousel-prev btn btn-yellow">❮</button> |
                  <button class="swiper-next brand-carousel-next btn btn-yellow">❯</button>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="row">
          <div class="col-md-12">

            <div class="brand-carousel swiper">
              <div class="swiper-wrapper">

                <div class="swiper-slide">
                  <div class="card mb-3 p-3 feature_card  border-0">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="{{ bagisto_asset('website/images/product-thumb-11.jpg') }}"
                          class="img-fluid feature_img" alt="Card title">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body py-0">
                          <span class="badge rounded-pill bg-primary mb-2">Subscription</span>

                          <h5 class="text-muted mb-0">Purchase Subscription</h5>
                          <p class="card-title">Save upto $40 on every purchase.</p>
                          <button type="button" class="btn btn-success explore-btn">Subscribe Now ➜</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-3 p-3 feature_card  border-0">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="{{ bagisto_asset('website/images/product-thumb-12.jpg') }}"
                          class="img-fluid feature_img" alt="Card title">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body py-0">
                          <span class="badge rounded-pill mb-2 bg-primary">Subscription</span>

                          <h5 class="text-muted mb-0">Purchase Subscription</h5>
                          <p class="card-title">Save upto $40 on every purchase.</p>
                          <button type="button" class="btn btn-success explore-btn">Subscribe Now ➜</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-3 p-3 feature_card  border-0">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="{{ bagisto_asset('website/images/product-thumb-13.jpg') }}
                         " class="img-fluid feature_img" alt="Card title">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body py-0">
                          <span class="badge rounded-pill mb-2 bg-primary">Subscription</span>

                          <h5 class="text-muted mb-0">Purchase Subscription</h5>
                          <p class="card-title">Save upto $40 on every purchase.</p>
                          <button type="button" class="btn btn-success explore-btn">Subscribe Now ➜</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-3 p-3 feature_card  border-0">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="{{ bagisto_asset('website/images/product-thumb-14.jpg') }}"
                          class="img-fluid feature_img" alt="Card title">

                      </div>
                      <div class="col-md-8">
                        <div class="card-body py-0">
                          <span class="badge rounded-pill mb-2 bg-primary">Subscription</span>

                          <h5 class="text-muted mb-0">Purchase Subscription</h5>
                          <p class="card-title">Save upto $40 on every purchase.</p>
                          <button type="button" class="btn btn-success explore-btn">Subscribe Now ➜</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-3 p-3 feature_card  border-0">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="{{ bagisto_asset('website/images/product-thumb-11.jpg') }}"
                          class="img-fluid feature_img" alt="Card title">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body py-0">
                          <span class="badge rounded-pill mb-2 bg-primary">Subscription</span>

                          <h5 class="text-muted mb-0">Purchase Subscription</h5>
                          <p class="card-title">Save upto $40 on every purchase.</p>
                          <button type="button" class="btn btn-success explore-btn">Subscribe Now ➜</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-3 p-3 feature_card  border-0">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="{{ bagisto_asset('website/images/product-thumb-11.jpg') }}"
                          class="img-fluid feature_img" alt="Card title">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body py-0">
                          <span class="badge rounded-pill bg-primary mb-2">Subscription</span>
                          <h5 class="text-muted mb-0">Purchase Subscription</h5>
                          <p class="card-title">Save upto $40 on every purchase.</p>
                          <button type="button" class="btn btn-success explore-btn">Subscribe Now ➜</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
        <div class="show_bg_design">
          <img src="/images/png/bg_img.png">
        </div>
      </div>
    </section>

    {{-- <section class="py-2 overflow-hidden">
      <div class="container-fluid ">
        <div class="row">
          <div class="col-md-12">

            <div class="section-header d-flex flex-wrap flex-wrap justify-content-between mb-5">

              <h2 class="section-title">Featured Section</h2>

              <div class="d-flex align-items-center">
                <!-- <a href="#" class="btn-link text-decoration-none">View All Categories →</a> -->
                <div class="swiper-buttons">
                  <button class="swiper-prev brand-carousel-prev btn btn-yellow">❮</button> |
                  <button class="swiper-next brand-carousel-next btn btn-yellow">❯</button>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="row">
          <div class="col-md-12">

            <div class="brand-carousel swiper">
              <div class="swiper-wrapper">

                <div class="swiper-slide">
                  <div class="card mb-3 p-3 feature_card  border-0">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="{{ bagisto_asset('website/images/product-thumb-11.jpg') }}"
                          class="img-fluid feature_img mt-4" alt="Card title">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body py-0">
                          <span class="badge rounded-pill bg-primary mb-2">Subscription</span>

                          <h5 class="text-muted mb-0">Purchase Subscription</h5>
                          <p class="card-title">Save upto $40 on every purchase.</p>
                          <button type="button" class="btn btn-success explore-btn ml-3">Subscribe Now ➜</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-3 p-3 feature_card  border-0">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="{{ bagisto_asset('website/images/product-thumb-12.jpg') }}"
                          class="img-fluid feature_img mt-3" alt="Card title">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body py-0">
                          <span class="badge rounded-pill mb-2 bg-primary">Subscription</span>

                          <h5 class="text-muted mb-0">Purchase Subscription</h5>
                          <p class="card-title">Save upto $40 on every purchase.</p>
                          <button type="button" class="btn btn-success explore-btn">Subscribe Now ➜</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-3 p-3 feature_card  border-0">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="{{ bagisto_asset('website/images/product-thumb-13.jpg') }}"
                          class="img-fluid feature_img mt-3" alt="Card title">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body py-0">
                          <span class="badge rounded-pill mb-2 bg-primary">Subscription</span>

                          <h5 class="text-muted mb-0">Purchase Subscription</h5>
                          <p class="card-title">Save upto $40 on every purchase.</p>
                          <button type="button" class="btn btn-success explore-btn">Subscribe Now ➜</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-3 p-3 feature_card  border-0">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="{{ bagisto_asset('website/images/product-thumb-14.jpg') }}"
                          class="img-fluid feature_img mt-3" alt="Card title">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body py-0">
                          <span class="badge rounded-pill mb-2 bg-primary">Subscription</span>

                          <h5 class="text-muted mb-0">Purchase Subscription</h5>
                          <p class="card-title">Save upto $40 on every purchase.</p>
                          <button type="button" class="btn btn-success explore-btn">Subscribe Now ➜</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-3 p-3 feature_card  border-0">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="{{ bagisto_asset('website/images/product-thumb-11.jpg') }}"
                          class="img-fluid feature_img mt-3" alt="Card title">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body py-0">
                          <span class="badge rounded-pill mb-2 bg-primary">Subscription</span>

                          <h5 class="text-muted mb-0">Purchase Subscription</h5>
                          <p class="card-title">Save upto $40 on every purchase.</p>
                          <button type="button" class="btn btn-success explore-btn">Subscribe Now ➜</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card mb-3 p-3 feature_card  border-0">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="{{ bagisto_asset('website/images/product-thumb-12.jpg') }}"
                          class="img-fluid feature_img mt-3" alt="Card title">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body py-0">
                          <span class="badge rounded-pill bg-primary mb-2">Subscription</span>
                          <h5 class="text-muted mb-0">Purchase Subscription</h5>
                          <p class="card-title">Save upto $40 on every purchase.</p>
                          <button type="button" class="btn btn-success explore-btn">Subscribe Now ➜</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
        <div class="show_bg_design">
          <img src="/images/png/bg_img.png">
        </div>
      </div>
    </section> --}}

    {{-- <section class="py-5 overflow-hidden">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

            <div class="section-header d-flex flex-wrap justify-content-between my-5">

              <h2 class="section-title">Featured Products</h2>

              <div class="d-flex align-items-center">
                <!-- <a href="#" class="btn-link text-decoration-none">View All Categories →</a> -->
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

                <div class="product-item swiper-slide">
                  <span class="badge bg-primary rounded-pill position-absolute m-3">-15%</span>
                  <a href="#" class="btn-wishlist"><svg width="24" height="24">
                      <use xlink:href="#heart"></use>
                    </svg></a>
                  <figure>
                    <a href="index.html" title="Product Title">
                      <img src="{{ bagisto_asset('website/images/png/product_img.png') }}" class="tab-image">
                    </a>
                  </figure>
                  <h6>Sunstar Fresh Melon Juice</h6>
                  <span class="qty">

                  </span><span class="rating"><svg width="24" height="24" class="text-primary">
                      <use xlink:href="#star-solid"></use>
                    </svg> 4.5</span>
                  <span class="price">₹18.00</span>
                  <div class="d-flex align-items-center justify-content-between mt-2">
                    <div class="input-group product-qty">
                      <span class="input-group-btn">
                        <button type="button" class="quantity-left-minus btn btn-danger btn-number explore-btn"
                          data-type="minus">
                          <svg width="16" height="16">
                            <use xlink:href="#minus"></use>
                          </svg>
                        </button>
                      </span>
                      <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                      <span class="input-group-btn">
                        <button type="button" class="quantity-right-plus btn btn-success btn-number explore-btn"
                          data-type="plus">
                          <svg width="16" height="16">
                            <use xlink:href="#plus"></use>
                          </svg>
                        </button>
                      </span>
                    </div>
                    <button type="button" class="btn btn-success btn-sm  buy_now explore-btn"> Buy Now</button>
                  </div>
                </div>

                <div class="product-item swiper-slide">
                  <span class="badge bg-primary rounded-pill position-absolute m-3">-15%</span>
                  <a href="#" class="btn-wishlist"><svg width="24" height="24">
                      <use xlink:href="#heart"></use>
                    </svg></a>
                  <figure>
                    <a href="/product-details.html" title="Product Title">
                      <img src="{{ bagisto_asset('website/images/png/product_img.png') }}" class="tab-image">
                    </a>
                  </figure>
                  <div class="card_constent">
                    <h6>Sunstar Fresh Melon Juice</h6>
                    <span class="qty"></span><span class="rating"><svg width="24" height="24" class="text-primary">
                        <use xlink:href="#star-solid"></use>
                      </svg> 4.5</span>
                    <span class="price">₹18.00</span>
                    <div class="d-flex align-items-center justify-content-between mt-2">

                      <button type="button" class="btn btn-success btn-sm add_to_cart explore-btn"> Add to Cart <svg
                          width="16" height="16" viewBox="0 0 24 24">
                          <use xlink:href="#cart"></use>

                        </svg>
                      </button>


                      <button type="button" class="btn btn-success btn-sm buy_now explore-btn"> Buy Now</button>

                    </div>
                  </div>
                </div>

                <div class="product-item swiper-slide">
                  <span class="badge bg-primary rounded-pill position-absolute m-3">-15%</span>
                  <a href="#" class="btn-wishlist"><svg width="24" height="24">
                      <use xlink:href="#heart"></use>
                    </svg></a>
                  <figure>
                    <a href="/product-details.html" title="Product Title">
                      <img src="{{ bagisto_asset('website/images/png/product_img.png') }}" class="tab-image">
                    </a>
                  </figure>
                  <div class="card_constent">

                    <h6>Sunstar Fresh Melon Juice</h6>
                    <span class="qty"></span><span class="rating"><svg width="24" height="24" class="text-primary">
                        <use xlink:href="#star-solid"></use>
                      </svg> 4.5</span>
                    <span class="price">₹18.00</span>
                    <div class="d-flex align-items-center justify-content-between mt-2">
                      <button type="button" class="btn btn-success btn-sm add_to_cart explore-btn"> Add to Cart <svg
                          width="16" height="16" viewBox="0 0 24 24">
                          <use xlink:href="#cart"></use>

                        </svg>
                      </button>


                      <button type="button" class="btn btn-success btn-sm buy_now explore-btn"> Buy Now</button>

                    </div>
                  </div>
                </div>

                <div class="product-item swiper-slide">
                  <span class="badge bg-primary rounded-pill position-absolute m-3">-15%</span>
                  <a href="#" class="btn-wishlist"><svg width="24" height="24">
                      <use xlink:href="#heart"></use>
                    </svg></a>
                  <figure>
                    <a href="/product-details.html" title="Product Title">
                      <img src="{{ bagisto_asset('website/images/png/product_img.png') }}" class="tab-image">
                    </a>
                  </figure>
                  <div class="card_constent">

                    <h6>Sunstar Fresh Melon Juice</h6>
                    <span class="qty"></span><span class="rating"><svg width="24" height="24" class="text-primary">
                        <use xlink:href="#star-solid"></use>
                      </svg> 4.5</span>
                    <span class="price">₹18.00</span>
                    <div class="d-flex align-items-center justify-content-between mt-2">
                      <button type="button" class="btn btn-success btn-sm add_to_cart explore-btn"> Add to Cart <svg
                          width="16" height="16" viewBox="0 0 24 24">
                          <use xlink:href="#cart"></use>

                        </svg>
                      </button>


                      <button type="button" class="btn btn-success btn-sm buy_now explore-btn"> Buy Now</button>

                    </div>
                  </div>
                </div>

                <div class="product-item swiper-slide">
                  <span class="badge bg-primary rounded-pill position-absolute m-3">-15%</span>

                  <a href="#" class="btn-wishlist"><svg width="24" height="24">
                      <use xlink:href="#heart"></use>
                    </svg></a>
                  <figure>
                    <a href="/product-details.html" title="Product Title">
                      <img src="{{ bagisto_asset('website/images/png/product_img.png') }}" class="tab-image">
                    </a>
                  </figure>
                  <div class="card_constent">

                    <h6>Sunstar Fresh Melon Juice</h6>
                    <span class="qty"></span><span class="rating"><svg width="24" height="24" class="text-primary">
                        <use xlink:href="#star-solid"></use>
                      </svg> 4.5</span>
                    <span class="price">₹18.00</span>
                    <div class="d-flex align-items-center justify-content-between mt-2">
                      <div class="input-group product-qty">
                        <span class="input-group-btn">
                          <button type="button" class="quantity-left-minus btn btn-danger btn-number explore-btn"
                            data-type="minus">
                            <svg width="16" height="16">
                              <use xlink:href="#minus"></use>
                            </svg>
                          </button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                        <span class="input-group-btn">
                          <button type="button" class="quantity-right-plus btn btn-success btn-number explore-btn"
                            data-type="plus">
                            <svg width="16" height="16">
                              <use xlink:href="#plus"></use>
                            </svg>
                          </button>
                        </span>
                      </div>
                      <button type="button" class="btn btn-success btn-sm buy_now explore-btn"> Buy Now</button>

                    </div>
                  </div>
                </div>

                <div class="product-item swiper-slide">
                  <span class="badge bg-primary rounded-pill position-absolute m-3">-15%</span>

                  <a href="#" class="btn-wishlist"><svg width="24" height="24">
                      <use xlink:href="#heart"></use>
                    </svg></a>
                  <figure>
                    <a href="/product-details.html" title="Product Title">
                      <img src="{{ bagisto_asset('website/images/png/product_img.png') }}" class="tab-image">
                    </a>
                  </figure>
                  <h6>Sunstar Fresh Melon Juice</h6>
                  <span class="qty"></span><span class="rating"><svg width="24" height="24" class="text-primary">
                      <use xlink:href="#star-solid"></use>
                    </svg> 4.5</span>
                  <span class="price">₹18.00</span>
                  <div class="d-flex align-items-center justify-content-between mt-2">
                    <button type="button" class="btn btn-success btn-sm add_to_cart explore-btn"> Add to Cart <svg
                        width="16" height="16" viewBox="0 0 24 24">
                        <use xlink:href="#cart"></use>

                      </svg>
                    </button>


                    <button type="button" class="btn btn-success btn-sm buy_now explore-btn"> Buy Now</button>

                  </div>
                </div>

                <div class="product-item swiper-slide">
                  <span class="badge bg-primary rounded-pill position-absolute m-3">-15%</span>

                  <a href="#" class="btn-wishlist"><svg width="24" height="24">
                      <use xlink:href="#heart"></use>
                    </svg></a>
                  <figure>
                    <a href="product-details.html" title="Product Title">
                      <img src="{{ bagisto_asset('website/images/png/product_img.png') }}" class="tab-image">
                    </a>
                  </figure>
                  <h6>Sunstar Fresh Melon Juice</h6>
                  <span class="qty"></span><span class="rating"><svg width="24" height="24" class="text-primary">
                      <use xlink:href="#star-solid"></use>
                    </svg> 4.5</span>
                  <span class="price">₹18.00</span>
                  <div class="d-flex align-items-center justify-content-between mt-2">
                    <div class="input-group product-qty">
                      <span class="input-group-btn">
                        <button type="button" class="quantity-left-minus btn btn-danger btn-number explore-btn"
                          data-type="minus">
                          <svg width="16" height="16">
                            <use xlink:href="#minus"></use>
                          </svg>
                        </button>
                      </span>
                      <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                      <span class="input-group-btn">
                        <button type="button" class="quantity-right-plus btn btn-success btn-number explore-btn"
                          data-type="plus">
                          <svg width="16" height="16">
                            <use xlink:href="#plus"></use>
                          </svg>
                        </button>
                      </span>
                    </div>
                    <button type="button" class="btn btn-success btn-sm  buy_now explore-btn"> Buy Now</button>

                  </div>
                </div>

                <div class="product-item swiper-slide">
                  <span class="badge bg-primary rounded-pill position-absolute m-3">-15%</span>

                  <a href="#" class="btn-wishlist"><svg width="24" height="24">
                      <use xlink:href="#heart"></use>
                    </svg></a>
                  <figure>
                    <a href="product-details.html" title="Product Title">
                      <img src="{{ bagisto_asset('website/images/png/product_img.png') }}" class="tab-image">
                    </a>
                  </figure>
                  <h6>Sunstar Fresh Melon Juice</h6>
                  <span class="qty"></span><span class="rating"><svg width="24" height="24" class="text-primary">
                      <use xlink:href="#star-solid"></use>
                    </svg> 4.5</span>
                  <span class="price">₹18.00</span>
                  <div class="d-flex align-items-center justify-content-between mt-2">
                    <div class="input-group product-qty">
                      <span class="input-group-btn">
                        <button type="button" class="quantity-left-minus btn btn-danger btn-number explore-btn"
                          data-type="minus">
                          <svg width="16" height="16">
                            <use xlink:href="#minus"></use>
                          </svg>
                        </button>
                      </span>
                      <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                      <span class="input-group-btn">
                        <button type="button" class="quantity-right-plus btn btn-success btn-number explore-btn"
                          data-type="plus">
                          <svg width="16" height="16">
                            <use xlink:href="#plus"></use>
                          </svg>
                        </button>
                      </span>
                    </div>
                    <button type="button" class="btn btn-success btn-sm  buy_now explore-btn "> Buy Now</button>

                  </div>
                </div>

              </div>
            </div>


          </div>
        </div>
      </div>
    </section> --}}

    @include('shop::products.carousal')

    <section>
      <div class="product_delivery_type">
        <div class="row">
          <div class="col-lg-4">
            <div class="d-flex justify-content-center align-items-center">

              <div class="icons">
                <img src="{{ bagisto_asset('website/images/png/tag.png') }}" />
              </div>
              <div class="delivery_content">
                <h5>Best Prices & Deals</h5>
                <p>Don’t miss our daily amazing deals and prices</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="d-flex justify-content-center align-items-center">

              <div class="icons">
                <img src="{{ bagisto_asset('website/images/png/refund.png') }}" />
              </div>
              <div class="delivery_content">
                <h5>Refundable </h5>
                <p>If your items have damage we agree to refund it</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="d-flex justify-content-center align-items-center">

              <div class="icons">
                <img src="{{ bagisto_asset('website/images/png/free_delivery.png') }}" />
              </div>
              <div class="delivery_content">
                <h5>Free delivery</h5>
                <p>Do purchase over $50 and get free delivery anywhere</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="expore_product">
        <div class="expore_product_img">
          <img src="{{ bagisto_asset('website/images/png/banner3.jpg') }}" />
        </div>
        <div class="expore_product_content">
          <h4>Lorem ipsum, dolor sit amet consectetur adipisicing elit. </h4>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat eveniet, illum hic eaque vitae ipsam nobis
            saepe molestias laudantium nesciunt.</p>
          <a href="{{ route('shop.api.categories.all') }}">
            <button type="button" class="btn btn-success explore-btn">
              Explore Products Now ➜
            </button>
          </a>
        </div>
      </div>
    </section>


</x-shop::layouts> @pushOnce('scripts')

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<script>
  var brand_swiper = new Swiper(".brand-carousel", {
    slidesPerView: 3,
    spaceBetween: 30,
    speed: 500,
    loop: true,
    navigation: {
      nextEl: ".brand-carousel-next",
      prevEl: ".brand-carousel-prev",
    },
    breakpoints: {
      0: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
      1500: {
        slidesPerView: 3,
      },
    },
  });
</script>
@endpushOnce