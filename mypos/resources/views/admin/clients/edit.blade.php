@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Client</h3>
                </div>
                <form action="{{ route('clients.update', $client->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" placeholder="Enter Client's Name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $client->name) }}">
                            @error('name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" placeholder="Enter Client's Phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $client->phone) }}">
                            @error('phone')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address"
                                class="form-control @error('address') is-invalid @enderror">{{ old('address', $client->address) }}</textarea>
                            @error('address')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fa fa-edit"></i>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
