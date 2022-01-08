@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Categories</h3>
                </div>
                <div class="card-body">
                    <div id="accordion">
                        @foreach ($categories as $category)
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse"
                                        href="#{{ str_replace(' ', '-', $category->name) }}">
                                        {{ $category->name }}
                                    </a>
                                </h4>
                            </div>

                            <div id="{{ str_replace(' ', '-', $category->name) }}" class="collapse"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">Name</th>
                                                <th class="align-middle">Stock</th>
                                                <th class="align-middle">Price</th>
                                                <th class="align-middle">Add</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($category->products->count() > 0)
                                            @foreach ($category->products as $product)
                                            <tr>
                                                <td class="align-middle">{{ $product->name }}</td>
                                                <td class="align-middle">{{ $product->stock }}</td>
                                                <td class="align-middle">{{ number_format($product->sale_price) }}</td>
                                                <td class="align-middle">
                                                    <a href="" id="product-{{ $product->id }}"
                                                        data-name="{{ $product->name }}" data-id="{{ $product->id }}"
                                                        data-price="{{ $product->sale_price }}"
                                                        class="btn btn-info btn-sm add-product-btn">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td class="align-middle" colspan="4">This Category has No
                                                    Products.</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <form action="{{ route('clients.orders.store', $client->id) }}" method="post">
                    @csrf
                    @method('post')
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Orders</h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>

                            <tbody class="order-list">
                            </tbody>
                        </table>

                    </div>

                    <div class="card-footer">
                        <h4 class="text-center">Total: <span class="total-price">0</span></h4>
                        <button class="btn btn-primary w-100 disabled" id="add-order-form-btn">
                            <i class="fas fa-plus"></i>
                            Add
                        </button>
                    </div>
                </form>

                @if (false)
                <div class="card-header bg-primary">
                    <h3 class="card-title">
                        Previous Order
                        <small>{{ $orders->total() }}</small>
                    </h3>
                </div>

                <div class="card-body">
                    <div id="accordion">
                        @foreach ($orders as $order)
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse"
                                        href="#{{ $order->created_at->format('d-m-Y-s') }}">
                                        {{ $order->created_at->toFormattedDateString() }}
                                    </a>
                                </h4>
                            </div>

                            <div id="{{ $order->created_at->format('d-m-Y-s') }}" class="collapse"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <ul class="list-group">
                                        @foreach ($order->products as $product)
                                        <li class="list-group-item">{{ $product->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {

        // when (add product) button clicked do this
        $('.add-product-btn').on('click', function (e) {
            // prevent add product button from reloading the page
            e.preventDefault();

            // get all values of products
            const name = $(this).data('name');
            const id = $(this).data('id');
            const price = $(this).data('price');

            // remove color from add button then make it disable
            $(this).removeClass('btn-info').addClass('btn-default disabled');

            // prepare the products data
            const html =
            `<tr>
                <td class="align-middle">${name}</td>
                <td class="align-middle">
                    <input type="number" name="products[${id}][quantity]" data-price="${price}"
                        class="form-control form-control-sm product-quantity" min="1" value="1">
                </td>
                <td class="product-price align-middle">${price}</td>
                <td class="align-middle">
                    <button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}">
                        <span class="fa fa-trash"></span>
                    </button>
                </td>
            </tr>`;

            // insert products data into order modal with given values
            $('.order-list').append(html);

            //calculate total of price
            calculateTotal();
        });

        // make sure to disable the add products button
        $('body').on('click', '.disabled', function(e) {
            // prevent (add product) button from any action when it is disabled
            e.preventDefault();
        });

        // when (remove product) button clicked, do this...
        $('body').on('click', '.remove-product-btn', function(e) {
            // prevent (remove product) button from any action
            e.preventDefault();

            // get product id
            const id = $(this).data('id');

            // remove current table row
            $(this).closest('tr').remove();

            // remove (disabled) class from (add product) button and active it again
            $('#product-' + id).removeClass('btn-default disabled').addClass('btn-info');

            // calculate total price
            calculateTotal();
        });

        // when (product quantity) field changed, do this...
        $('body').on('keyup change', '.product-quantity', function() {
            // get the current product (quantity)
            const quantity = Number($(this).val());
            // get the product (price)
            const unitPrice = parseInt($(this).data('price'))

            // get (product ptice), then calculate it with the (product quantity)
            $(this).closest('tr').find('.product-price').html(quantity * unitPrice);

            // calculate the total price
            calculateTotal();
        });

        //list all order products
        $('.order-products').on('click', function(e) {
            e.preventDefault();

            $('#loading').css('display', 'flex');

            var url = $(this).data('url');
            var method = $(this).data('method');
            $.ajax({
                url: url,
                method: method,
                success: function(data) {
                    $('#loading').css('display', 'none');
                    $('#order-product-list').empty();
                    $('#order-product-list').append(data);
                }
            })
        });

        // when (print button) is clicked, do thi...
        $(document).on('click', '.print-btn', function() {
            // print the orders
            $('#print-area').printThis();
        });

    });

    // calculate the total price
    function calculateTotal() {
        // prepare a price box
        let price = 0;

        // for each product you get, do this ...
        $('.order-list .product-price').each(function(index) {
            // insert product price into (price box)
            price += parseInt($(this).html().replace(/,/g, ''));
        });

        // insert the total price into the element
        $('.total-price').html(price);

        // when (orders modal) is filled, then do this...
        if (price > 0) {
            // remove the (disabled) class to activate the (checkout) button
            $('#add-order-form-btn').removeClass('disabled')
        } else {
            // add the (disabled) class to disable the (checkout) button
            $('#add-order-form-btn').addClass('disabled')
        }
    }
</script>
@endsection
