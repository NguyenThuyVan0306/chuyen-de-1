@extends('layouts.admin')

@section('content')
    <div style="max-width: 900px; margin: 0 auto;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
            <div>
                <h2 style="font-weight: 800; color: #1e1b4b; margin: 0; font-size: 1.8rem; letter-spacing: -0.5px;">Hồ sơ Quản trị viên</h2>
                <p style="color: #64748b; margin-top: 0.5rem; font-size: 1rem;">Quản lý thông tin tài khoản và bảo mật hệ thống.</p>
            </div>
            <div style="width: 60px; height: 60px; background: #e0e7ff; color: #4338ca; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; box-shadow: 0 4px 12px rgba(67, 56, 202, 0.1);">
                <i class="fas fa-user-shield"></i>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 300px 1fr; gap: 2rem;">
            <!-- Left Side: Profile Summary -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); text-align: center; border: 1px solid #f1f5f9;">
                    <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #4338ca 0%, #6366f1 100%); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; margin: 0 auto 1.5rem; box-shadow: 0 10px 15px -3px rgba(67, 56, 202, 0.3); border: 4px solid #fff;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h3 style="margin: 0; color: #1e1b4b; font-weight: 700;">{{ $user->name }}</h3>
                    <p style="color: #64748b; font-size: 0.9rem; margin: 0.5rem 0 1.5rem;">Administrator</p>
                    
                    <div style="padding-top: 1.5rem; border-top: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 0.75rem; text-align: left;">
                        <div style="display: flex; align-items: center; gap: 10px; color: #475569; font-size: 0.85rem;">
                            <i class="fas fa-envelope" style="color: #6366f1; width: 16px;"></i>
                            {{ $user->email }}
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; color: #475569; font-size: 0.85rem;">
                            <i class="fas fa-calendar-check" style="color: #6366f1; width: 16px;"></i>
                            Tham gia: {{ $user->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>

                <div style="background: #1e1b4b; padding: 1.5rem; border-radius: 1.5rem; color: white; box-shadow: 0 10px 15px -3px rgba(30, 27, 75, 0.2);">
                    <h4 style="margin: 0 0 1rem; font-size: 0.95rem; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-lightbulb" style="color: #fbbf24;"></i> Quyền hạn Admin
                    </h4>
                    <ul style="margin: 0; padding-left: 1.2rem; font-size: 0.85rem; color: #cbd5e1; display: flex; flex-direction: column; gap: 8px;">
                        <li>Toàn quyền quản lý người dùng</li>
                        <li>Duyệt/Từ chối thành lập CLB</li>
                        <li>Giám sát mọi sự kiện toàn trường</li>
                        <li>Quản trị dữ liệu hệ thống</li>
                    </ul>
                </div>
            </div>

            <!-- Right Side: Edit Form -->
            <div style="background: white; padding: 2.5rem; border-radius: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    <div style="display: grid; gap: 1.5rem;">
                        <h4 style="margin: 0; color: #1e1b4b; font-size: 1.1rem; font-weight: 700; border-left: 4px solid #4338ca; padding-left: 1rem;">Thông tin cơ bản</h4>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div>
                                <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem; font-size: 0.9rem;">Họ và tên</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                       style="width: 100%; padding: 0.85rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none; transition: all 0.2s; font-family: inherit;"
                                       onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'"
                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem; font-size: 0.9rem;">Email công việc</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                       style="width: 100%; padding: 0.85rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none; transition: all 0.2s; font-family: inherit;"
                                       onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'"
                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                            </div>
                        </div>

                        <div style="margin-top: 1rem;">
                            <h4 style="margin: 0 0 1.5rem; color: #1e1b4b; font-size: 1.1rem; font-weight: 700; border-left: 4px solid #f43f5e; padding-left: 1rem;">Bảo mật & Mật khẩu</h4>
                            <p style="color: #64748b; font-size: 0.85rem; margin-bottom: 1.5rem; background: #fff1f2; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #fecdd3;">
                                <i class="fas fa-info-circle"></i> Để trống nếu bạn không có nhu cầu thay đổi mật khẩu hiện tại.
                            </p>
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                <div>
                                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem; font-size: 0.9rem;">Mật khẩu mới</label>
                                    <input type="password" name="password" 
                                           style="width: 100%; padding: 0.85rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none; transition: all 0.2s; font-family: inherit;"
                                           onfocus="this.style.borderColor='#f43f5e'; this.style.boxShadow='0 0 0 4px rgba(244, 63, 94, 0.1)'"
                                           onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                </div>
                                <div>
                                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem; font-size: 0.9rem;">Xác nhận mật khẩu</label>
                                    <input type="password" name="password_confirmation" 
                                           style="width: 100%; padding: 0.85rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none; transition: all 0.2s; font-family: inherit;"
                                           onfocus="this.style.borderColor='#f43f5e'; this.style.boxShadow='0 0 0 4px rgba(244, 63, 94, 0.1)'"
                                           onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 1.5rem; padding-top: 2rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end;">
                            <button type="submit" style="background: #1e1b4b; color: white; border: none; padding: 1rem 2.5rem; border-radius: 12px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 12px rgba(30, 27, 75, 0.2);"
                                    onmouseover="this.style.background='#312e81'; this.style.transform='translateY(-2px)'"
                                    onmouseout="this.style.background='#1e1b4b'; this.style.transform='translateY(0)'">
                                <i class="fas fa-save" style="margin-right: 8px;"></i> Cập nhật hồ sơ Admin
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
