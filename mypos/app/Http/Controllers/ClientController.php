<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //! INDEX
    public function index()
    {
        $clients = Client::all();
        return view('admin.clients.index', compact('clients'));
    }

    //! CREATE
    public function create()
    {
        return view('admin.clients.create');
    }

    //! STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:clients,phone|max:15',
            'address' => 'required',
        ]);

        Client::create($request->all());

        return redirect('clients')->with('success', 'Client has been added successfully');
    }

    //! EDIT
    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    //! UPDATE
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required',
            'phone' => "required|unique:clients,phone,{$client->id}|max:15",
            'address' => 'required',
        ]);

        $client->update($request->all());

        return redirect('clients')->with('success', 'Client has been updated successfully');
    }

    //! DESTROY
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect('clients')->with('success', 'Client has been deleted successfully');
    }
}
