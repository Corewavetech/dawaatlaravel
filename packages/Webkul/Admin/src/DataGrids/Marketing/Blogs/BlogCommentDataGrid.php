<?php 

namespace Webkul\Admin\DataGrids\Marketing\Blogs;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid; 

Class BlogCommentDataGrid extends DataGrid
{
   
    public function prepareQueryBuilder()
    {

        $queryBuilder = DB::table('blog_comments')->orderBy('id', 'DESC');
        return $queryBuilder;

    }

    public function prepareColumns()
    {
        
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('ID'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('Name'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'email',
            'label'      => trans('Email'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'comments',
            'label'      => trans('Comment'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('Status'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
            'closure'    => function ($row) {
                switch ($row->status) {
                    case 0:
                        return '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>';
                    case 1:
                        return '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">Approved</span>';
                    case 2:
                        return '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">Rejected</span>';
                    default:
                        return '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">Unknown</span>';
                }
            },
            'wrapper' => true,
        ]);


    }

    public function prepareActions()
    {        
        $this->addAction([
            'icon'   => 'fa fa-check',
            'title'  => trans('Approve Comment'),
            'method' => 'GET',
            'url'    => function ($row) {
                return route('admin.marketing.blog-comments.approve', ['id' => $row->id]);                    
            },
            'class' => function ($row) {
                return $row->status == 1
                    ? 'text-green-600 font-semibold' 
                    : '';
            },
        ]);
        
        $this->addAction([
            'icon'   => 'fa fa-times',
            'title'  => trans('Reject Comment'),
            'method' => 'GET',
            'url'    => function ($row) {
                return route('admin.marketing.blog-comments.reject', ['id' => $row->id]);                    
            },
            'class' => function ($row) {
                return $row->status == 2
                    ? 'text-red-600 font-semibold' 
                    : '';
            },
        ]);
        
        $this->addAction([
            'icon'   => 'icon-delete',
            'title'  => trans('Delete Blog'),
            'method' => 'DELETE',
            'url'    => function ($row) {
                return route('admin.marketing.blog-comments.delete', $row->id);
            },
        ]);        
    }


}