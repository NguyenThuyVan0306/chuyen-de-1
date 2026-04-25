@extends('layouts.main')

@section('content')
    <h2 class="auth-title">Đăng nhập</h2>

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <div class="form-group">
            <input type="email" name="email" class="form-input" placeholder="Email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <input type="password" name="password" class="form-input" placeholder="Password" required>
        </div>

        <button type="submit" class="btn-primary" id="btn-submit">ĐĂNG NHẬP</button>
    </form>

    <div class="auth-footer" style="margin-top: 24px;">
        <span>Bạn chưa có tài khoản?</span>
        <a href="{{ route('register') }}" style="color: #0b79bf; font-weight: 600; text-decoration: none; margin-left: 5px;">Đăng ký</a>
    </div>
@endsection