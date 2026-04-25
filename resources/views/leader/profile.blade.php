@extends('layouts.leader')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding-bottom: 3rem;">
    <!-- HEADER -->
    <div style="background: linear-gradient(135deg, #4a148c, #7b1fa2); border-radius: 20px; padding: 2.5rem; color: white; margin-bottom: 2rem; position: relative; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(74, 20, 140, 0.2);">
        <div style="position: relative; z-index: 2; display: flex; align-items: center; gap: 2rem;">
            <div style="position: relative;">
                <div style="width: 120px; height: 120px; border-radius: 30px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); display: flex; align-items: center; justify-content: center; font-size: 3.5rem; border: 4px solid rgba(255,255,255,0.3); font-weight: 800; color: white;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div style="position: absolute; bottom: -5px; right: -5px; background: #22c55e; width: 32px; height: 32px; border-radius: 50%; border: 4px solid #4a148c; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                    <i class="fas fa-check"></i>
                </div>
            </div>
            <div>
                <h1 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 0.5rem; color: white;">Hồ sơ Leader</h1>
                <p style="font-size: 1.1rem; opacity: 0.9; margin: 0;">Quản lý thông tin cá nhân và tài khoản trưởng câu lạc bộ</p>
                <div style="display: flex; gap: 1rem; margin-top: 1.25rem;">
                    <span style="background: rgba(255,255,255,0.15); padding: 6px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fas fa-shield-alt" style="margin-right: 6px;"></i> Cấp bậc: Leader
                    </span>
                    <span style="background: rgba(255,255,255,0.15); padding: 6px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fas fa-id-card" style="margin-right: 6px;"></i> Quản trị viên CLB
                    </span>
                </div>
            </div>
        </div>
        <i class="fas fa-user-shield" style="position: absolute; right: -5%; top: -10%; font-size: 15rem; opacity: 0.1; transform: rotate(15deg); color: white;"></i>
    </div>

    <!-- MAIN FORM -->
    <div style="background: white; border-radius: 24px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
        <form action="{{ route('leader.profile.update') }}" method="POST">
            @csrf
            
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 2rem;">
                <div style="width: 8px; height: 24px; background: #6f42c1; border-radius: 4px;"></div>
                <h2 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin: 0;">Thông tin cơ bản</h2>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                <div>
                    <label style="display: block; font-weight: 700; color: #64748b; font-size: 0.9rem; margin-bottom: 0.75rem;">Họ và tên Trưởng CLB</label>
                    <div style="position: relative;">
                        <i class="fas fa-user-tie" style="position: absolute; left: 1.25rem; top: 1.1rem; color: #94a3b8;"></i>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                            style="width: 100%; padding: 0.875rem 1.25rem 0.875rem 3rem; border-radius: 14px; border: 1px solid #e2e8f0; font-size: 1rem; color: #1e293b; background: #f8fafc; transition: all 0.2s; box-sizing: border-box;"
                            onfocus="this.style.borderColor='#6f42c1'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(111, 66, 193, 0.1)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none'">
                    </div>
                </div>

                <div>
                    <label style="display: block; font-weight: 700; color: #64748b; font-size: 0.9rem; margin-bottom: 0.75rem;">Đơn vị / Khoa</label>
                    <div style="position: relative;">
                        <i class="fas fa-university" style="position: absolute; left: 1.25rem; top: 1.1rem; color: #94a3b8;"></i>
                        <input type="text" name="faculty" value="{{ old('faculty', $user->faculty) }}" placeholder="Ví dụ: Công nghệ thông tin"
                            style="width: 100%; padding: 0.875rem 1.25rem 0.875rem 3rem; border-radius: 14px; border: 1px solid #e2e8f0; font-size: 1rem; color: #1e293b; background: #f8fafc; transition: all 0.2s; box-sizing: border-box;"
                            onfocus="this.style.borderColor='#6f42c1'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(111, 66, 193, 0.1)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none'">
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 2.5rem;">
                <label style="display: block; font-weight: 700; color: #64748b; font-size: 0.9rem; margin-bottom: 0.75rem;">Địa chỉ Email Công việc</label>
                <div style="position: relative;">
                    <i class="fas fa-envelope-open-text" style="position: absolute; left: 1.25rem; top: 1.1rem; color: #94a3b8;"></i>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        style="width: 100%; padding: 0.875rem 1.25rem 0.875rem 3rem; border-radius: 14px; border: 1px solid #e2e8f0; font-size: 1rem; color: #1e293b; background: #f8fafc; transition: all 0.2s; box-sizing: border-box;"
                        onfocus="this.style.borderColor='#6f42c1'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(111, 66, 193, 0.1)'"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none'">
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 2rem;">
                <div style="width: 8px; height: 24px; background: #f59e0b; border-radius: 4px;"></div>
                <h2 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin: 0;">Bảo mật & Mật khẩu</h2>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 3rem;">
                <div>
                    <label style="display: block; font-weight: 700; color: #64748b; font-size: 0.9rem; margin-bottom: 0.75rem;">Mật khẩu mới</label>
                    <div style="position: relative;">
                        <i class="fas fa-key" style="position: absolute; left: 1.25rem; top: 1.1rem; color: #94a3b8;"></i>
                        <input type="password" name="password" placeholder="Để trống nếu không đổi"
                            style="width: 100%; padding: 0.875rem 1.25rem 0.875rem 3rem; border-radius: 14px; border: 1px solid #e2e8f0; font-size: 1rem; color: #1e293b; background: #f8fafc; transition: all 0.2s; box-sizing: border-box;"
                            onfocus="this.style.borderColor='#6f42c1'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(111, 66, 193, 0.1)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none'">
                    </div>
                </div>

                <div>
                    <label style="display: block; font-weight: 700; color: #64748b; font-size: 0.9rem; margin-bottom: 0.75rem;">Xác nhận mật khẩu</label>
                    <div style="position: relative;">
                        <i class="fas fa-user-shield" style="position: absolute; left: 1.25rem; top: 1.1rem; color: #94a3b8;"></i>
                        <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu mới"
                            style="width: 100%; padding: 0.875rem 1.25rem 0.875rem 3rem; border-radius: 14px; border: 1px solid #e2e8f0; font-size: 1rem; color: #1e293b; background: #f8fafc; transition: all 0.2s; box-sizing: border-box;"
                            onfocus="this.style.borderColor='#6f42c1'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(111, 66, 193, 0.1)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none'">
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9;">
                <a href="{{ route('leader.home') }}" style="padding: 0.875rem 2rem; border-radius: 14px; font-weight: 700; text-decoration: none; color: #64748b; background: #f1f5f9; transition: all 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">Hủy bỏ</a>
                <button type="submit" style="padding: 0.875rem 2.5rem; border-radius: 14px; font-weight: 800; border: none; color: white; background: #6f42c1; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 14px 0 rgba(111, 66, 193, 0.39);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(111, 66, 193, 0.45)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px 0 rgba(111, 66, 193, 0.39)'">
                    Cập nhật hồ sơ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
