@extends('layouts.admin')

@section('css')
// (Loading.io) Loader Animation
<style>
    .mr-2 {
        margin-right: 5px;
    }

    .loader {
        border: 5px solid #f3f3f3;
        border-radius: 50%;
        border-top: 5px solid #367FA9;
        width: 60px;
        height: 60px;
        -webkit-animation: spin 1s linear infinite;
        /* Safari */
        animation: spin 1s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

</style>
@endsection

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
                            <th style="width: 250px;">Action</th>
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
                                <button class="btn btn-primary btn-sm order-products"
                                    data-url="{{ route('orders.products', $order->id) }}" data-method="get">
                                    <i class="fa fa-eye"></i>
                                    Show
                                </button>
                                @if (auth()->user()->hasPermission('orders_update'))
                                <a href="{{ route('clients.orders.edit', ['client' => $order->client->id, 'order' => $order->id]) }}"
                                    class="btn btn-info btn-sm">
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
                <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                    <div class="loader"></div>
                    <p style="margin-top: 10px">Loading</p>
                </div>

                <div id="order-product-list">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{{-- PrintThis PlugIn CDN --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"
    integrity="sha512-d5Jr3NflEZmFDdFHZtxeJtBzk0eB+kkRXWFQqEc1EKmolXjHm2IKCA7kTvXBNjIYzjXfD5XzIjaaErpkZHCkBg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        //list all order products
        $('.order-products').on('click', function(e) {
            // Prevent thr Button Actions
            e.preventDefault();

            // Display the (CSs Loader) Animation
            $('#loading').css('display', 'flex');

            // Get All Data Values
            var url = $(this).data('url');
            var method = $(this).data('method');

            // Call Data Api With Ajax
            $.ajax({
                url,
                method,
                success: function(data) {
                    // Clear The previous Data
                    $('#order-product-list').empty();
                    // Append new Data
                    $('#order-product-list').append(data);
                    // After the data Called Remove the CSS Loader Animation
                    $('#loading').css('display', 'none');
                }
            })
        });

        // when (print button) is clicked, do this...
        $(document).on('click', '.print-btn', function() {
            // print the orders using printThis PlugIn
            $('#print-area').printThis();
        });
    })
</script>
@endsection
