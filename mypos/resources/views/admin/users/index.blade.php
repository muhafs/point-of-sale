@extends('layouts.admin')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Administrators</h3>
    </div>
    <div class="card-body">
        @if (auth()->user()->hasPermission('users_create'))
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
            <i class="fa fa-plus"></i> Add Users
        </a>
        @else
        <a href="#" class="btn btn-primary mb-3 disabled">
            <i class="fa fa-plus"></i> Add Users
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
                    <th>Email</th>
                    <th style="width: 100px;">Image</th>
                    <th style="width: 200px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->count() > 0)
                @foreach ($users as $user)
                <tr>
                    <td class="align-middle">{{ $loop->iteration }}</td>
                    <td class="align-middle">{{ $user->name }}</td>
                    <td class="align-middle">{{ $user->email }}</td>
                    <td class="align-middle"><img src="{{ $user->image_path }}" alt="{{ $user->name }}"
                            style="width: 100px" class="img-thumbnail"></td>
                    <td class="align-middle">
                        @if (auth()->user()->hasPermission('users_update'))
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-edit"></i>
                            Edit
                        </a>
                        @else
                        <button class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> Edit</button>
                        @endif

                        @if (auth()->user()->hasPermission('users_delete'))
                        <form action="{{ route('users.destroy', $user->id) }}" method="post" class="d-inline-block">
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
                    <td colspan="4">
                        No Users Available.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
