@extends('layouts.main')

@section('content')
<h2 class="auth-title">Đăng nhập</h2>

<div style="display: flex; gap: 10px; margin-bottom: 20px;">
    <button type="button" id="btn-member" style="flex: 1; padding: 10px; border: 1px solid #ccc; background: #6f42c1; color: white; border-radius: 5px; cursor:pointer; font-weight:600;" onclick="selectRole('member')">THÀNH VIÊN</button>
    <button type="button" id="btn-leader" style="flex: 1; padding: 10px; border: 1px solid #ccc; background: #fff; color: #333; border-radius: 5px; cursor:pointer; font-weight:600;" onclick="selectRole('leader')">TRƯỞNG NHÓM</button>
</div>

<form method="POST" action="{{ route('login.submit') }}">
    @csrf
    
    <input type="hidden" id="login_role" name="role" value="member">

    <div class="form-group">
        <input type="email" name="email" class="form-input" placeholder="Email">
    </div>

    <div class="form-group">
        <input type="password" name="password" class="form-input" placeholder="Password">
    </div>

    <button type="submit" class="btn-primary" id="btn-submit">ĐĂNG NHẬP THÀNH VIÊN</button>
</form>

<div class="auth-footer" style="margin-top:20px; display:flex; justify-content:space-between; align-items:center;">
    <span>Chưa có tài khoản?</span>
    <a href="{{ route('register', ['role' => 'member']) }}" id="link-register" style="padding: 8px 15px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 4px; text-decoration:none; color: #333; font-weight:500;">
        Đăng ký Thành viên
    </a>
</div>

<script>
function selectRole(role) {
    document.getElementById('login_role').value = role;
    
    let btnMember = document.getElementById('btn-member');
    let btnLeader = document.getElementById('btn-leader');
    let btnSubmit = document.getElementById('btn-submit');
    let linkRegister = document.getElementById('link-register');

    if (role === 'leader') {
        btnLeader.style.background = '#6f42c1';
        btnLeader.style.color = 'white';
        btnMember.style.background = '#fff';
        btnMember.style.color = '#333';
        
        btnSubmit.innerText = 'ĐĂNG NHẬP TRƯỞNG NHÓM';
        linkRegister.innerText = 'Đăng ký Trưởng nhóm';
        linkRegister.href = "{{ route('register') }}?role=leader";
    } else {
        btnMember.style.background = '#6f42c1';
        btnMember.style.color = 'white';
        btnLeader.style.background = '#fff';
        btnLeader.style.color = '#333';

        btnSubmit.innerText = 'ĐĂNG NHẬP THÀNH VIÊN';
        linkRegister.innerText = 'Đăng ký Thành viên';
        linkRegister.href = "{{ route('register') }}?role=member";
    }
}
</script>
@endsection