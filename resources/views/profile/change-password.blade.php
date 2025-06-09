@extends('layouts.app')

@section('content')
<h1 class="mb-4">Change Password</h1>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                <h4>{{ Auth::user()->name }}</h4>
                <p class="text-muted">{{ Auth::user()->email }}</p>
                <p>Member since {{ Auth::user()->created_at->format('M Y') }}</p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Quick Links</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user me-2"></i>My Profile
                    </a>
                    <a href="{{ route('orders.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-bag me-2"></i>My Orders
                    </a>
                    <a href="{{ route('profile.password') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-key me-2"></i>Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Change Password</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                        @error('current_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key me-2"></i>Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection