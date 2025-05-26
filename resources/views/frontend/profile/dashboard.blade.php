@extends('frontend.profile.layouts.app')

@section('content')
<div class="col-md-9">
    @include('admin.message')
    <div class="card border-0 shadow">
        <div class="card-header text-white">Profile</div>
        <div class="card-body">
            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" value="{{ old('name', auth()->user()->name) }}"class="form-control" placeholder="Name" name="name" />
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" value="{{ old('email', auth()->user()->email) }}" class="form-control" placeholder="Email" name="email" />
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control">
                @if(auth()->user()->image)
                <div class="mb-3 mt-3">
                   <img src="{{ asset('storage/' . auth()->user()->image) }}" class="img-fluid rounded-circle" width="100" height="100" alt="Current Profile Image">
                </div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary mt-2">Update</button>
        </div>
    </div>
</div>
@endsection