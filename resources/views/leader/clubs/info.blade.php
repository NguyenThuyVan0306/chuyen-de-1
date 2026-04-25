@extends('layouts.leader')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
        <div>
            <div class="page-title" style="margin: 0;">Quản lý Câu lạc bộ</div>
            <p style="color: #64748b; margin-top: 0.5rem;">Danh sách các tổ chức bạn đang phụ trách điều hành.</p>
        </div>
        
        <button onclick="document.getElementById('createClubModal').style.display='flex'" style="background: #8d5cf6; color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; transition: transform 0.2s; box-shadow: 0 4px 12px rgba(141, 92, 246, 0.2);">
            <i class="fas fa-plus-circle"></i> Thành lập CLB mới
        </button>
    </div>

    <!-- SEARCH SECTION -->
    <div style="margin-bottom: 2rem; background: white; padding: 1.25rem; border-radius: 1rem; border: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; gap: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <div style="flex: 1;">
            <form action="{{ route('leader.clubs.info') }}" method="GET" style="display: flex; gap: 0.5rem; max-width: 500px;">
                <div style="position: relative; flex: 1;">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Tìm nhanh Câu lạc bộ..." 
                        style="width: 100%; padding: 0.65rem 1rem 0.65rem 2.5rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-size: 0.95rem; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#8d5cf6'; this.style.boxShadow='0 0 0 3px rgba(141, 92, 246, 0.1)'"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                    >
                    <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem;">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <button type="submit" style="background: #8d5cf6; color: white; padding: 0 1.5rem; border-radius: 0.75rem; border: none; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 6px -1px rgba(141, 92, 246, 0.2);" onmouseover="this.style.background='#7c3aed'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#8d5cf6'; this.style.transform='translateY(0)'">
                    Tìm kiếm
                </button>
                @if(request('search'))
                    <a href="{{ route('leader.clubs.info') }}" style="text-decoration: none; color: #64748b; background: #f1f5f9; padding: 0.65rem 1rem; border-radius: 0.75rem; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center;">Xóa lọc</a>
                @endif
            </form>
        </div>
        <div style="color: #64748b; font-size: 0.9rem; font-weight: 600; background: #f8fafc; padding: 0.5rem 1rem; border-radius: 0.5rem;">
            📦 {{ $allClubs->count() }} CLB
        </div>
    </div>

    <!-- CLUB GRID -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
        @forelse($allClubs as $c)
            <div class="section-card" style="padding: 0; overflow: hidden; position: relative; transition: transform 0.3s; border: 1px solid #f1f5f9;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                
                <!-- Card Header with Image -->
                <div style="height: 160px; position: relative;">
                    @if($c->image)
                        <img src="{{ asset('storage/' . $c->image) }}" alt="{{ $c->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); display:flex; align-items:center; justify-content:center; color: #94a3b8;">
                            <i class="fas fa-image fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div style="position: absolute; top: 1rem; right: 1rem;">
                        @if($c->status == 'approved')
                            <span style="background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">✅ HOẠT ĐỘNG</span>
                        @elseif($c->status == 'pending')
                            <span style="background: #fef9c3; color: #a16207; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">⏳ ĐANG CHỜ</span>
                        @else
                            <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">❌ TỪ CHỐI</span>
                        @endif
                    </div>
                </div>

                <!-- Card Body -->
                <div style="padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: #1e293b;">{{ $c->name }}</h3>
                        @php
                            $approvedMembersCount = \App\Models\ClubMember::where('club_id', $c->id)->where('status', 'approved')->count();
                        @endphp
                        <span style="font-size: 0.8rem; color: #64748b; font-weight: 600; background: #f1f5f9; padding: 2px 8px; border-radius: 6px;">
                            {{ $approvedMembersCount }}/{{ $c->max_members }} TV
                        </span>
                    </div>
                    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.5; height: 3rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                        {{ $c->description ?? 'Chưa có mô tả hoạt động.' }}
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <!-- Quick Link 1: Members -->
                        <a href="{{ route('leader.members.index', ['club_id' => $c->id]) }}" style="text-decoration:none; display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; background: #f1f5f9; border-radius: 8px; color: #475569; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                            <span style="display: flex; align-items: center; gap: 0.75rem;">
                                <i class="fas fa-users" style="color: #8d5cf6;"></i> Thành viên
                            </span>
                            <i class="fas fa-chevron-right" style="font-size: 0.8rem; opacity: 0.5;"></i>
                        </a>

                        <!-- Quick Link 2: Events -->
                        <a href="{{ route('leader.events.index', ['club_id' => $c->id]) }}" style="text-decoration:none; display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; background: #f1f5f9; border-radius: 8px; color: #475569; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                            <span style="display: flex; align-items: center; gap: 0.75rem;">
                                <i class="fas fa-calendar-alt" style="color: #3b82f6;"></i> Sự kiện
                            </span>
                            <i class="fas fa-chevron-right" style="font-size: 0.8rem; opacity: 0.5;"></i>
                        </a>

                        <!-- Action Link 3: Edit Info -->
                        <button onclick="openEditModal('{{ $c->id }}', '{{ addslashes($c->name) }}', '{{ addslashes($c->description) }}', '{{ $c->contact_email }}', '{{ $c->contact_phone }}', '{{ $c->image ? asset('storage/'.$c->image) : '' }}')" style="border:none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 10px; background: #8d5cf6; color: white;">
                             <i class="fas fa-edit"></i> Chỉnh sửa thông tin
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; padding: 5rem; text-align: center; color: #94a3b8; background: white; border-radius: 1.5rem; border: 2px dashed #e2e8f0;">
                <i class="fas fa-folder-open fa-4x" style="opacity: 0.3; margin-bottom: 1rem;"></i>
                <h2>Chưa có Câu lạc bộ nào</h2>
                <p>Nhấp vào nút "Thành lập CLB mới" để bắt đầu.</p>
            </div>
        @endforelse
    </div>

    <!-- MODAL: CREATE CLUB -->
    <div id="createClubModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div style="background: white; width: 600px; border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); position: relative;">
            <button onclick="document.getElementById('createClubModal').style.display='none'" style="position: absolute; top: 1.5rem; right: 1.5rem; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #94a3b8;">&times;</button>
            <h3 style="margin-top: 0; color: #1e293b; margin-bottom: 1.5rem; border-left: 5px solid #8d5cf6; padding-left: 1rem;">📝 Đăng ký thành lập CLB</h3>
            <form action="{{ route('leader.clubs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; gap: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.3rem;">Tên Câu lạc bộ dự kiến</label>
                        <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.7rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem @error('name') ; border-color: #ef4444 @enderror">
                        @error('name') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.3rem;">Email liên hệ</label>
                            <input type="email" name="contact_email" value="{{ old('contact_email') }}" required style="width: 100%; padding: 0.7rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; box-sizing: border-box; @error('contact_email') border-color: #ef4444; @enderror">
                            @error('contact_email') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.3rem;">Số điện thoại</label>
                            <input type="text" name="contact_phone" value="{{ old('contact_phone') }}" required style="width: 100%; padding: 0.7rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; box-sizing: border-box; @error('contact_phone') border-color: #ef4444; @enderror">
                            @error('contact_phone') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.3rem;">Giới hạn thành viên tối đa</label>
                        <input type="number" name="max_members" value="{{ old('max_members', 50) }}" required style="width: 100%; padding: 0.7rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem @error('max_members') ; border-color: #ef4444 @enderror">
                        @error('max_members') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.3rem;">Mô tả mục tiêu & Hoạt động</label>
                        <textarea name="description" rows="3" required style="width: 100%; padding: 0.7rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem @error('description') ; border-color: #ef4444 @enderror">{{ old('description') }}</textarea>
                        @error('description') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.3rem;">Logo / Ảnh đại diện (nếu có)</label>
                        <input type="file" name="image" style="width: 100%; padding: 0.5rem; border: 1.5px dashed #cbd5e1; border-radius: 0.5rem @error('image') ; border-color: #ef4444 @enderror">
                        @error('image') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                    </div>
                    
                    <button type="submit" style="background: #8d5cf6; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 700; cursor: pointer; margin-top: 1rem; transition: background 0.2s;" onmouseover="this.style.background='#7c3aed'">Gửi yêu cầu thành lập</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDIT CLUB -->
    <div id="editClubModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div style="background: white; width: 600px; border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); position: relative;">
            <button onclick="document.getElementById('editClubModal').style.display='none'" style="position: absolute; top: 1.5rem; right: 1.5rem; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #94a3b8;">&times;</button>
            <h3 style="margin-top: 0; color: #1e293b; margin-bottom: 1.5rem; border-left: 5px solid #8d5cf6; padding-left: 1rem;">✏️ Sửa thông tin Câu lạc bộ</h3>
            <form id="editClubForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; gap: 1rem;">
                    <div style="display: flex; gap: 1.5rem; align-items: center; margin-bottom: 0.5rem;">
                        <img id="edit-preview-image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 1rem; display: none;">
                        <div style="flex: 1;">
                            <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.3rem;">Ảnh Logo mới</label>
                            <input type="file" name="image" onchange="previewEditImage(this)" style="width: 100%; padding: 0.5rem; border: 1.5px dashed #cbd5e1; border-radius: 0.5rem;">
                        </div>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.3rem;">Tên Câu lạc bộ</label>
                        <input type="text" name="name" id="edit-name" required style="width: 100%; padding: 0.7rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem;">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.3rem;">Email</label>
                            <input type="email" name="contact_email" id="edit-email" required style="width: 100%; padding: 0.7rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; box-sizing: border-box;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.3rem;">SĐT</label>
                            <input type="text" name="contact_phone" id="edit-phone" required style="width: 100%; padding: 0.7rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; box-sizing: border-box;">
                        </div>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.3rem;">Mô tả hoạt động</label>
                        <textarea name="description" id="edit-description" rows="3" required style="width: 100%; padding: 0.7rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem;"></textarea>
                    </div>
                    <button type="submit" style="background: #2563eb; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 700; cursor: pointer; margin-top: 1rem;">Cập nhật thông tin</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, description, email, phone, imageUrl) {
            const form = document.getElementById('editClubForm');
            form.action = `/leader/club-info/${id}/update`;
            
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-phone').value = phone;
            
            const preview = document.getElementById('edit-preview-image');
            if (imageUrl) {
                preview.src = imageUrl;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
            
            document.getElementById('editClubModal').style.display = 'flex';
        }

        function previewEditImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('edit-preview-image');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
