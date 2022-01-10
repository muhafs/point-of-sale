@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Orders</h3>
            </div>
            <div class="card-body">
                @if (session()->has('success'))
                <div class="alert alert-info" role="alert">
                    {{ session('success') }}
                </div>
                @endif

                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Client's Name</th>
                            <th>Price</th>
                            <th>Order's Date</th>
                            <th style="width: 200px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->count() > 0)
                        @foreach ($orders as $order)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $order->client->name }}</td>
                            <td class="align-middle">{{ number_format($order->total_price) }}</td>
                            <td class="align-middle">{{ $order->created_at->toFormattedDateString() }}</td>

                            <td class="align-middle">
                                @if (auth()->user()->hasPermission('orders_update'))
                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-edit"></i>
                                    Edit
                                </a>
                                @else
                                <button class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> Edit</button>
                                @endif

                                @if (auth()->user()->hasPermission('orders_delete'))
                                <form action="{{ route('orders.destroy', $order->id) }}" method="post"
                                    class="d-inline-block">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                        class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                        Delete
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i>
                                    Delete</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="text-center">
                            <td colspan="9">
                                No Orders Available.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Show Products</h3>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
</div>
@endsection
