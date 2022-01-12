<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use App\Models\Category;
use App\Models\Dashboard;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreDashboardRequest;
use App\Http\Requests\UpdateDashboardRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::count();
        $products = Product::count();
        $clients = Client::count();
        $administrators = User::whereRoleIs('admin')->count();

        $salesGraph = Order::select(
            DB::raw("YEAR(created_at) as year"),
            DB::raw("MONTH(created_at) as month"),
            DB::raw("SUM(total_price) as profit"),
        )->groupBy('month', 'year')->orderBY('year', 'asc')->get();

        // return $salesGraph;
        return view('admin.index', compact('categories', 'products', 'clients', 'administrators', 'salesGraph'));
    }
}
