@php
    $channel = core()->getCurrentChannel();    
@endphp

<!-- SEO Meta Content -->
@push ('meta')
    <meta name="title" content="Blogs" />

    <meta name="description" content="Blog Meta Description" />

    <meta name="keywords" content="Daawat Blogs, Daawat Receipe" />
@endPush

<x-shop::layouts>

    <section>
        <div class="blog_banner">
            <!-- Hero 6 - Bootstrap Brain Component -->
            <div class="row">
                <div class="col-12">
                    <div class=" bsb-hero-6 bsb-overlay" class="row justify-content-md-center align-items-center">
                        <div class="banner_img">
                            <img src="{{ bagisto_asset('website/images/blog-banner.jpg') }}" class="sm-pt-5"/>
                        </div>
                        <div class=" col-12 col-md-11 col-xl-10 px-5 p-5 banner_content">
                            <h3 class=" text-light  text-md-start text-shadow-head fw-bold mb-4">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit.</h3>
                            {{-- <p class="text-white mb-1">By John Doe | Nov 11, 2022</p> --}}

                            <p
                                class="lead text-center text-light text-md-start text-shadow-body mb-5 d-flex justify-content-sm-start justify-content-md-start">
                                <span class="col-12 col-sm-10 col-md-8 col-xxl-7">Where every squeak, every
                                    rattle, and every wobble finds its solution, ensuring your ride is
                                    always smooth and worry-free.</span>
                            </p>
                            {{-- <div class="d-grid gap-2 d-sm-flex justify-content-sm-center justify-content-md-start">
                                <button class="btn btn-outline-light explore-btn rounded-pill text-light" href="/blog-details.html">View
                                    more ➜</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        </div>
    </section>

    <div class="blog_list py-5">
        <!-- Blog 1 - Bootstrap Brain Component -->
        <section>
            
            <div class="container-fluid overflow-hidden">
                
                <div class="row gy-5">

                    <div class="col-12">

                        @foreach ($chunks as $chunk)
                            @php $isEven = $loop->iteration % 2 === 0; @endphp

                            <div class="row gy-3 gy-md-0 gx-xl-5">
                                @if ($isEven)
                                    {{-- Listing on left, Large card on right --}}
                                    <div class="col-xs-12 col-md-6">
                                        <div class="d-flex justify-content-between align-items-center py-4"></div>
                                        <div class="list-group relative_blog">
                                            @foreach ($chunk->skip(1) as $blog)
                                                <a href="{{ route('shop.blogs.view', ['url'=>$blog->url_string]) }}" class="list-group-item list-group-item-action">
                                                    <div>
                                                        <p class="text-muted mb-1">By {{ $blog->auther }} | {{ \Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}</p>
                                                        <h5>{{ $blog->title }}</h5>
                                                    </div>
                                                </a>                                            
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-6">
                                        <div class="py-4"></div>
                                        <div class="card position-relative bsb-hover-push">
                                            <div class="blog_img">
                                                <a href="{{ route('shop.blogs.view', ['url'=>$chunk->first()->url_string]) }}">
                                                    @if (\Carbon\Carbon::parse($chunk->first()->created_at)->gte(now()->subDays(7)))
                                                        <span class="badge rounded-pill text-bg-warning position-absolute top-10 start-10 m-3">
                                                            New Blog
                                                        </span>
                                                    @endif
                                                    <img class="img-fluid rounded w-100 h-100 object-fit-cover" loading="lazy"
                                                        src="{{ asset('storage/'.$chunk->first()->image) }}"
                                                        alt="Blog Image">
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <p class="text-muted mb-1">By {{ $chunk->first()->auther }} | {{ \Carbon\Carbon::parse($chunk->first()->created_at)->diffForHumans() }}</p>
                                                <h5 class="mb-3"><a class="link-dark text-decoration-none" href="{{ route('shop.blogs.view', ['url'=>$chunk->first()->url_string]) }}">{{ $chunk->first()->title }}</a></h5>
                                                <p class="mb-4">{{ Str::limit($chunk->first()->content, 200, '...') }}</p>
                                                <a class="btn btn-outline-light explore-btn rounded-pill" href="{{ route('shop.blogs.view', ['url'=>$chunk->first()->url_string]) }}">Read more ➜</a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Large card on left, Listing on right --}}
                                    <div class="col-xs-12 col-md-6">
                                        <div class="py-4"></div>
                                        <div class="card position-relative bsb-hover-push">
                                            <div class="blog_img">
                                                <a href="{{ route('shop.blogs.view', ['url'=>$chunk->first()->url_string]) }}">
                                                    @if (\Carbon\Carbon::parse($chunk->first()->created_at)->gte(now()->subDays(7)))
                                                        <span class="badge rounded-pill text-bg-warning position-absolute top-10 start-10 m-3">
                                                            New Blog
                                                        </span>
                                                    @endif
                                                    <img class="img-fluid rounded w-100 h-100 object-fit-cover" loading="lazy"
                                                        src="{{ asset('storage/'.$chunk->first()->image) }}"
                                                        alt="Blog Image">
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <p class="text-muted mb-1">By {{ $chunk->first()->auther }} | {{ \Carbon\Carbon::parse($chunk->first()->created_at)->diffForHumans() }}</p>
                                                <h5 class="mb-3"><a class="link-dark text-decoration-none" href="{{ route('shop.blogs.view', ['url'=>$chunk->first()->url_string]) }}">{{ $chunk->first()->title }}</a></h5>
                                                <p class="mb-4">{{ Str::limit($chunk->first()->content, 200, '...') }}</p>
                                                <a class="btn btn-outline-light explore-btn rounded-pill" href="{{ route('shop.blogs.view', ['url'=>$chunk->first()->url_string]) }}">Read more ➜</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-6">
                                        <div class="d-flex justify-content-between align-items-center py-4"></div>
                                        <div class="list-group relative_blog">
                                            @foreach ($chunk->skip(1) as $blog)
                                                <a href="{{ route('shop.blogs.view', ['url'=>$blog->url_string]) }}" class="list-group-item list-group-item-action">
                                                    <div>
                                                        <p class="text-muted mb-1">By {{ $blog->auther }} | {{ \Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}</p>
                                                        <h5>{{ $blog->title }}</h5>
                                                    </div>
                                                </a>                                            
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach


                        <div class="d-flex justify-content-center mt-5">
                            {{ $blogs->links('pagination::bootstrap-5') }}
                        </div>
                        
                    </div>


                </div>

            </div>

        </section>

    </div>

</x-shop::layouts>