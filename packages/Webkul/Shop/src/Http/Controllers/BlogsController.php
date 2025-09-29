<?php 

namespace Webkul\Shop\Http\Controllers;

use App\Blog;
use App\BlogComment;
use Illuminate\Foundation\Http\FormRequest;

class BlogsController extends Controller
{

    public function index()
    {
        $blogs = Blog::select('id', 'image', 'auther', 'title', 'content', 'url_string', 'created_at')->paginate(15);
        $chunks = $blogs->chunk(7);  
                
        return view('shop::blogs.index', compact('chunks', 'blogs'));
    }

    public function view_blog(string $url)
    {      

        $blog = Blog::with('comments')->where('url_string', $url)->first();
        if($blog){         
            $blog->tags = json_decode($blog->tags) ?? [];
            
            return view('shop::blogs.view', compact('blog'));            
        }

        return redirect()->back()->with('error', 'Blog not found');

    }

    public function post_comment(FormRequest $request)
    {
        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comments' => 'required|string|max:255',
        ]);

        $isInserted = BlogComment::create($request->all());

        if($isInserted)
        {
            return redirect()->back()->with('success', 'Your comment is under review');
        }

        return redirect()->back()->with('error', 'failed to save your comment');


    }

}