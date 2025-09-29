<?php

namespace Webkul\Admin\DataGrids\SubscriptionPlan;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class SubscriptionPlan extends DataGrid
{

    public function prepareQueryBuilder()
    {
        $currentLocale = app()->getLocale();

        $imageSubquery = DB::table('product_images')
                            ->select('product_id', DB::raw('MIN(path) as path'))
                            ->groupBy('product_id');

        $queryBuilder = DB::table('subscription_plans')                        
                        ->leftJoin('product_flat', 'subscription_plans.product_id', '=', 'product_flat.product_id')
                        ->leftJoinSub($imageSubquery, 'product_images', function ($join) {
                            $join->on('subscription_plans.product_id', '=', 'product_images.product_id');
                        })                       
                        ->select(
                            'subscription_plans.id',
                            'subscription_plans.product_id as product_id',
                            'product_flat.name as product_name',
                            'product_flat.sku',
                            'product_images.path as image',
                            'subscription_plans.duration',
                            DB::raw("
                            CASE subscription_plans.duration 
                                WHEN 1 THEN '1 Month'
                                WHEN 3 THEN '3 Months'
                                WHEN 6 THEN '6 Months'
                                WHEN 12 THEN '12 Months'
                                ELSE 'UNKNOWN'
                                END as duration_label
                            "),
                            'subscription_plans.frequency',                            
                            'subscription_plans.price',
                            DB::raw("
                            CASE subscription_plans.frequency 
                                WHEN 1 THEN 'Monthly (1x)'
                                WHEN 2 THEN 'Weekly (4x)'
                                WHEN 3 THEN 'Daily (30x)'
                                ELSE 'UNKNOWN'
                                END as frequency_label
                            ")
                        );                        
            
        return $queryBuilder;

    }

    public function prepareColumns()
    {

        $this->addColumn([
            'index' => 'id',
            'label' => 'ID',
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'width' => '50px',
        ]);

        $this->addColumn([
            'index' => 'product_name',
            'label' => 'Product',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,            
        ]);

        $this->addColumn([
            'index' => 'duration_label',
            'label' => 'Duration (Months)',
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
        ]);

        $this->addColumn(column: [
            'index' => 'frequency_label',
            'label' => 'Frequency (In a Month)',
            'type' => 'string',
            'searchable' => false,
            'sortable' => true            
        ]);

        $this->addColumn([
            'index' => 'price',
            'label' => 'Price (₹)',
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
        ]);

    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('admin::app.datagrid.edit'),
            'method' => 'GET',
            'url'   => function ($row){
                return route('admin.subscription.plans.edit', ['plan'=>$row->id]);
            },            
            'icon'   => 'icon-edit',
        ]);

        $this->addAction([
            'title'  => trans('admin::app.datagrid.delete'),
            'method' => 'DELETE',
            'url'  => function($row){
                return route('admin.subscription.plans.destroy', ['plan' => $row->id]);
            },            
            'icon'   => 'icon-delete',
        ]);
    }

    public function prepareMassActions()
    {
        $this->addMassAction([             
            'title' => 'Delete',            
            'url'   => route('admin.subscription.plans.mass.delete'),
            'method' => 'POST',
            
        ]);
    }

}


