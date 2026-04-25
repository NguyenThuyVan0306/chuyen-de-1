@extends('layouts.main')

@section('content')
    <h2 class="auth-title">Đăng nhập Admin</h2>

    <div style="display: flex; gap: 10px; margin-bottom: 20px;">

    </div>

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="form-group">
            <input type="email" name="email" class="form-input" placeholder="Email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <input type="password" name="password" class="form-input" placeholder="Password" required>
        </div>

        <button type="submit" class="btn-primary" style="background: #6f42c1;">ĐĂNG NHẬP</button>
    </form>

    <div class="auth-footer" style="margin-top: 20px;">
        <i>Dành riêng cho Quản trị viên hệ thống</i>
    </div>
@endsection