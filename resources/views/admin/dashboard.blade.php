@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="bi bi-speedometer2"></i> Dashboard Admin
        </h1>
    </div>
</div>

<div class="row">
    <!-- Total Users -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Tổng Users
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Users -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Admin
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['admin_users'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-shield-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Staff -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Nhân viên Live
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['live_staff'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-broadcast fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CSKH Staff -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            CSKH
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['cskh_staff'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-headset fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- External Users -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            External Users
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['external_users'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Keywords -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Từ khóa chặn
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_keywords'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-filter fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Chat Messages -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Tin nhắn Chat
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_chat_messages'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-chat-dots fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blocked Messages -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Tin nhắn bị chặn
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['blocked_messages'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-shield-x fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Current Live Settings -->
@if($stats['live_settings'])
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-broadcast"></i> Cài đặt Live hiện tại
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Link Live:</strong> 
                            <a href="{{ $stats['live_settings']->live_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-link-45deg"></i> Xem Live
                            </a>
                        </p>
                        <p><strong>Link Play FLV:</strong> 
                            @if($stats['live_settings']->play_url_flv)
                                <a href="{{ $stats['live_settings']->play_url_flv }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-play-circle"></i> FLV
                                </a>
                            @else
                                <span class="text-muted">Chưa có</span>
                            @endif
                        </p>
                        <p><strong>Link Play M3U8:</strong> 
                            @if($stats['live_settings']->play_url_m3u8)
                                <a href="{{ $stats['live_settings']->play_url_m3u8 }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-play-circle"></i> M3U8
                                </a>
                            @else
                                <span class="text-muted">Chưa có</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Ngày Live:</strong> {{ $stats['live_settings']->live_date->format('d/m/Y') }}</p>
                        <p><strong>Giờ Live:</strong> {{ $stats['live_settings']->live_time->format('H:i') }}</p>
                        <p><strong>Trạng thái:</strong> 
                            @if($stats['live_settings']->isAccessible())
                                <span class="badge bg-success">Có thể truy cập</span>
                            @else
                                <span class="badge bg-warning">Chưa đến giờ</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-12">
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-exclamation-triangle"></i> 
            Chưa có cài đặt live nào được kích hoạt. 
            <a href="{{ route('admin.live-settings.create') }}" class="btn btn-sm btn-primary ms-2">
                <i class="bi bi-plus"></i> Tạo mới
            </a>
        </div>
    </div>
</div>
@endif
@endsection
