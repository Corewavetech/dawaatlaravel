<?php 

namespace Webkul\Admin\Http\Controllers\Marketing\Blogs;

use App\BlogComment;
use Webkul\Admin\DataGrids\Marketing\Blogs\BlogCommentDataGrid;
use Webkul\Shop\Http\Controllers\Controller;

class BlogCommentsController extends Controller
{

    protected $model;

    public function __construct(BlogComment $blogComment)
    {
        $this->model = $blogComment;
    }

    public function index()
    {
        if (request()->ajax()) {
            return datagrid(BlogCommentDataGrid::class)->process();
        }

        return view('admin::marketing.comments.index');
    }

    public function approve(int $id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->status = 1;
        $comment->save();

        return redirect()->back()->with('success', 'Comment approved successfully.');
    }

    public function reject(int $id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->status = 2;
        $comment->save();

        return redirect()->back()->with('success', 'Comment rejected successfully.');
    }

    public function destroy(int $id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');

    }

}