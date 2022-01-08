<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Client;
use App\Models\Category;
use Illuminate\Http\Request;

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
        dd($request->all());
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
