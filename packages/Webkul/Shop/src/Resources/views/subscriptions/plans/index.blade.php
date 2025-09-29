<x-shop::layouts>
    <x-slot:title>Subscribe</x-slot>

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

    <section class="py-5 overflow-hidden" >
        <div class="container-fluid">    
            <h3 class="mb-5"> Subscribe product for regular delivery </h3>
            <div class="all_product_list" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(clamp(220px, 12vw, 12vw), 1fr)); gap: 2rem;">
                @foreach ($plans as $plan)

                    @php
                        $product = $plan->product;
                        $originalPrice = $product->price ?? $plan->price;
                        $discount = max(0, $originalPrice - $plan->price);
                        $discountPercent = $originalPrice > 0 ? round(($discount / $originalPrice) * 100, 2) : 0;
                    @endphp
                    
                    <div class="product-item">
                        <span class="badge bg-primary rounded-pill position-absolute m-3" ></span>
                        
                        <figure>                            
                            <img
                                src="{{ $product->base_image_url ?? '' }}" 
                                alt="{{ $product->name }}"
                                class="tab-image"                                    
                            />                            
                        </figure>

                        <h6> {{ $product->name ?? ''}} </h6>                                                                      

                        <form action="{{ route('shop.subscription.checkout') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}" />

                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="duration">Duration</label> 
                                </div>
                                <div class="col-lg-8">
                                    <select name="duration" id="duration" class="form-control">                                        
                                        <option value="1">1 Month</option>
                                        <option value="2">2 Months</option>
                                        <option value="3">3 Months</option>
                                        <option value="4">4 Months</option>
                                        <option value="5">5 Months</option>
                                        <option value="6">6 Months</option>
                                        <option value="7">7 Months</option>
                                        <option value="8">8 Months</option>
                                        <option value="9">9 Months</option>
                                        <option value="10">10 Months</option>
                                        <option value="11">11 Months</option>
                                        <option value="12">12 Months</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="duration">Frequency</label> 
                                </div>
                                <div class="col-lg-8">
                                    <select name="frequency" id="frequency" class="form-control">                                        
                                        <option value="1">Monthly</option>
                                        <option value="2">15 Days</option>
                                        <option value="3">Weekly</option>
                                        <option value="4">Daily</option>                                        
                                    </select>
                                    <input type="number" id="frequency" name="frequency" class="form-control" value="2" />                                    
                                </div>
                            </div>

                            <p><strong>Price:</strong>
                                <div class="price d-flex justify-between">
                                    <span> ₹ {{ number_format($plan->price*($plan->duration * $plan->frequency), 2) }} </span>                                    
                                    <small                                    
                                        class="text-muted text-decoration-line-through small ms-2"
                                    >                                        
                                        ₹ {{ number_format($originalPrice, 2) }}
                                    </small>
                                </div> 
                            </p> 

                            <button type="submit" class="btn btn-primary text-center">
                                Subscribe
                            </button>
                        </form> 
                        
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-end">
                {{ $plans->links('pagination::bootstrap-4') }}
            </div>
               
        </div>
    </section>  
    
</x-shop::layouts>
