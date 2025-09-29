@extends('admin::layouts.content')

@section('page_title')
    Add Subscription Plan
@stop

@section('content')
    <div class="content">
        <h1>Add Subscription Plan</h1>

        <form method="POST" action="{{ route('admin.subscription.plans.store') }}">
            @csrf

            <div class="control-group">
                <label>Product</label>
                <select name="product_id" class="control">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="control-group">
                <label>Duration (Months)</label>
                <input type="number" name="duration" class="control" min="1" required>
            </div>

            <div class="control-group">
                <label>Price</label>
                <input type="number" name="price" step="0.01" class="control" required>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@stop
