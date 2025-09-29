@php
    $channel = core()->getCurrentChannel();    
@endphp

<!-- SEO Meta Content -->
@push ('meta')
    <meta name="title" content="{{ $blog->seo_title }}" />

    <meta name="description" content="{{ $blog->seo_description }}" />

    <meta name="keywords" content="{{ $blog->seo_keywords }}" />
@endPush

<x-shop::layouts>

    <div class="blog-singles gray-bg pb-5">
        <div class="container-fluid">
            <div class="row align-items-start">

                <div class="col-lg-8 m-15px-tb">
                    <article class="article">
                        <div class="article-img">
                            <img src="{{ asset('storage/'.$blog->image) }}" alt="{{ $blog->title }}" width="100%" height="530px">
                        </div>
                        <div class="article-title">
                            <h6><a href="javascript:void(0);">{{ $blog->type }}</a></h6>
                            <h2>{{$blog->title}}</h2>                            
                        </div>
                        <div class="article-content">
                            <p>{{ $blog->content }}</p>
                        </div>
                        <div class="nav tag-cloud">
                            
                            @foreach ($blog->tags as $tag)
                                <a class="btn btn-outline-light explore-btn rounded-pill" href="javascript:void(0);">#{{ $tag }}</a>
                            @endforeach
                           
                        </div>
                    </article>

                    <div class="contact-form article-comment">
                        <h4>Leave a Reply</h4>
                        <form id="contact-form" method="POST" action="{{ route('shop.blog.postComment') }}">
                            @csrf
                            <div class="row">
                                <input type="hidden" id="blog_id" name="blog_id" value="{{ $blog->id }}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input name="name" id="name" placeholder="Name *" class="form-control"
                                            type="text" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input name="email" id="email" placeholder="Email *" class="form-control"
                                            type="email" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea name="comments" id="comments" placeholder="Your message *" rows="4"
                                            class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-end py-2">
                                        <button type="submit" id="blog-comment-submit-button" class="btn btn-outline-light px-5 rounded-pill explore-btn">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="comments-section mt-[20px]" style="margin-top: 25px;">
                        <h3 class="text-xl font-semibold mb-4">Comments ({{ $blog->comments->count() }})</h3>

                        @if($blog->comments->isEmpty())
                            <p class="text-gray-600">No comments yet. Be the first to comment!</p>
                        @else
                            <ul class="space-y-6">
                                @foreach($blog->comments as $comment)
                                    <li class="border rounded-lg p-4 bg-white dark:bg-gray-800 shadow">
                                        <div class="flex justify-between items-center mb-2">
                                            <h4 class="font-semibold text-gray-800 dark:text-gray-100">{{ $comment->name }}</h4>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300">{{ $comment->comments }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                </div>
                      
                <div class="col-lg-4 m-15px-tb blog-aside"> 
                                            
                    <!-- widget Tags -->
                    <div class="widget widget-tags">
                        <div class="widget-title">
                            <h3>Latest Tags</h3>
                        </div>
                        <div class="widget-body">
                            <div class="nav tag-cloud">
                                
                                @foreach ($blog->tags as $tag)
                                    <a class="btn btn-outline-light rounded-pill explore-btn" href="javascript:void(0);">#{{$tag}}</a>    
                                @endforeach                                
                                                             
                            </div>
                        </div>
                    </div>
                    <!-- End widget Tags -->
                </div>

            </div>
        </div>
    </div>

    
    @push('scripts')
        <script>
            
            $('#blog-comment-submit-button').on('click', function(e){
                

                alert("fsdfnsdj");
            });

        </script>
    @endpush

</x-shop::layouts>