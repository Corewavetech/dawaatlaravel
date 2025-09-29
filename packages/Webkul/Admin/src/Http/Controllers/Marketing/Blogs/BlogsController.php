<?php

namespace Webkul\Admin\Http\Controllers\Marketing\Blogs;

use App\Blog;
use Illuminate\Support\Str;
use Webkul\Admin\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Webkul\Admin\DataGrids\Marketing\Blogs\BlogDataGrid;
use Webkul\Admin\Http\Requests\BlogRequest;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Webkul\Admin\DataGrids\Marketing\Blogs\BlogCommentDataGrid;

class BlogsController extends Controller
{

    protected $model;

    public function __construct(Blog $blog)
    {
        $this->model = $blog;
    }

    public function index()
    {
        if (request()->ajax()) {
            return datagrid(BlogCommentDataGrid::class)->process();
        }

        return view('admin::marketing.blogs.index');
    }

    public function create()
    {
        return view('admin::marketing.blogs.create');
    }

    public function store(BlogRequest $blogRequest)
    {
        $blog = new $this->model();        
        
        $blog->auther = $blogRequest->author;
        $blog->title = $blogRequest->title;
        $blog->url_string = $blogRequest->slug;
        $blog->content = $blogRequest->content;

        if($blogRequest->hasFile('image')){
            $file = $blogRequest->file('image');
            $manager = new ImageManager;
            $imageName = Str::slug($blogRequest->title).'-'.time().'.webp';
            $image = $manager->make($file)->encode('webp');
            $imagePath  = 'blogs/' . $imageName;

            Storage::put($imagePath, $image);
            $blog->image = $imagePath;            
        }

        $blog->seo_title = $blogRequest->seo_title; 
        $blog->seo_keywords = $blogRequest->seo_keywords; 
        $blog->seo_description = $blogRequest->seo_description;     
        $blog->type = $blogRequest->type;         

        if($blog->save()){

            if ($blogRequest->filled('tags')) {
                $tagsArray = array_map('trim', explode(',', $blogRequest->tags));                
                $blog->tags = json_encode($tagsArray);
                $blog->save();
            }

            return redirect()->route('admin.marketing.blogs.index')->with('success', 'Blog created successfully.');
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }

    public function edit(Blog $id)
    {
        $id->tags = json_decode($id->tags);
        return view('admin::marketing.blogs.edit', compact('id'));
    }

    public function update(BlogRequest $blogRequest, Blog $id)
    {
        $blog = $id;
        $blog->auther = $blogRequest->author;
        $blog->title = $blogRequest->title;
        $blog->url_string = $blogRequest->slug;
        $blog->content = $blogRequest->content;

        if($blogRequest->hasFile('image')){
            $file = $blogRequest->file('image');
            $manager = new ImageManager;
            $imageName = Str::slug($blogRequest->title).'-'.time().'.webp';
            $image = $manager->make($file)->encode('webp');
            $imagePath  = 'blogs/' . $imageName;

            Storage::put($imagePath, $image);
            $blog->image = $imagePath;            
        }

        $blog->seo_title = $blogRequest->seo_title; 
        $blog->seo_keywords = $blogRequest->seo_keywords; 
        $blog->seo_description = $blogRequest->seo_description;  
        $blog->type = $blogRequest->type;                

        if($blog->save()){

            if ($blogRequest->filled('tags')) {
                $tagsArray = array_map('trim', explode(',', $blogRequest->tags));                
                $blog->tags = json_encode($tagsArray);
                $blog->save();
            }

            return redirect()->route('admin.marketing.blogs.index')->with('success', 'Blog updated successfully.');
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function destroy(int $id)
    {
        $blog = $this->model->findOrFail($id);
        if($blog){
            $blog->delete();
            return response()->json([
                'message' => 'Blog deleted successfully'
            ]);
        }

        return response()->json([
            'message' => 'Something went wrong'
        ], 400);

    }

}