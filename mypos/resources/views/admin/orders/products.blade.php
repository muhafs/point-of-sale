<div id="print-area">
    <table class="table table-hover table-bordered text-center">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ number_format($product->pivot->quantity * $product->sale_price) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h3>Total Price : <span>{{ number_format($order->total_price) }}</span></h3>
</div>

<button class="btn btn-block btn-primary print-btn"><i class="fa fa-print"></i> Print</button>
