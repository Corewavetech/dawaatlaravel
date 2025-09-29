{!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.before') !!}

<header>
    <div class="container-fluid">
      <div class="row py-3 border-bottom">

        <div class="col-sm-4 col-lg-3 text-center text-sm-start">
          <div class="main-logo">
            <a href="index.html">
              <img src="images/logo.png" alt="logo" class="img-fluid">
            </a>
          </div>
        </div>
        <div class="container-fluid col-sm-6 offset-sm-2 offset-md-0 col-lg-5  d-lg-block">
          
          <div class="d-lg-row ">
            <div class="d-flex  justify-content-center justify-content-sm-between align-items-center">
              <nav class="main-menu d-flex navbar navbar-expand-lg">

                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                  data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                  <span class="navbar-toggler-icon"></span>
                </button>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                  aria-labelledby="offcanvasNavbarLabel">

                  <div class="offcanvas-header justify-content-start">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                  </div>

                  <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 mb-0">
                      <li class="nav-item active hover-underline">
                        <a href="/index.html" class="nav-link ">Home</a>
                      </li>
                      <li class="nav-item hover-underline ">
                        <a href="/products.html" class="nav-link">Product</a>
                      </li>
                      <li class="nav-item hover-underline">
                        <a href="/Subscription.html" class="nav-link">Subscription</a>
                      </li>
                      <li class="nav-item hover-underline">
                        <a href="/Blogs.html" class="nav-link">Blog</a>
                      </li>
                      <li class="nav-item d-block d-lg-none">
                        <a href="/profile.html" class="nav-link">My Profile</a>
                      </li>
                      <!-- <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" role="button" id="pages" data-bs-toggle="dropdown"
                            aria-expanded="false">Pages</a>
                          <ul class="dropdown-menu" aria-labelledby="pages">
                            <li><a href="index.html" class="dropdown-item">About Us </a></li>
                            <li><a href="index.html" class="dropdown-item">Shop </a></li>
                            <li><a href="index.html" class="dropdown-item">Single Product </a></li>
                            <li><a href="index.html" class="dropdown-item">Cart </a></li>
                            <li><a href="index.html" class="dropdown-item">Checkout </a></li>
                            <li><a href="index.html" class="dropdown-item">Blog </a></li>
                            <li><a href="index.html" class="dropdown-item">Single Post </a></li>
                            <li><a href="index.html" class="dropdown-item">Styles </a></li>
                            <li><a href="index.html" class="dropdown-item">Contact </a></li>
                            <li><a href="index.html" class="dropdown-item">Thank You </a></li>
                            <li><a href="index.html" class="dropdown-item">My Account </a></li>
                            <li><a href="index.html" class="dropdown-item">404 Error </a></li>
                          </ul>
                        </li>
                        <li class="nav-item">
                          <a href="#brand" class="nav-link">Brand</a>
                        </li>
                        <li class="nav-item">
                          <a href="#sale" class="nav-link">Sale</a>
                        </li>
                        <li class="nav-item">
                          <a href="#blog" class="nav-link">Blog</a>
                        </li> -->
                    </ul>

                  </div>

                </div>
            </div>
          </div>
        </div>

        <div
          class="col-sm-8 col-lg-4 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">
          <div class="support-box text-end d-none d-xl-block">
            <span class="fs-6 bg-white px-3 py-2 rounded-5 "> <img src="/images/png/lp logo.png" class="lp_logo" />
              Loyalty Points</span>

          </div>


          <ul class="d-flex justify-content-end list-unstyled m-0">
            <li>
                <div class="position-relative d-flex align-items-center">
                    <a id="searchToggle" href="#" class="rounded-circle bg-light p-2 mx-1">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                        <use xlink:href="#search"></use>
                        </svg>
                    </a>

                    <input type="text" id="searchInput" class="form-control"
                        placeholder="Search..." style="width: 0; transition: width 0.4s ease; overflow: hidden;" />
                </div>
            </li>
            <li>
              <a href="/carts.html" class="rounded-circle bg-light p-2 mx-1 position-relative">
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <use xlink:href="#cart"></use>
                  <span class="cart_badge position-absolute top-20 start-60 translate-middle badge rounded-pill ">
                    5
                  </span>
                </svg>

              </a>
            </li>
            <li>
              <a href="/wishlist.html" class="rounded-circle bg-light p-2 mx-1  position-relative">
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <use xlink:href="#heart"></use>
                  <span class="cart_badge position-absolute top-20 start-60 translate-middle badge rounded-pill ">
                    2
                  </span>
                </svg>
              </a>
            </li>
            <!-- <li class="d-lg-none">
              <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <use xlink:href="#cart"></use>
                </svg>
              </a>
            </li> -->
            <!-- <li class="d-lg-none">
              <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <use xlink:href="#search"></use>
                </svg>
              </a>
            </li> -->
            <div class="cart text-end d-none d-lg-block dropdown mt-1">
              <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                <span class="fs-6 text-muted dropdown-toggle"><svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#user"></use>
                  </svg></span>
                <!-- <span class="cart-total fs-5 fw-bold">$1290.00</span> -->
              </button>
            </div>
          </ul>


        </div>

      </div>
    </div>


  </header>


@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-desktop-category-template"
    >
        <div
            class="flex items-center gap-5"
            v-if="isLoading"
        >
            <span
                class="shimmer h-6 w-20 rounded"
                role="presentation"
            ></span>

            <span
                class="shimmer h-6 w-20 rounded"
                role="presentation"
            ></span>

            <span
                class="shimmer h-6 w-20 rounded"
                role="presentation"
            ></span>
        </div>

        <div
            class="flex items-center"
            v-else
        >
            <div
                class="group relative flex h-[77px] items-center border-b-4 border-transparent hover:border-b-4 hover:border-navyBlue"
                v-for="category in categories"
            >
                <span>
                    <a
                        :href="category.url"
                        class="inline-block px-5 uppercase"
                    >
                        @{{ category.name }}
                    </a>
                </span>

                <div
                    class="pointer-events-none absolute top-[78px] z-[1] max-h-[580px] w-max max-w-[1260px] translate-y-1 overflow-auto overflow-x-auto border border-b-0 border-l-0 border-r-0 border-t border-[#F3F3F3] bg-white p-9 opacity-0 shadow-[0_6px_6px_1px_rgba(0,0,0,.3)] transition duration-300 ease-out group-hover:pointer-events-auto group-hover:translate-y-0 group-hover:opacity-100 group-hover:duration-200 group-hover:ease-in ltr:-left-9 rtl:-right-9"
                    v-if="category.children.length"
                >
                    <div class="aigns flex justify-between gap-x-[70px]">
                        <div
                            class="grid w-full min-w-max max-w-[150px] flex-auto grid-cols-[1fr] content-start gap-5"
                            v-for="pairCategoryChildren in pairCategoryChildren(category)"
                        >
                            <template v-for="secondLevelCategory in pairCategoryChildren">
                                <p class="font-medium text-navyBlue">
                                    <a :href="secondLevelCategory.url">
                                        @{{ secondLevelCategory.name }}
                                    </a>
                                </p>

                                <ul
                                    class="grid grid-cols-[1fr] gap-3"
                                    v-if="secondLevelCategory.children.length"
                                >
                                    <li
                                        class="text-sm font-medium text-zinc-500"
                                        v-for="thirdLevelCategory in secondLevelCategory.children"
                                    >
                                        <a :href="thirdLevelCategory.url">
                                            @{{ thirdLevelCategory.name }}
                                        </a>
                                    </li>
                                </ul>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-desktop-category', {
            template: '#v-desktop-category-template',

            data() {
                return  {
                    isLoading: true,

                    categories: [],
                }
            },

            mounted() {
                this.get();
            },

            methods: {
                get() {
                    this.$axios.get("{{ route('shop.api.categories.tree') }}")
                        .then(response => {
                            this.isLoading = false;

                            this.categories = response.data.data;
                        }).catch(error => {
                            console.log(error);
                        });
                },

                pairCategoryChildren(category) {
                    return category.children.reduce((result, value, index, array) => {
                        if (index % 2 === 0) {
                            result.push(array.slice(index, index + 2));
                        }

                        return result;
                    }, []);
                }
            },
        });
    </script>
@endPushOnce

{!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.after') !!}
