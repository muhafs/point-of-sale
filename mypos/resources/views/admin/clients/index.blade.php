@extends('layouts.admin')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Clients</h3>
    </div>
    <div class="card-body">
        @if (auth()->user()->hasPermission('clients_create'))
        <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">
            <i class="fa fa-plus"></i> Add Client
        </a>
        @else
        <a href="#" class="btn btn-primary mb-3 disabled">
            <i class="fa fa-plus"></i> Add Client
        </a>
        @endif

        @if (session()->has('success'))
        <div class="alert alert-info" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th style="width: 150px;">Order</th>
                    <th style="width: 200px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($clients->count() > 0)
                @foreach ($clients as $client)
                <tr>
                    <td class="align-middle">{{ $loop->iteration }}</td>
                    <td class="align-middle">{{ $client->name }}</td>
                    <td class="align-middle">{{ $client->phone }}</td>
                    <td class="align-middle">{{ $client->address }}</td>
                    <td class="align-middle">
                        @if (auth()->user()->hasPermission('orders_create'))
                        <a href="{{ route('clients.orders.create', $client->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-cart-plus"></i>
                            Add Orders
                        </a>
                        @else
                        <a href="#" class="btn btn-primary btn-sm disabled">
                            <i class="fas fa-cart-plus"></i>
                            Add Orders
                        </a>
                        @endif
                    </td>
                    <td class="align-middle">
                        @if (auth()->user()->hasPermission('clients_update'))
                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-edit"></i>
                            Edit
                        </a>
                        @else
                        <button class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> Edit</button>
                        @endif

                        @if (auth()->user()->hasPermission('clients_delete'))
                        <form action="{{ route('clients.destroy', $client->id) }}" method="post" class="d-inline-block">
                            @csrf
                            @method('delete')
                            <button type="submit" onclick="return confirm('Are you sure?')"
                                class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                                Delete
                            </button>
                        </form>
                        @else
                        <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i>
                            Delete</button>
                        @endif
                    </td>
                </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="5">
                        No Clients Available.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
