@extends('layouts.member')

@section('content')
    <!-- HERO SECTION -->
    <section style="background: linear-gradient(135deg, #1e40af, #3b82f6); border-radius: 20px; padding: 3rem; color: white; margin-bottom: 2rem; position: relative; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(30, 64, 175, 0.2);">
        <div style="position: relative; z-index: 2;">
            <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem;">Chào mừng quay trở lại, {{ Auth::user()->name }}! 👋</h1>
            <p style="font-size: 1.1rem; opacity: 0.9; max-width: 600px; line-height: 1.6;">
                Bạn đã sẵn sàng cho những hoạt động sôi nổi ngày hôm nay chưa? Hãy khám phá các sự kiện mới nhất và quản lý câu lạc bộ của bạn ngay bên dưới.
            </p>
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <a href="{{ route('member.clubs.index') }}" style="background: white; color: #1e40af; padding: 0.8rem 1.5rem; border-radius: 12px; font-weight: 700; text-decoration: none; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Khám phá CLB mới</a>
                <a href="{{ route('member.events.index') }}" style="background: rgba(255,255,255,0.2); color: white; padding: 0.8rem 1.5rem; border-radius: 12px; font-weight: 700; text-decoration: none; border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(10px); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Xem lịch sự kiện</a>
            </div>
        </div>
        <i class="fas fa-rocket" style="position: absolute; right: 5%; bottom: -10%; font-size: 15rem; opacity: 0.1; transform: rotate(-15deg);"></i>
    </section>

    <!-- QUICK STATS -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 16px; display: flex; align-items: center; gap: 1.25rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
            <div style="background: #eff6ff; color: #3b82f6; width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p style="color: #64748b; font-size: 0.9rem; font-weight: 600; margin: 0;">CLB của tôi</p>
                <h3 style="font-size: 1.75rem; font-weight: 800; color: #1e293b; margin: 0.2rem 0 0 0;">{{ $joinedClubsCount }}</h3>
            </div>
        </div>

        <div style="background: white; padding: 1.5rem; border-radius: 16px; display: flex; align-items: center; gap: 1.25rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
            <div style="background: #fff7ed; color: #f97316; width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div>
                <p style="color: #64748b; font-size: 0.9rem; font-weight: 600; margin: 0;">Đơn chờ duyệt</p>
                <h3 style="font-size: 1.75rem; font-weight: 800; color: #1e293b; margin: 0.2rem 0 0 0;">{{ $totalPendingCount }}</h3>
            </div>
        </div>

        <div style="background: white; padding: 1.5rem; border-radius: 16px; display: flex; align-items: center; gap: 1.25rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
            <div style="background: #f0fdf4; color: #22c55e; width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <p style="color: #64748b; font-size: 0.9rem; font-weight: 600; margin: 0;">Sự kiện sắp tới</p>
                <h3 style="font-size: 1.75rem; font-weight: 800; color: #1e293b; margin: 0.2rem 0 0 0;">{{ $upcomingEventsCount }}</h3>
            </div>
        </div>
    </div>

    <!-- MAIN DASHBOARD CONTENT -->
    <div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 2rem; align-items: start;">
        
        <!-- LEFT COLUMN: CLUBS & DISCOVERY -->
        <div style="display: flex; flex-direction: column; gap: 2.5rem;">
            <!-- MY CLUBS SECTION -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-shield-alt" style="color: #3b82f6;"></i> Câu lạc bộ của tôi
                    </h2>
                    <a href="{{ route('member.myclubs.index') }}" style="color: #3b82f6; text-decoration: none; font-weight: 700; font-size: 0.9rem;">Xem tất cả</a>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                    @forelse($myClubs as $club)
                        <div style="background: white; border-radius: 18px; padding: 1.25rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 20px -5px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.05)'">
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                @if($club->image)
                                    <img src="{{ asset('storage/' . $club->image) }}" style="width: 64px; height: 64px; border-radius: 14px; object-fit: cover;">
                                @else
                                    <div style="width: 64px; height: 64px; border-radius: 14px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 1.5rem;">
                                        <i class="fas fa-users-cog"></i>
                                    </div>
                                @endif
                                <div>
                                    <h4 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #1e293b;">{{ $club->name }}</h4>
                                    <span style="font-size: 0.8rem; color: #64748b; font-weight: 600;">{{ $club->contact_email }}</span>
                                </div>
                            </div>
                            <p style="font-size: 0.9rem; color: #64748b; line-height: 1.5; margin-bottom: 1.25rem; height: 2.7rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $club->description }}
                            </p>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
                                <span style="font-size: 0.8rem; color: #94a3b8;"><i class="fas fa-user-friends" style="margin-right: 5px;"></i> {{ $club->club_members_count ?? 0 }} thành viên</span>
                                <a href="#" style="background: #eff6ff; color: #3b82f6; padding: 0.5rem 1rem; border-radius: 10px; font-weight: 700; text-decoration: none; font-size: 0.85rem;">Truy cập</a>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; background: #f8fafc; border: 1.5px dashed #e2e8f0; border-radius: 20px; padding: 3rem; text-align: center; color: #94a3b8;">
                            <i class="fas fa-search-plus" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                            <p style="font-weight: 600; margin: 0;">Bạn chưa tham gia câu lạc bộ nào.</p>
                            <a href="{{ route('member.clubs.index') }}" style="color: #3b82f6; text-decoration: underline; display: block; margin-top: 0.5rem;">Hãy bắt đầu ngay!</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- DISCOVER CLUBS BOX (MOVED TO LEFT) -->
            <div style="background: #eff6ff; border-radius: 20px; padding: 2rem; border: 1px solid #dbeafe; position: relative; overflow: hidden;">
                <div style="position: relative; z-index: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="color: #1e40af; font-size: 1.25rem; font-weight: 800; margin: 0;">Khám phá câu lạc bộ mới</h3>
                        <a href="{{ route('member.clubs.index') }}" style="color: #1e40af; text-decoration: none; font-weight: 700; font-size: 0.85rem; background: white; padding: 5px 12px; border-radius: 8px;">Xem thêm</a>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        @foreach($latestClubs as $c)
                            <a href="{{ route('member.clubs.index') }}" style="text-decoration: none; background: white; padding: 1rem; border-radius: 14px; display: flex; align-items: center; gap: 0.875rem; border: 1px solid rgba(30, 64, 175, 0.05); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #3b82f6; font-size: 1.25rem;">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <div style="overflow: hidden;">
                                    <p style="font-weight: 700; color: #334155; font-size: 0.9rem; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $c->name }}</p>
                                    <p style="font-size: 0.75rem; color: #64748b; margin: 0;">Mới cập nhật</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <i class="fas fa-compass" style="position: absolute; right: -20px; top: -20px; font-size: 8rem; color: #1e40af; opacity: 0.05; transform: rotate(15deg);"></i>
            </div>
        </div>

        <!-- RIGHT COLUMN: ACTIVITY FEED / EVENTS -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-calendar-day" style="color: #10b981;"></i> Sự kiện mới nhất
                </h2>
                <a href="{{ route('member.events.index') }}" style="color: #10b981; text-decoration: none; font-weight: 700; font-size: 0.9rem;">Xem tất cả</a>
            </div>

            <div style="display: grid; gap: 1rem;">
                @forelse($latestEvents as $event)
                    <div style="background: white; border-radius: 16px; padding: 1.25rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; transition: transform 0.2s;" onmouseover="this.style.transform='translateX(4px)'" onmouseout="this.style.transform='translateX(0)'">
                        <div style="display: flex; gap: 1rem;">
                            <div style="min-width: 50px; text-align: center; background: #f0fdf4; border-radius: 12px; padding: 0.5rem;">
                                <div style="font-size: 0.75rem; font-weight: 800; color: #22c55e; text-transform: uppercase;">{{ $event->start_time->format('M') }}</div>
                                <div style="font-size: 1.25rem; font-weight: 800; color: #15803d;">{{ $event->start_time->format('d') }}</div>
                            </div>
                            <div style="flex: 1;">
                                <h5 style="margin: 0; font-size: 1rem; font-weight: 800; color: #1e293b;">{{ $event->title }}</h5>
                                <p style="margin: 0.25rem 0; font-size: 0.85rem; color: #64748b;"><i class="fas fa-map-marker-alt" style="color: #ef4444; width: 14px;"></i> {{ $event->location }}</p>
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                                    <span style="background: {{ $event->calculated_status_color }}15; color: {{ $event->calculated_status_color }}; padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 700;">
                                        {{ $event->calculated_status_label }}
                                    </span>
                                    <span style="color: #94a3b8; font-size: 0.75rem;">• {{ $event->club->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="background: white; border-radius: 16px; padding: 2rem; text-align: center; color: #94a3b8; border: 1px solid #f1f5f9;">
                        <p style="margin: 0; font-size: 0.9rem;">Chưa có sự kiện nào gần đây.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection