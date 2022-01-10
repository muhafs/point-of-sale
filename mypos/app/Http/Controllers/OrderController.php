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
}
