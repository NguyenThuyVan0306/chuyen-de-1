@extends('layouts.member')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1e293b; margin: 0;">Khám phá Câu lạc bộ</h1>
            <p style="color: #64748b; margin-top: 0.5rem;">Tìm kiếm và tham gia vào những cộng đồng phù hợp với sở thích của bạn.</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <div style="position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                <input type="text" placeholder="Tìm kiếm CLB..." style="padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1.5px solid #e2e8f0; border-radius: 12px; width: 300px; outline: none; focus: border-color: #3b82f6;">
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
        @forelse($clubs as $club)
            <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 25px -5px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.05)'">
                <div style="height: 180px; position: relative; overflow: hidden; background: #f1f5f9;">
                    @if($club->image)
                        <img src="{{ asset('storage/' . $club->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #eff6ff, #dbeafe); color: #3b82f6;">
                            <i class="fas fa-users" style="font-size: 4rem; opacity: 0.2;"></i>
                        </div>
                    @endif
                    <div style="position: absolute; top: 1rem; right: 1rem;">
                        <span style="background: rgba(255,255,255,0.9); padding: 0.4rem 0.8rem; border-radius: 10px; font-size: 0.75rem; font-weight: 700; color: #1e293b; backdrop-filter: blur(4px);">
                            <i class="fas fa-user-circle" style="margin-right: 4px; color: #3b82f6;"></i> {{ $club->approved_count }} TV
                        </span>
                    </div>
                </div>

                <div style="padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                        <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: #1e293b;">{{ $club->name }}</h3>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background: #e0e7ff; color: #6366f1; display:flex; align-items:center; justify-content:center; font-size: 0.7rem; font-weight: 700;">
                            {{ Str::upper(Str::substr($club->leader->name ?? 'A', 0, 1)) }}
                        </div>
                        <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;">Chủ nhiệm: {{ $club->leader->name ?? 'Admin' }}</span>
                    </div>
                    
                    <p style="font-size: 0.9rem; color: #64748b; line-height: 1.6; margin-bottom: 1.5rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; height: 4.8rem;">
                        <strong style="color: #475569;">Mô tả:</strong> {{ $club->description }}
                    </p>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; padding: 1rem; background: #f8fafc; border-radius: 14px;">
                        <div>
                            <span style="display: block; font-size: 0.7rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Liên hệ</span>
                            <span style="font-size: 0.85rem; color: #475569; font-weight: 600;">{{ $club->contact_phone }}</span>
                        </div>
                        <div>
                            <span style="display: block; font-size: 0.7rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Quy mô</span>
                            <span style="font-size: 0.85rem; color: #475569; font-weight: 600;">Tối đa {{ $club->max_members }}</span>
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.75rem; align-items: center;">
                        @php
                            $membership = $club->clubMembers->first();
                        @endphp

                        @if(!$membership)
                            <button onclick="openJoinModal('{{ $club->id }}', '{{ addslashes($club->name) }}')" style="flex: 1; background: #3b82f6; color: white; border: none; padding: 0.8rem; border-radius: 12px; font-weight: 700; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                                <i class="fas fa-plus-circle" style="margin-right: 6px;"></i> Tham gia ngay
                            </button>
                        @elseif($membership->status === 'pending')
                            <div style="flex: 1; background: #fff7ed; color: #f97316; padding: 0.8rem; border-radius: 12px; font-weight: 700; text-align: center; border: 1px solid #ffedd5;">
                                <i class="fas fa-clock" style="margin-right: 6px;"></i> Đang chờ duyệt
                            </div>
                        @elseif($membership->status === 'approved')
                            <div style="flex: 1; display: flex; gap: 0.5rem;">
                                <div style="flex: 1; background: #f0fdf4; color: #16a34a; padding: 0.8rem; border-radius: 12px; font-weight: 700; text-align: center; border: 1px solid #dcfce7;">
                                    <i class="fas fa-check-circle" style="margin-right: 6px;"></i> Thành viên
                                </div>
                                <form action="{{ route('member.clubs.leave', $club->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn rời câu lạc bộ không?')" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="background: #fee2e2; color: #ef4444; border: none; padding: 0.8rem 1rem; border-radius: 12px; cursor: pointer; transition: 0.2s;" title="Rời câu lạc bộ">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <div style="flex: 1; background: #fef2f2; color: #dc2626; padding: 0.8rem; border-radius: 12px; font-weight: 700; text-align: center; border: 1px solid #fee2e2;">
                                <i class="fas fa-times-circle" style="margin-right: 6px;"></i> Bị từ chối
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; background: white; border-radius: 20px; padding: 5rem; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <i class="fas fa-folder-open" style="font-size: 4rem; color: #e2e8f0; margin-bottom: 1.5rem;"></i>
                <h3 style="color: #64748b; font-weight: 600;">Hiện chưa có câu lạc bộ nào khả dụng.</h3>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div style="margin-top: 3rem; display: flex; justify-content: center;">
        {{ $clubs->links() }}
    </div>

    <!-- MODAL REGISTRATION -->
    <div id="joinModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: white; width: 100%; max-width: 500px; border-radius: 24px; padding: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); position: relative;">
            <button onclick="closeJoinModal()" style="position: absolute; top: 1.5rem; right: 1.5rem; background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 10px; cursor: pointer; color: #64748b; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
            
            <div style="margin-bottom: 2rem; text-align: center;">
                <div style="width: 70px; height: 70px; background: #eff6ff; color: #3b82f6; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem;">
                    <i class="fas fa-id-card"></i>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 0.5rem;" id="modalClubName">Đăng ký tham gia</h3>
                <p style="color: #64748b; font-size: 0.95rem;">Hãy điền thông tin của bạn để Leader duyệt nhé!</p>
            </div>

            <form id="joinForm" method="POST">
                @csrf
                <div style="display: grid; gap: 1.25rem;">
                    <div>
                        <label style="display: block; font-weight: 700; color: #475569; margin-bottom: 0.5rem; font-size: 0.9rem;">Khoa / Lớp</label>
                        <input type="text" name="faculty" value="{{ Auth::user()->faculty }}" required placeholder="Ví dụ: CNTT - K62" style="width: 100%; padding: 0.8rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 12px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 700; color: #475569; margin-bottom: 0.5rem; font-size: 0.9rem;">Lý do muốn tham gia</label>
                        <textarea name="reason" required placeholder="Chia sẻ một chút về mong muốn của bạn..." style="width: 100%; height: 120px; padding: 0.8rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 12px; outline: none; resize: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-top: 2rem;">
                    <button type="button" onclick="closeJoinModal()" style="padding: 0.9rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; font-weight: 700; color: #64748b; cursor: pointer;">Hủy bỏ</button>
                    <button type="submit" style="padding: 0.9rem; background: #3b82f6; border: none; border-radius: 12px; font-weight: 700; color: white; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);">Gửi yêu cầu gia nhập</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openJoinModal(clubId, clubName) {
            const modal = document.getElementById('joinModal');
            const form = document.getElementById('joinForm');
            const title = document.getElementById('modalClubName');
            
            title.innerText = 'Tham gia ' + clubName;
            form.action = `/member/clubs/${clubId}/join`;
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeJoinModal() {
            document.getElementById('joinModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('joinModal');
            if (event.target == modal) {
                closeJoinModal();
            }
        }
    </script>
@endsection