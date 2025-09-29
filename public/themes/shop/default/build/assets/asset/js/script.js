document.querySelectorAll(".accordion .btn").forEach((btn) => {
    btn.addEventListener("click", function () {
        const icon = this.querySelector(".rotate-icon");
        setTimeout(() => {
            const expanded = this.getAttribute("aria-expanded") === "true";
            icon.style.transform = expanded ? "rotate(180deg)" : "rotate(0deg)";
        }, 200);
    });
});

(function ($) {
    "use strict";

    var initPreloader = function () {
        $(document).ready(function ($) {
            var Body = $("body");
            Body.addClass("preloader-site");
        });
        $(window).load(function () {
            $(".preloader-wrapper").fadeOut();
            $("body").removeClass("preloader-site");
        });
    };

    // init Chocolat light box
    var initChocolat = function () {
        Chocolat(document.querySelectorAll(".image-link"), {
            imageSize: "contain",
            loop: true,
        });
    };

    var initSwiper = function () {
        var swiper = new Swiper(".main-swiper", {
            speed: 500,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });

        var category_swiper = new Swiper(".category-carousel", {
            slidesPerView: 6,
            spaceBetween: 30,
            speed: 500,
            navigation: {
                nextEl: ".category-carousel-next",
                prevEl: ".category-carousel-prev",
            },
            breakpoints: {
                0: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                991: {
                    slidesPerView: 4,
                },
                1500: {
                    slidesPerView: 6,
                },
            },
        });

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

        var products_swiper = new Swiper(".products-carousel", {
            slidesPerView: 5,
            spaceBetween: 30,
            speed: 500,
            navigation: {
                nextEl: ".products-carousel-next",
                prevEl: ".products-carousel-prev",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 3,
                },
                991: {
                    slidesPerView: 5,
                },
                1500: {
                    slidesPerView: 5,
                },
            },
        });
    };

    var initProductQty = function () {
        $(".product-qty").each(function () {
            var $el_product = $(this);
            var quantity = 0;

            $el_product.find(".quantity-right-plus").click(function (e) {
                e.preventDefault();
                var quantity = parseInt($el_product.find("#quantity").val());
                $el_product.find("#quantity").val(quantity + 1);
            });

            $el_product.find(".quantity-left-minus").click(function (e) {
                e.preventDefault();
                var quantity = parseInt($el_product.find("#quantity").val());
                if (quantity > 0) {
                    $el_product.find("#quantity").val(quantity - 1);
                }
            });
        });
    };

    // init jarallax parallax
    var initJarallax = function () {
        jarallax(document.querySelectorAll(".jarallax"));

        jarallax(document.querySelectorAll(".jarallax-keep-img"), {
            keepImg: true,
        });
    };

    document.addEventListener("DOMContentLoaded", function () {
        const viewMoreBtn = document.querySelector(".btn.btn-primary");
        const extraProducts = document.querySelector(".extra-products");

        viewMoreBtn.addEventListener("click", function () {
            extraProducts.classList.remove("d-none");
            viewMoreBtn.style.display = "none"; // Optional: hide button after click
        });
    });

    function changeImage(event, src) {
        document.getElementById("mainImage").src = src;
        document
            .querySelectorAll(".thumbnail")
            .forEach((thumb) => thumb.classList.remove("active"));
        event.target.classList.add("active");
    }

    document.addEventListener("DOMContentLoaded", function () {
        // const stars = document.querySelectorAll(".rating-star");
        const ratingInput = document.getElementById("rating");

        document.body.addEventListener("click", function (e) {
            if (e.target.classList.contains("rating-star")) {
                const rating = parseInt(e.target.getAttribute("data-rating"));
                ratingInput.value = rating;
                const stars =
                    e.target.parentElement.querySelectorAll(".rating-star");
                resetStars(stars);
                for (let i = 0; i < rating; i++) {
                    stars[i].classList.remove("bi-star");
                    stars[i].classList.add("bi-star-fill");
                }
            }
        });

        function resetStars() {
            stars.forEach((star) => {
                star.classList.remove("bi-star-fill");
                star.classList.add("bi-star");
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".review-wrapper").forEach((wrapper) => {
            const text = wrapper.querySelector(".text-container");
            const toggleBtn = wrapper.querySelector(".toggle-btn");

            const textContent = text.textContent.trim();

            if (textContent.length <= 500) {
                toggleBtn.classList.add("hidden");
            }

            toggleBtn.addEventListener("click", () => {
                text.classList.toggle("expanded");
                toggleBtn.textContent = text.classList.contains("expanded")
                    ? "Show less"
                    : "Show more";
            });
        });
    });

    // document ready
    $(document).ready(function () {
        initPreloader();
        initSwiper();
        initProductQty();
        initJarallax();
        initChocolat();
    }); // End of a document
})(jQuery);
