@extends('layouts.member')

@section('content')
    <div style="margin-bottom: 2.5rem; display: flex; align-items: center; gap: 1rem;">
        <div style="background: #8b5cf6; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);">
            <i class="fas fa-id-badge"></i>
        </div>
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1e293b; margin: 0;">Câu lạc bộ của tôi</h1>
            <p style="color: #64748b; margin-top: 0.25rem;">Danh sách các cộng đồng bạn đang tham gia chính thức.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
        @forelse($clubs as $club)
            <div style="background: white; border-radius: 24px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; display: flex; flex-direction: column; transition: 0.3s ease;" onmouseover="this.style.boxShadow='0 20px 25px -5px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.05)'">
                <div style="display: flex; align-items: center; gap: 1.25rem; margin-bottom: 1.5rem;">
                    @if($club->image)
                        <img src="{{ asset('storage/' . $club->image) }}" style="width: 70px; height: 70px; border-radius: 18px; object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    @else
                        <div style="width: 70px; height: 70px; border-radius: 18px; background: #faf5ff; display: flex; align-items: center; justify-content: center; color: #a855f7; font-size: 1.75rem; border: 1px solid #f3e8ff;">
                            <i class="fas fa-users"></i>
                        </div>
                    @endif
                    <div style="flex: 1;">
                        <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: #1e293b;">{{ $club->name }}</h3>
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.25rem;">
                            <span style="background: #dcfce7; color: #15803d; padding: 0.2rem 0.6rem; border-radius: 8px; font-size: 0.75rem; font-weight: 700;">Thành viên</span>
                        </div>
                    </div>
                </div>

                <div style="background: #f8fafc; border-radius: 16px; padding: 1rem; margin-bottom: 1.5rem;">
                    <p style="font-size: 0.9rem; color: #64748b; line-height: 1.6; margin: 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; height: 4.3rem;">
                        {{ $club->description }}
                    </p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                        <span style="font-size: 0.7rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Thành viên</span>
                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                            <i class="fas fa-user-friends" style="color: #6366f1; font-size: 0.8rem;"></i>
                            <span style="font-size: 0.9rem; color: #475569; font-weight: 700;">{{ $club->approved_count }} / {{ $club->max_members }}</span>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                        <span style="font-size: 0.7rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Quản lý</span>
                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                            <i class="fas fa-user-tie" style="color: #10b981; font-size: 0.8rem;"></i>
                            <span style="font-size: 0.9rem; color: #475569; font-weight: 700;">{{ $club->leader->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <div style="margin-top: auto; display: flex; gap: 0.75rem;">
                    <a href="#" style="flex: 1; background: #1e293b; color: white; padding: 0.8rem; border-radius: 12px; font-weight: 700; text-decoration: none; text-align: center; font-size: 1rem; transition: background 0.2s;" onmouseover="this.style.background='#0f172a'" onmouseout="this.style.background='#1e293b'">
                        Truy cập CLB
                    </a>
                    <form action="{{ route('member.clubs.leave', $club->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn rời câu lạc bộ không?')" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; width: 44px; height: 100%; border-radius: 12px; cursor: pointer; transition: 0.2s;" title="Rời câu lạc bộ" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; background: white; border-radius: 24px; padding: 5rem; text-align: center; border: 2px dashed #e2e8f0;">
                <div style="width: 80px; height: 80px; background: #f8fafc; color: #94a3b8; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 1.5rem;">
                    <i class="fas fa-layer-group"></i>
                </div>
                <h3 style="color: #475569; font-weight: 700;">Bạn chưa tham gia câu lạc bộ nào</h3>
                <p style="color: #64748b; margin-bottom: 2rem;">Hãy bắt đầu tham gia các cộng đồng mình yêu thích nhé!</p>
                <a href="{{ route('member.clubs.index') }}" style="background: #3b82f6; color: white; padding: 0.8rem 2rem; border-radius: 12px; font-weight: 700; text-decoration: none; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);">Khám phá ngay</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div style="margin-top: 3rem; display: flex; justify-content: center;">
        {{ $clubs->links() }}
    </div>
@endsection