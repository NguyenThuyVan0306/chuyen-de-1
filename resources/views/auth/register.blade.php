@extends('layouts.main')

@section('content')

<h2 class="auth-title">Đăng ký tài khoản</h2>

<form method="POST" action="{{ route('register.submit') }}">
    @csrf

    <!-- Name -->
    <div class="form-group">
        <input 
            type="text" 
            name="name" 
            class="form-input" 
            placeholder="Họ và tên"
            value="{{ old('name') }}"
        >
        @error('name')
            <span class="error-text">{{ $message }}</span>
        @enderror
    </div>

    <!-- Email -->
    <div class="form-group">
        <input 
            type="email" 
            name="email" 
            class="form-input" 
            placeholder="Email"
            value="{{ old('email') }}"
        >
        @error('email')
            <span class="error-text">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password -->
    <div class="form-group">
        <input 
            type="password" 
            name="password" 
            class="form-input" 
            placeholder="Mật khẩu"
        >
        @error('password')
            <span class="error-text">{{ $message }}</span>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="form-group">
        <input 
            type="password" 
            name="password_confirmation" 
            class="form-input" 
            placeholder="Xác nhận mật khẩu"
        >
    </div>

    <!-- Role Selection -->
    <div class="form-group" style="display: flex; gap: 20px; align-items: center; margin-bottom: 20px;">
        <label style="font-weight: 500;">Đăng ký với vai trò:</label>
        <div style="display: flex; gap: 15px;">
            <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                <input type="radio" name="role" value="member" {{ old('role', 'member') == 'member' ? 'checked' : '' }}> Thành viên
            </label>
            <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                <input type="radio" name="role" value="leader" {{ old('role') == 'leader' ? 'checked' : '' }}> Trưởng nhóm
            </label>
        </div>
        @error('role')
            <span class="error-text" style="display:block;">{{ $message }}</span>
        @enderror
    </div>

    <!-- Submit -->
    <button type="submit" class="btn-primary">
        ĐĂNG KÝ NGAY
    </button>
</form>

<!-- Footer -->
<div class="auth-footer">
    Đã có tài khoản?
    <a href="{{ route('login') }}">Đăng nhập ngay</a>
</div>

@endsection