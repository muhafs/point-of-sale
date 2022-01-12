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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDashboardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDashboardRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDashboardRequest  $request
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDashboardRequest $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
