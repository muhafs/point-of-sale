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
    //! CREATE
    public function create(Client $client)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->get();
        return view('admin.clients.orders.create', compact('client', 'categories', 'orders'));
    }

    //! STORE
    public function store(Request $request, Client $client)
    {
        // return Product::find(1)->stock;
        // Validate Request Data
        $request->validate([
            'products' => 'required|array',
        ]);

        //? Check if the stock is enough
        foreach ($request->products as $index => $product) {
            if ($product['quantity'] > Product::find($index)->stock) {
                return redirect()->back()->with('fail', 'Oops, it looks the stock of some product is not enough for your order');
            }
        }

        //? Create the New Order
        $this->attachOrder($request, $client);

        return redirect('orders')->with('success', 'Order has been added successfully');
    }

    //! EDIT
    public function edit(Client $client, Order $order)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->get();
        return view('admin.clients.orders.edit', compact('client', 'categories', 'order', 'orders'));
    }

    //! UPDATE
    public function update(Request $request, Client $client, Order $order)
    {
        // Validate Request Data
        $request->validate([
            'products' => 'required|array',
        ]);

        // 5 > 125
        // dd(Product::find(3)->stock);
        //? Check if the stock is enough
        foreach ($request->products as $index => $product) {
            if ($product['quantity'] > Product::find($index)->stock) {
                return redirect()->back()->with('fail', 'Oops, it looks the stock of some product is not enough for your order');
            }
        }

        //? Delete the Exist Order
        $this->detachOrder($order);

        //? Create the New Order
        $this->attachOrder($request, $client);

        return redirect('orders')->with('success', 'Order has been updated successfully');
    }

    //! EXTRA METHODS TO MAKE CODE MORE CLEANER
    private function attachOrder(Request $request, Client $client)
    {
        // Create an Empty Order of Current Client
        $order = $client->orders()->create([]);

        // Create Pivot (product_order) with a given values
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
    }

    private function detachOrder(Order $order)
    {
        // Increase The product's stock Before Deleting the Order
        foreach ($order->products as $product) {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity,
            ]);
        }

        // Delete the order
        $order->delete();
    }
}
