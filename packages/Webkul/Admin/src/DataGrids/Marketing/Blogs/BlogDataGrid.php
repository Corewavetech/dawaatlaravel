<?php 

namespace Webkul\Admin\DataGrids\Marketing\Blogs;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid; 

Class BlogDataGrid extends DataGrid
{

    public function prepareQueryBuilder()
    {

        $queryBuilder = DB::table('blogs')->orderBy('id', 'DESC');
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
            'index'      => 'image',
            'label'      => trans('Image'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
            'closure'    => function ($row) {
                if($row->image){
                    return '<img src="' . asset('storage/' . $row->image) . '" width="50" height="50" style="object-fit: cover;" />';
                }
            },
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('Title'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'auther',
            'label'      => trans('Author'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

    }

    public function prepareActions()
    {        
        $this->addAction([
            'icon'   => 'icon-edit',
            'title'  => trans('Edit Blog'),
            'method' => 'GET',
            'url'    => function ($row) {
                return route('admin.marketing.blogs.edit', $row->id);
            },
        ]);        
        
        $this->addAction([
            'icon'   => 'icon-delete',
            'title'  => trans('Delete Blog'),
            'method' => 'DELETE',
            'url'    => function ($row) {
                return route('admin.marketing.blogs.delete', $row->id);
            },
        ]);        
    }

}