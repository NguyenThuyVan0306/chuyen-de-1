@extends('layouts.main')

@section('content')

<h2 class="auth-title">Đăng ký tài khoản</h2>

<div style="display: flex; gap: 12px; margin-bottom: 24px;">
    @php
        $selectedRole = request()->query('role', old('role', 'member'));
    @endphp
    
    <div id="role-member" 
         onclick="toggleRole('member')" 
         style="flex: 1; padding: 12px; border: 2px solid {{ $selectedRole == 'member' ? '#6f42c1' : '#eee' }}; background: {{ $selectedRole == 'member' ? '#f3f0ff' : '#fff' }}; border-radius: 12px; cursor: pointer; text-align: center; transition: all 0.3s ease;">
        <i class="fas fa-user" style="font-size: 20px; color: {{ $selectedRole == 'member' ? '#6f42c1' : '#999' }}; margin-bottom: 5px;"></i>
        <div style="font-size: 13px; font-weight: 600; color: {{ $selectedRole == 'member' ? '#4a148c' : '#666' }};">THÀNH VIÊN</div>
    </div>

    <div id="role-leader" 
         onclick="toggleRole('leader')" 
         style="flex: 1; padding: 12px; border: 2px solid {{ $selectedRole == 'leader' ? '#6f42c1' : '#eee' }}; background: {{ $selectedRole == 'leader' ? '#f3f0ff' : '#fff' }}; border-radius: 12px; cursor: pointer; text-align: center; transition: all 0.3s ease;">
        <i class="fas fa-user-tie" style="font-size: 20px; color: {{ $selectedRole == 'leader' ? '#6f42c1' : '#999' }}; margin-bottom: 5px;"></i>
        <div style="font-size: 13px; font-weight: 600; color: {{ $selectedRole == 'leader' ? '#4a148c' : '#666' }};">TRƯỞNG NHÓM</div>
    </div>
</div>

<form method="POST" action="{{ route('register.submit') }}">
    @csrf
    
    <input type="hidden" name="role" id="register_role" value="{{ $selectedRole }}">

    <div class="form-group">
        <input type="text" name="name" class="form-input" placeholder="Họ và tên" value="{{ old('name') }}" required>
        @error('name') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <input type="email" name="email" class="form-input" placeholder="Email" value="{{ old('email') }}" required>
        @error('email') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <input type="password" name="password" class="form-input" placeholder="Mật khẩu" required>
        @error('password') <span class="error-text">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <input type="password" name="password_confirmation" class="form-input" placeholder="Xác nhận mật khẩu" required>
    </div>

    <button type="submit" class="btn-primary" style="margin-top: 10px;">ĐĂNG KÝ NGAY</button>
</form>

<div class="auth-footer" style="margin-top: 20px;">
    <span>Đã có tài khoản?</span>
    <a href="{{ route('login') }}" style="color: #0b79bf; font-weight: 600; text-decoration: none; margin-left: 5px;">Đăng nhập ngay</a>
</div>

<script>
function toggleRole(role) {
    document.getElementById('register_role').value = role;
    
    const memberCard = document.getElementById('role-member');
    const leaderCard = document.getElementById('role-leader');
    const memberIcon = memberCard.querySelector('i');
    const leaderIcon = leaderCard.querySelector('i');
    const memberText = memberCard.querySelector('div');
    const leaderText = leaderCard.querySelector('div');

    if (role === 'member') {
        // Active Member
        memberCard.style.borderColor = '#6f42c1';
        memberCard.style.background = '#f3f0ff';
        memberIcon.style.color = '#6f42c1';
        memberText.style.color = '#4a148c';
        
        // Inactive Leader
        leaderCard.style.borderColor = '#eee';
        leaderCard.style.background = '#fff';
        leaderIcon.style.color = '#999';
        leaderText.style.color = '#666';
    } else {
        // Active Leader
        leaderCard.style.borderColor = '#6f42c1';
        leaderCard.style.background = '#f3f0ff';
        leaderIcon.style.color = '#6f42c1';
        leaderText.style.color = '#4a148c';
        
        // Inactive Member
        memberCard.style.borderColor = '#eee';
        memberCard.style.background = '#fff';
        memberIcon.style.color = '#999';
        memberText.style.color = '#666';
    }
}
</script>
@endsection