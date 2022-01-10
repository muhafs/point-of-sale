<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use App\Models\Category;

class OrderController extends Controller
{
    //! INDEX
    public function index()
    {
        //
    }

    //! CREATE
    public function create(Client $client)
    {
        $categories = Category::with('products')->get();
        return view('admin.clients.orders.create', compact('client', 'categories'));
    }

    //! STORE
    public function store(Request $request, Client $client)
    {
        // dd($request->all());
        // Validate Request Data
        $request->validate([
            'products' => 'required|array',
        ]);

        // Create an Order
        $order = $client->orders()->create([]);

        $order->products()->attach($request->products);

        // Set Total Price
        $total_price = 0;
        // Set
        foreach ($request->products as $id => $quantity) {
            // Get the Current Product
            $product = Product::findOrFail($id);

            // Insert Current Product's Total Price into (total_price) Variable
            $total_price += $product->sale_price * $quantity['quantity'];

            // Decrement the Stock of Current Product
            $product->update([
                'stock' => $product->stock - $quantity['quantity']
            ]);
        }

        // Set Total Price of the Order
        $order->update([
            'total_price' => $total_price
        ]);

        return redirect('orders')->with('success', 'Order has been added successfully');
    }

    //! EDIT
    public function edit(Order $order, Client $client)
    {
        //
    }

    //! UPDATE
    public function update(Request $request, Order $order, Client $client)
    {
        //
    }

    //! DESTROY
    public function destroy(Order $order, Client $client)
    {
        //
    }
}
