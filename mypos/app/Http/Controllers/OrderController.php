<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //! INDEX
    public function index()
    {
        $orders = Order::all();
        return view('admin.orders.index', compact('orders'));
    }

    //! API
    public function products(Order $order)
    {
        $products = $order->products;
        return view('admin.orders.products', compact('products', 'order'));
    }

    //! DESTROY
    public function destroy(Order $order)
    {
        // Increase The product's stock Before Deleting the Order
        foreach ($order->products as $product) {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity,
            ]);
        }

        // Delete the order
        $order->delete();

        return redirect('orders')->with('success', 'Order deleted successfully');
    }
}
