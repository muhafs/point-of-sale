@extends('layouts.admin')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Categoriess</h3>
    </div>
    <div class="card-body">
        @if (auth()->user()->hasPermission('categories_create'))
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">
            <i class="fa fa-plus"></i> Add Category
        </a>
        @else
        <a href="#" class="btn btn-primary mb-3 disabled">
            <i class="fa fa-plus"></i> Add Category
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
                    <th style="width: 200px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($categories->count() > 0)
                @foreach ($categories as $category)
                <tr>
                    <td class="align-middle">{{ $loop->iteration }}</td>
                    <td class="align-middle">{{ $category->name }}</td>
                    <td class="align-middle">
                        @if (auth()->user()->hasPermission('categories_update'))
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-edit"></i>
                            Edit
                        </a>
                        @else
                        <button class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> Edit</button>
                        @endif

                        @if (auth()->user()->hasPermission('categories_delete'))
                        <form action="{{ route('categories.destroy', $category->id) }}" method="post"
                            class="d-inline-block">
                            @csrf
                            @method('delete')
                            <button type="submit" onclick="return confirm('Are you sure?')"
                                class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                                Delete
                            </button>
                        </form>
                        @else
                        <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> Delete</button>
                        @endif
                    </td>
                </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="4">
                        No Categoriess Available.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
