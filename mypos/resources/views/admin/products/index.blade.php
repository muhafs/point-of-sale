@extends('layouts.admin')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Products</h3>
    </div>
    <div class="card-body">
        @if (auth()->user()->hasPermission('products_create'))
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
            <i class="fa fa-plus"></i> Add Product
        </a>
        @else
        <a href="#" class="btn btn-primary mb-3 disabled">
            <i class="fa fa-plus"></i> Add Product
        </a>
        @endif

        @if (session()->has('success'))
        <div class="alert alert-info" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Purchase Price</th>
                    <th>Sale Price</th>
                    <th>Profit</th>
                    <th>Stock</th>
                    <th style="width: 200px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($products->count() > 0)
                @foreach ($products as $product)
                <tr>
                    <td class="align-middle">{{ $loop->iteration }}</td>
                    <td class="align-middle">{{ $product->category->name }}</td>
                    <td class="align-middle">{{ $product->name }}</td>
                    <td class="align-middle">{{ $product->description }}</td>
                    <td class="align-middle">
                        <img src="{{ $product->image_path }}" alt="{{ $product->name }}" class="img-thumbnail"
                            style="width: 100px;">
                    </td>
                    <td class="align-middle">{{ $product->purchase_price }}</td>
                    <td class="align-middle">{{ $product->sale_price }}</td>
                    <td class="align-middle">{{ $product->profit_percent }}%</td>
                    <td class="align-middle">{{ $product->stock }}</td>
                    <td class="align-middle">
                        @if (auth()->user()->hasPermission('products_update'))
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-info btn-sm">
                            <i class="fa fa-edit"></i>
                            Edit
                        </a>
                        @else
                        <button class="btn btn-outline-info btn-sm disabled"><i class="fa fa-edit"></i> Edit</button>
                        @endif

                        @if (auth()->user()->hasPermission('products_delete'))
                        <form action="{{ route('products.destroy', $product->id) }}" method="post"
                            class="d-inline-block">
                            @csrf
                            @method('delete')
                            <button type="submit" onclick="return confirm('Are you sure?')"
                                class="btn btn-outline-danger btn-sm">
                                <i class="fa fa-trash"></i>
                                Delete
                            </button>
                        </form>
                        @else
                        <button class="btn btn-outline-danger btn-sm disabled"><i class="fa fa-trash"></i>
                            Delete</button>
                        @endif
                    </td>
                </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="9">
                        No Products Available.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
