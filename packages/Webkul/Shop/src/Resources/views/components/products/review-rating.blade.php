<v-product-review_rating
src="{{ $src }}"
title="{{ $title }}"
navigation-link="{{ $navigationLink ?? '' }}"
>

</v-product-review_rating>

@pushOnce('scripts')
    <script type="text/x-template" id="v-product-review_rating">

        <template v-if="isLoading">
            <div class="show_rating_list">
                <div class="container-fluid py-5">
                    <div class="text-white mb-2">
                        <h5>Reviews</h5>
                    </div>
            
                    <ul class="list-group">
                        @for ($i = 0; $i < 5; $i++)
                            <li class="list-group-item">
                                <div class="media align-items-lg-center flex-column flex-lg-row p-3">
                                    <div class="media-body order-2 order-lg-1 w-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="shimmer rounded-circle" style="width: 40px; height: 40px;"></div>
                                                <div class="shimmer rounded ms-3" style="width: 120px; height: 20px;"></div>
                                            </div>
            
                                            <div class="d-flex gap-1">
                                                @for ($j = 0; $j < 5; $j++)
                                                    <div class="shimmer rounded" style="width: 20px; height: 20px;"></div>
                                                @endfor
                                            </div>
                                        </div>
            
                                        <div class="mt-3">
                                            <div class="shimmer rounded mb-2" style="width: 100%; height: 16px;"></div>
                                            <div class="shimmer rounded mb-2" style="width: 80%; height: 16px;"></div>
                                            <div class="shimmer rounded" style="width: 60px; height: 14px;"></div>
                                        </div>
                                    </div>
            
                                    <div class="ml-lg-5 order-1 order-lg-2 mt-3 mt-lg-0">
                                        <div class="shimmer rounded" style="width: 200px; height: 120px;"></div>
                                    </div>
                                </div>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>            
        </template>
             
        <template v-else>
            <div class="show_rating_list">
                <div class="container-fluid py-5">
                    <div class="  text-white mb-2">
                        <h5>Reviews</h5>
                    </div>

                    <!-- List group-->
                    <ul class="list-group ">
                        <!-- list group item-->
                                                        
                        
                            <li class="list-group-item" v-for="review in reviews">
                                <!-- Custom content-->
                                <div
                                    class="media align-items-lg-center flex-column flex-lg-row p-3">
                                    <div class="media-body order-2 order-lg-1">
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <img :src="review.profile ?? 'https://mdbcdn.b-cdn.net/img/new/avatars/2.webp'"
                                                    class="rounded-circle "
                                                    style="width: 40px;" alt="Avatar" />
                                                <h5 class="mx-3 font-weight-bold mb-2">@{{ review.name }}
                                                </h5>
                                            </div>

                                            <div
                                                class="d-flex align-items-center justify-content-between mt-1">

                                                <ul class="list-inline small">
                                                                                                            
                                                    <li class="list-inline-item m-0" v-for="star in 5" :key="star"><i
                                                            :class="star <= review.rating ? 'fa fa-star text-primary' : 'fa fa-star text-gray' "></i>
                                                    </li>                                                                                                        
                                                                                                            
                                                </ul>
                                                
                                            </div>

                                        </div>
                                        <div class="review-wrapper">
                                            <p id="reviewText"
                                                class="text-container font-italic text-muted mb-0 small" 
                                                v-html="isExpanded(review.id) ? review.comment : getTruncatedComment(review)"
                                            >                                               
                                            </p>
                                            <a 
                                            v-if="isTruncatable(review)" 
                                            href="#"                                             
                                            class="toggle-btn" 
                                            @click.prevent="toggleExpanded(review.id)"
                                            > @{{ isExpanded(review.id) ? 'Show less' : 'Show more' }} </a>
                                        </div>

                                    </div>
                                    <!--<div class="show_review_img">
                                        
                                            <img src="review.image[0]?.url"
                                                alt="Review image" width="200"
                                                class="ml-lg-5 order-1 order-lg-2">
                                                                                                                
                                    </div> -->
                                </div> <!-- End -->
                            </li> 

                        

                    </ul> <!-- End -->

                </div>
                <div class="paginations">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" :class="{ 'disabled': currentPage === 1 }" href="#" 
                                    aria-label="Previous" 
                                    @click.prevent="changePage(currentPage - 1)">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item" v-for="page in pagNumbers" :key="page">
                                <a class="page-link" href="javascript:void(0);" @click.prevent="changePage(page)">@{{page}}</a>
                            </li>
                            
                            <li class="page-item" :class="{ 'disabled': currentPage === totalPages}">
                                <a class="page-link" href="#" aria-label="Next" @click.prevent="changePage(page+1)">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>                
        </template>
    </script>

    <script type="module">

        app.component('v-product-review_rating', {
            template: '#v-product-review_rating',

            props: [
                'src',
                'title',
                'navigationLink'
            ],

            data(){
                return {
                    expandedReviews: {},                    
                    commentLimit: 170,
                    isLoading: true,
                    
                    reviews: [],
                    
                    currentPage: 1,
                    totalPages: 1,
                    totalProducts: 0,
                    perPage: 8
                }
            },

            computed: {
                pageNumber(){
                    let pages = [];
                    for(i=1; i<= this.totalPages; i++){
                        pages.push(i);
                    }
                    return pages;
                }                

            },

            mounted(){
                this.getReviews();
            },

            methods: {
                getReviews() {
                    this.$axios.get(this.src, {
                        params:{
                            page: this.currentPage,
                            limit: this.perPage,  
                        }
                    })
                    .then(response => {
                        this.isLoading = false;
                        this.reviews = response.data.data;

                        this.totalPages = response.data.meta.last_page;

                    }).catch(error => {
                        console.log(error);
                        this.isLoading = false;
                    })
                },

                changePage(page){
                    if(page < 1 || page > this.totalPages) return;
                    this.currentPage = page;
                    this.getReviews();
                },

                isTruncatable(review){
                    return review.comment && review.comment.length > this.commentLimit;
                },

                getTruncatedComment(review){ 
                    if(review.comment.length > this.commentLimit){
                        return review.comment.slice(0, this.commentLimit)+'...';                    
                    }else{
                        return review.comment;
                    }                   
                },

                isExpanded(reviewId) {
                    return !!this.expandedReviews[reviewId];
                },

                toggleExpanded(reviewId){                    
                    this.expandedReviews[reviewId] = !this.expandedReviews[reviewId];
                }

            }

        });

    </script>

    <style scoped>
        .shimmer {
            position: relative;
            overflow: hidden;
            background: #e0e0e0;
            border-radius: 4px;
        }

        .shimmer::after {
            content: "";
            position: absolute;
            top: 0;
            left: -150px;
            height: 100%;
            width: 150px;
            background: linear-gradient(to right, transparent 0%, rgba(255, 255, 255, 0.5) 50%, transparent 100%);
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }
    </style>

@endPushOnce