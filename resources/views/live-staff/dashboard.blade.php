@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="bi bi-broadcast"></i> Dashboard Nhân viên Live
        </h1>
    </div>
</div>

<!-- Live Access Section -->
@if($liveSetting)
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow border-left-primary">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-broadcast"></i> Thông tin Live hiện tại
                </h6>
                @if($liveSetting->isAccessible())
                    <span class="badge bg-success fs-6">Có thể truy cập</span>
                @else
                    <span class="badge bg-warning fs-6">Chưa đến giờ</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Ngày Live:</strong> {{ $liveSetting->live_date->format('d/m/Y') }}</p>
                        <p><strong>Giờ Live:</strong> {{ $liveSetting->live_time->format('H:i') }}</p>
                        <p><strong>Thời gian truy cập:</strong> {{ $liveSetting->live_date->setTimeFromTimeString($liveSetting->live_time->format('H:i:s'))->subMinutes(30)->format('H:i d/m/Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        @if($liveSetting->isAccessible())
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary btn-lg" onclick="copyStreamUrl('{{ $liveSetting->live_url }}')">
                                    <i class="bi bi-link-45deg"></i> <span id="copyBtnText">Link OBS/Stream</span>
                                </button>
                                <a href="{{ route('live.room', $liveSetting->id) }}" target="_blank" class="btn btn-success btn-lg">
                                    <i class="bi bi-play-circle"></i> Vào Phòng Live
                                </a>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-clock"></i> 
                                Bạn chỉ có thể truy cập link live trước 30 phút. 
                                Vui lòng đợi đến {{ $liveSetting->live_date->setTimeFromTimeString($liveSetting->live_time->format('H:i:s'))->subMinutes(30)->format('H:i d/m/Y') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle"></i> 
            Hiện tại chưa có lịch live nào được kích hoạt. Vui lòng liên hệ Admin để cài đặt.
        </div>
    </div>
</div>
@endif

<!-- Statistics Cards -->
<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Tổng tin nhắn
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_chat_messages'] ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-chat-dots fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Tin nhắn bị chặn
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['blocked_messages'] ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-shield-x fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Live hôm nay
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            @if($liveSetting)
                                <i class="bi bi-check-circle"></i> Đã cài đặt
                            @else
                                <i class="bi bi-x-circle"></i> Chưa có
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-broadcast fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-lightning"></i> Thao tác nhanh
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('live-staff.chat.index') }}" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-chat-dots"></i> Quản lý Chat
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        @if($liveSetting && $liveSetting->isAccessible())
                            <a href="{{ route('live.room', $liveSetting->id) }}" target="_blank" class="btn btn-success btn-lg w-100">
                                <i class="bi bi-broadcast"></i> Vào phòng Live
                            </a>
                        @else
                            <button class="btn btn-secondary btn-lg w-100" disabled>
                                <i class="bi bi-broadcast"></i> Chưa đến giờ Live
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyStreamUrl(url) {
        // Use Clipboard API if available
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(function() {
                // Success
                const btnText = document.getElementById('copyBtnText');
                const originalText = btnText.innerHTML;
                btnText.innerHTML = 'Đã Copy!';
                btnText.parentElement.classList.add('btn-success');
                btnText.parentElement.classList.remove('btn-primary');
                
                setTimeout(function() {
                    btnText.innerHTML = originalText;
                    btnText.parentElement.classList.remove('btn-success');
                    btnText.parentElement.classList.add('btn-primary');
                }, 2000);
            }).catch(function(err) {
                alert('Không thể copy link. Vui lòng thử lại!');
            });
        } else {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = url;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            
            try {
                document.execCommand('copy');
                const btnText = document.getElementById('copyBtnText');
                const originalText = btnText.innerHTML;
                btnText.innerHTML = 'Đã Copy!';
                btnText.parentElement.classList.add('btn-success');
                btnText.parentElement.classList.remove('btn-primary');
                
                setTimeout(function() {
                    btnText.innerHTML = originalText;
                    btnText.parentElement.classList.remove('btn-success');
                    btnText.parentElement.classList.add('btn-primary');
                }, 2000);
            } catch (err) {
                alert('Không thể copy link. Vui lòng thử lại!');
            }
            
            document.body.removeChild(textArea);
        }
    }
</script>
@endsection
