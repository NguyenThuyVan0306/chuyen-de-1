@extends('layouts.admin')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-weight: 700; color: #1e293b; margin: 0;">Quản lý Người dùng</h2>
            <p style="color: #64748b; margin: 0.5rem 0 0 0;">Quản trị tài khoản, phân quyền và kiểm soát trạng thái truy cập hệ thống.</p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="section-card" style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 2rem; margin-bottom: 2.5rem; border: 1px solid #f1f5f9;">
        <h3 style="font-weight: 700; color: #334155; margin-bottom: 1.5rem; border-left: 5px solid #ec4899; padding-left: 1rem;">
            {{ isset($editUser) ? 'Cập nhật thông tin tài khoản' : 'Đăng ký tài khoản mới' }}
        </h3>

        <form 
            action="{{ isset($editUser) ? route('admin.users.update', $editUser->id) : route('admin.users.store') }}" 
            method="POST"
        >
            @csrf

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Họ và tên</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $editUser->name ?? '') }}"
                        placeholder="Nhập họ tên..."
                        style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#ec4899'"
                        onblur="this.style.borderColor='#e2e8f0'"
                    >
                    @error('name')
                        <span style="color:#ef4444; font-size: 0.8rem; margin-top: 0.3rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Email (Tài khoản)</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $editUser->email ?? '') }}"
                        placeholder="example@gmail.com"
                        style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none;"
                    >
                    @error('email')
                        <span style="color:#ef4444; font-size: 0.8rem; margin-top: 0.3rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">
                        Mật khẩu {{ isset($editUser) ? '(Để trống nếu không đổi)' : '' }}
                    </label>
                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none;"
                    >
                    @error('password')
                        <span style="color:#ef4444; font-size: 0.8rem; margin-top: 0.3rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Vai trò</label>
                    <select
                        name="role"
                        style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none; background: white;"
                    >
                        <option value="">-- Chọn vai trò --</option>
                        <option value="admin" {{ old('role', $editUser->role ?? '') == 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                        <option value="leader" {{ old('role', $editUser->role ?? '') == 'leader' ? 'selected' : '' }}>Chủ nhiệm CLB (Leader)</option>
                        <option value="member" {{ old('role', $editUser->role ?? '') == 'member' ? 'selected' : '' }}>Thành viên (Member)</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Trạng thái tài khoản</label>
                    <select
                        name="status"
                        style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none; background: white;"
                    >
                        <option value="active" {{ old('status', $editUser->status ?? '') == 'active' ? 'selected' : '' }}>🟢 Đang hoạt động</option>
                        <option value="blocked" {{ old('status', $editUser->status ?? '') == 'blocked' ? 'selected' : '' }}>🔴 Đang bị khóa</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" style="background: #ec4899; color: white; padding: 0.75rem 2rem; border-radius: 0.75rem; border: none; font-weight: 600; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#db2777'" onmouseout="this.style.background='#ec4899'">
                    {{ isset($editUser) ? 'Lưu thay đổi' : 'Tạo tài khoản' }}
                </button>
                @if(isset($editUser))
                    <a href="{{ route('admin.users.index') }}" style="text-decoration: none; color: #64748b; padding: 0.75rem 2rem; border-radius: 0.75rem; background: #f1f5f9; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">Hủy sửa</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="section-card" style="background: white; border-radius: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); padding: 1.5rem; border: 1px solid #f1f5f9;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-weight: 700; color: #334155; margin: 0;">👥 Danh sách Người dùng</h3>
            
            <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; gap: 0.5rem; align-items: center; width: 400px;">
                <div style="position: relative; flex: 1;">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Tìm tên hoặc email..." 
                        style="width: 100%; padding: 0.6rem 1rem 0.6rem 2.5rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-size: 0.9rem; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 0 3px rgba(236, 72, 153, 0.1)'"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                    >
                    <span style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem;">🔍</span>
                </div>
                <button type="submit" style="background: #1e293b; color: white; padding: 0.6rem 1.25rem; border-radius: 0.75rem; border: none; font-weight: 600; cursor: pointer; font-size: 0.9rem; transition: background 0.2s;" onmouseover="this.style.background='#0f172a'" onmouseout="this.style.background='#1e293b'">
                    Tìm
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.users.index') }}" style="text-decoration: none; color: #64748b; font-size: 0.85rem; font-weight: 600; white-space: nowrap; padding: 0.5rem 0.75rem; border-radius: 0.5rem; background: #f1f5f9;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">Xóa lọc</a>
                @endif
            </form>
        </div>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0 0.75rem;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: 1rem; text-align: left; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0;">STT</th>
                        <th style="padding: 1rem; text-align: left; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0;">Người dùng</th>
                        <th style="padding: 1rem; text-align: left; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0;">Email</th>
                        <th style="padding: 1rem; text-align: center; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0;">Vai trò</th>
                        <th style="padding: 1rem; text-align: center; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0;">Trạng thái</th>
                        <th style="padding: 1rem; text-align: right; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $key => $user)
                        <tr style="background: #fff; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                            <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; color: #94a3b8;">{{ $key + 1 }}</td>
                            <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; font-weight: 700; color: #1e293b;">
                                <div style="display:flex; align-items:center; gap: 0.75rem;">
                                    <div style="width: 40px; height: 40px; border-radius: 12px; background: #fdf2f8; color: #ec4899; display:flex; align-items:center; justify-content:center; font-size: 1rem; font-weight: 700;">
                                        {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; color: #64748b;">{{ $user->email }}</td>
                            <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                @if($user->role == 'admin')
                                    <span style="background: #e0e7ff; color: #4338ca; padding: 0.3rem 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700;">ADMIN</span>
                                @elseif($user->role == 'leader')
                                    <span style="background: #fdf2f8; color: #be185d; padding: 0.3rem 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700;">LEADER</span>
                                @else
                                    <span style="background: #f1f5f9; color: #475569; padding: 0.3rem 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700;">MEMBER</span>
                                @endif
                            </td>
                            <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                @if($user->status == 'active')
                                    <span style="color: #10b981; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 0.4rem;">
                                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></div> Hoạt động
                                    </span>
                                @else
                                    <span style="color: #ef4444; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 0.4rem;">
                                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #ef4444;"></div> Bị khóa
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" style="padding: 0.5rem 1rem; background: #6366f1; color: white; border-radius: 0.5rem; text-decoration: none; font-size: 0.85rem; font-weight: 600;" title="Chỉnh sửa">Sửa</a>
                                    
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Xác nhận xóa tài khoản này?')">
                                        @csrf
                                        <button type="submit" style="padding: 0.5rem 1rem; background: #ef4444; color: white; border: none; border-radius: 0.5rem; cursor: pointer; font-size: 0.85rem; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='#dc2626'">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 3rem; text-align: center; color: #94a3b8;">
                                Chưa có dữ liệu tài khoản nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection