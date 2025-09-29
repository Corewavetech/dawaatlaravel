<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $gurarded = [];

    protected $table = 'blogs';

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_id')->where('status', 1);
    }
    
}
