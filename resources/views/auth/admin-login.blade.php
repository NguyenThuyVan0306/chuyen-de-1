@extends('layouts.main')

@section('content')
<h2 class="auth-title">Admin Login</h2>

<form method="POST" action="{{ route('admin.login.submit') }}">
    @csrf

    <div class="form-group">
        <input type="email" name="email" class="form-input" placeholder="Email">
    </div>

    <div class="form-group">
        <input type="password" name="password" class="form-input" placeholder="Password">
    </div>

    <button type="submit" class="btn-primary">ĐĂNG NHẬP ADMIN</button>
</form>

<div class="auth-footer" style="margin-top: 20px;">
    <i>Dành riêng cho Quản trị viên</i>
</div>
@endsection
