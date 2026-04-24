@extends('layouts.admin')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-weight: 700; color: #1e293b; margin: 0;">Quản lý Câu lạc bộ</h2>
            <p style="color: #64748b; margin: 0.5rem 0 0 0;">Giám sát, phê duyệt và chỉ định nhân sự cho các CLB toàn trường.</p>
        </div>
        <div>
           <!-- Search or filter could go here -->
        </div>
    </div>

    <!-- Form Section -->
    <div class="section-card" style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 2rem; margin-bottom: 2.5rem; border: 1px solid #f1f5f9;">
        <h3 style="font-weight: 700; color: #334155; margin-bottom: 1.5rem; border-left: 5px solid #6366f1; padding-left: 1rem;">
            {{ isset($editClub) ? 'Cập nhật thông tin CLB' : 'Thành lập Câu lạc bộ mới' }}
        </h3>

        <form
            action="{{ isset($editClub) ? route('admin.clubs.update', $editClub->id) : route('admin.clubs.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Tên Câu lạc bộ</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $editClub->name ?? '') }}"
                        placeholder="Nhập tên CLB..."
                        style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#6366f1'"
                        onblur="this.style.borderColor='#e2e8f0'"
                    >
                    @error('name')
                        <span style="color:#ef4444; font-size: 0.8rem; margin-top: 0.3rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Chủ nhiệm (Leader)</label>
                    <select
                        name="user_id"
                        style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none; background: white;"
                    >
                        <option value="">-- Thuộc quyền quản lý Admin --</option>
                        @foreach($leaders as $leader)
                            <option value="{{ $leader->id }}" {{ old('user_id', $editClub->user_id ?? '') == $leader->id ? 'selected' : '' }}>
                                ✅ {{ $leader->name }} ({{ $leader->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Email liên hệ</label>
                    <input
                        type="email"
                        name="contact_email"
                        value="{{ old('contact_email', $editClub->contact_email ?? '') }}"
                        placeholder="clb@duytan.edu.vn"
                        style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none;"
                    >
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Số điện thoại</label>
                    <input
                        type="text"
                        name="contact_phone"
                        value="{{ old('contact_phone', $editClub->contact_phone ?? '') }}"
                        placeholder="09xx xxx xxx"
                        style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none;"
                    >
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Giới hạn thành viên</label>
                    <input
                        type="number"
                        name="max_members"
                        value="{{ old('max_members', $editClub->max_members ?? '50') }}"
                        style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none;"
                    >
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Ảnh đại diện CLB</label>
                    @if(isset($editClub) && $editClub->image)
                        <div style="margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <img src="{{ asset('storage/' . $editClub->image) }}" alt="Preview" style="width: 50px; height: 50px; object-fit: cover; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                            <span style="font-size: 0.8rem; color: #64748b;">Ảnh hiện tại</span>
                        </div>
                    @endif
                    <input type="file" name="image" style="width: 100%; padding: 0.5rem; border: 1.5px dashed #cbd5e1; border-radius: 0.75rem;">
                </div>

                <div style="grid-column: 1 / -1;">
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Mô tả hoạt động</label>
                    <textarea
                        name="description"
                        rows="3"
                        placeholder="Giới thiệu mục tiêu và hoạt động của CLB..."
                        style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none; resize: vertical;"
                    >{{ old('description', $editClub->description ?? '') }}</textarea>
                </div>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" style="background: #6366f1; color: white; padding: 0.75rem 2rem; border-radius: 0.75rem; border: none; font-weight: 600; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
                    {{ isset($editClub) ? 'Cập nhật ngay' : 'Tạo Câu lạc bộ' }}
                </button>
                @if(isset($editClub))
                    <a href="{{ route('admin.clubs.index') }}" style="text-decoration: none; color: #64748b; padding: 0.75rem 2rem; border-radius: 0.75rem; background: #f1f5f9; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">Hủy bỏ</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="section-card" style="background: white; border-radius: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); padding: 1.5rem; border: 1px solid #f1f5f9;">
        <h3 style="font-weight: 700; color: #334155; margin-bottom: 1.5rem;">📋 Danh sách Câu lạc bộ</h3>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0 0.75rem;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: 1rem; text-align: left; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0;">STT</th>
                        <th style="padding: 1rem; text-align: left; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0;">Ảnh</th>
                        <th style="padding: 1rem; text-align: left; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0;">Tên CLB</th>
                        <th style="padding: 1rem; text-align: left; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0;">Chủ nhiệm</th>
                        <th style="padding: 1rem; text-align: center; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0;">TV Tối đa</th>
                        <th style="padding: 1rem; text-align: center; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0;">Trạng thái</th>
                        <th style="padding: 1rem; text-align: right; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clubs as $key => $club)
                        <tr style="background: #fff; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                            <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; color: #94a3b8;">{{ $key + 1 }}</td>
                            <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9;">
                                @if($club->image)
                                    <img src="{{ asset('storage/' . $club->image) }}" alt="Thumbnail" style="width: 45px; height: 45px; object-fit: cover; border-radius: 10px; border: 1px solid #eee;">
                                @else
                                    <div style="width: 45px; height: 45px; background: #f8fafc; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #cbd5e1; border: 1px dashed #e2e8f0;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; font-weight: 700; color: #1e293b;">{{ $club->name }}</td>
                            <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; color: #64748b;">
                                <div style="display:flex; align-items:center; gap: 0.5rem;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: #e0e7ff; color: #6366f1; display:flex; align-items:center; justify-content:center; font-size: 0.8rem; font-weight: 700;">
                                        {{ Str::upper(Str::substr($club->leader->name ?? 'A', 0, 1)) }}
                                    </div>
                                    {{ $club->leader->name ?? 'Admin' }}
                                </div>
                            </td>
                            <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; text-align: center; font-weight: 600; color: #334155;">{{ $club->max_members }}</td>
                            <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                @if($club->status == 'approved')
                                    <span style="background: #dcfce7; color: #166534; padding: 0.3rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 700;">✅ HOẠT ĐỘNG</span>
                                @elseif($club->status == 'pending')
                                    <span style="background: #fef9c3; color: #854d0e; padding: 0.3rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 700;">⏳ ĐANG CHỜ</span>
                                @else
                                    <span style="background: #fee2e2; color: #991b1b; padding: 0.3rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 700;">❌ TỪ CHỐI</span>
                                @endif
                            </td>
                            <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                                    
                                    @if($club->status == 'pending')
                                        <form action="{{ route('admin.clubs.approve', $club->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            <button type="submit" title="Duyệt CLB" style="padding: 0.5rem; background: #22c55e; color: white; border: none; border-radius: 0.5rem; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#16a34a'">Duyệt</button>
                                        </form>
                                        <form action="{{ route('admin.clubs.reject', $club->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            <button type="submit" title="Từ chối" style="padding: 0.5rem; background: #fbbf24; color: white; border: none; border-radius: 0.5rem; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#f59e0b'">Từ chối</button>
                                        </form>
                                    @endif

                                    <a href="{{ route('admin.clubs.edit', $club->id) }}" style="padding: 0.5rem; background: #6366f1; color: white; border-radius: 0.5rem; text-decoration: none; font-size: 0.9rem;" title="Sửa thông tin">Sửa</a>
                                    
                                    <form action="{{ route('admin.clubs.delete', $club->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Xác nhận xóa hoàn toàn CLB này?')">
                                        @csrf
                                        <button type="submit" style="padding: 0.5rem; background: #ef4444; color: white; border: none; border-radius: 0.5rem; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#dc2626'">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 3rem; text-align: center; color: #94a3b8;">
                                <div style="font-size: 2rem; margin-bottom: 1rem;">🔍</div>
                                Không tìm thấy dữ liệu Câu lạc bộ nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection