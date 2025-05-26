@extends('admin.profile.layouts.app')

@section('content')

<div class="col-md-9">
    @include('admin.message')
    <div class="card border-0 shadow">
        <div class="card-header  text-white">
            Change Password
        </div>
        <div class="card-body">
            <!-- Password Change Form -->
            <form action="{{ route('admin.password.change') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="old_password" class="form-label">Old Password</label>
                    <input type="password" class="form-control" placeholder="Old Password" name="current_password" id="old_password" />
                    @error('current_password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" class="form-control" placeholder="New Password" name="new_password" id="new_password"/>
                    @error('new_password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" placeholder="Confirm New Password" name="new_password_confirmation" id="confirm_password" />
                    @error('new_password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-2">Update</button>  
            </form>                   
        </div>
    </div>                
</div>
@endsection