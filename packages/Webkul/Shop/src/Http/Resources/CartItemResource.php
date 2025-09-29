<?php

namespace Webkul\Shop\Http\Resources;
use Illuminate\Support\Str;
use Webkul\Customer\Models\Wishlist;
use Webkul\Customer\Repositories\WishlistRepository;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */    

     public function toArray($request)
    {
        
        return [
            'id'                        => $this->id,
            'quantity'                  => $this->quantity,
            'type'                      => $this->type,
            'name'                      => $this->name,
            'short_description'         => Str::limit(strip_tags($this->product->short_description), 150),
            'special_price'             => $this->product->price,
            'formatted_special_price'   => core()->formatPrice($this->product->price),
            'price_incl_tax'            => $this->price_incl_tax,
            'price'                     => $this->price,
            'formatted_price_incl_tax'  => core()->formatPrice($this->price_incl_tax),
            'formatted_price'           => core()->formatPrice($this->price),
            'total_incl_tax'            => $this->total_incl_tax,
            'total'                     => $this->total,
            'formatted_total_incl_tax'  => core()->formatPrice($this->total_incl_tax),
            'formatted_total'           => core()->formatPrice($this->total),
            'discount_amount'           => $this->discount_amount,
            'formatted_discount_amount' => core()->formatPrice($this->discount_amount),
            'options'                   => array_values($this->resource->additional['attributes'] ?? []),
            'base_image'                => $this->getTypeInstance()->getBaseImage($this),
            'product_url_key'           => $this->product->url_key,
            'is_wishlisted'             => auth()->guard('customer')->check() ? $this->isInWishlist() : false,
            'product_id'                => $this->product->id, 
            'average_rating'            => $this->averageRating() ?? 0,
            'review_count'              => $this->reviewCount() ?? 0,
        ];
    }

    public function isInWishlist()
    {                     
        $wishlist = Wishlist::where('product_id', $this->product->id)
                            ->where('customer_id', auth()->guard('customer')->user()->id)
                            ->first();
                
        return $wishlist ? true : false;
    }

    protected function averageRating()
    {
        $approvedReviews = $this->product->reviews()->where('status', 'approved');

        return round($approvedReviews->avg('rating'), 1);
    }

    protected function reviewCount()
    {
        $approvedReviews = $this->product->reviews()->where('status', 'approved');
        return $approvedReviews->count();
    }

}
