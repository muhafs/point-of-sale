@extends('layouts.admin')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Administrators</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th style="width: 200px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->count() > 0)
                @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm">Edit</a>
                        <form action="#" method="post" class="d-inline-block">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr colspan="4" class="text-center">
                    No Users Available.
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
