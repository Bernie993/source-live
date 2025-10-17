@extends('layouts.admin')

@section('title', 'Quản lý Chat')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý Chat</h1>
        <div>
            @if(Auth::user()->hasRole('Nhân viên Live'))
                <a href="{{ route('live-staff.chat.export', request()->query()) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel"></i> Xuất Excel (Từ lúc bắt đầu Live)
                </a>
            @else
                <a href="{{ route('admin.chat.export', request()->query()) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel"></i> Xuất Excel
                </a>
            @endif
        </div>
    </div>

    @if(Auth::user()->hasRole('Nhân viên Live'))
    <!-- Info for Live Staff -->
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle"></i> 
        <strong>Lưu ý:</strong> Khi xuất Excel, bạn chỉ có thể xuất tin nhắn từ thời điểm bắt đầu live stream đến hiện tại. 
        Vui lòng chọn phòng live trước khi xuất file.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng tin nhắn
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_messages'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tin nhắn hoạt động
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_messages'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                            <i class="fas fa-ban fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Người dùng duy nhất
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['unique_users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bộ lọc</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.chat.index') }}">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="live_setting_id">
                                <i class="fas fa-broadcast-tower"></i> Phòng Live Stream:
                            </label>
                            <select class="form-control" id="live_setting_id" name="live_setting_id">
                                <option value="">-- Tất cả phòng live --</option>
                                @foreach($liveSettings as $live)
                                    <option value="{{ $live->id }}" 
                                            {{ request('live_setting_id') == $live->id ? 'selected' : '' }}>
                                        {{ $live->live_title }} 
                                        @if($live->live_date && $live->live_time)
                                            - {{ $live->live_date->format('d/m/Y') }} {{ $live->live_time->format('H:i') }}
                                        @endif
                                        @if($live->assignedUser)
                                            (Host: {{ $live->assignedUser->name }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                @if(Auth::user()->hasRole('Nhân viên Live'))
                                    <i class="fas fa-info-circle"></i> Bạn chỉ thấy chat từ các phòng live được giao cho bạn
                                @else
                                    <i class="fas fa-info-circle"></i> Admin có thể xem tất cả chat từ mọi phòng live
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_from">Từ ngày:</label>
                            <input type="date" class="form-control" id="date_from" name="date_from"
                                   value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_to">Đến ngày:</label>
                            <input type="date" class="form-control" id="date_to" name="date_to"
                                   value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Trạng thái:</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Tất cả</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Bị chặn</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="username">Tên người dùng:</label>
                            <input type="text" class="form-control" id="username" name="username"
                                   value="{{ request('username') }}" placeholder="Tìm theo tên...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sort_by">Sắp xếp theo:</label>
                            <select class="form-control" id="sort_by" name="sort_by">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                                <option value="username" {{ request('sort_by') == 'username' ? 'selected' : '' }}>Tên người dùng</option>
                                <option value="is_blocked" {{ request('sort_by') == 'is_blocked' ? 'selected' : '' }}>Trạng thái</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sort_order">Thứ tự:</label>
                            <select class="form-control" id="sort_order" name="sort_order">
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Lọc
                    </button>
                    <a href="{{ route('admin.chat.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Xóa bộ lọc
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách tin nhắn</h6>
        </div>
        <div class="card-body">
            @if($messages->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Phòng Live</th>
                                <th>Tên người dùng</th>
                                <th>Nội dung</th>
                                <th>Trạng thái</th>
                                <th>Thời gian gửi</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $message)
                            <tr>
                                <td>{{ $message->id }}</td>
                                <td>
                                    @if($message->liveSetting)
                                        <span class="badge badge-info">
                                            <i class="fas fa-broadcast-tower"></i>
                                            {{ Str::limit($message->liveSetting->live_title, 30) }}
                                        </span>
                                        @if($message->liveSetting->live_date)
                                            <br><small class="text-muted">
                                                {{ $message->liveSetting->live_date->format('d/m/Y') }}
                                                @if($message->liveSetting->live_time)
                                                    {{ $message->liveSetting->live_time->format('H:i') }}
                                                @endif
                                            </small>
                                        @endif
                                    @else
                                        <span class="badge badge-secondary">Chưa xác định</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $message->username }}</strong>
                                </td>
                                <td>
                                    <div style="max-width: 300px; word-wrap: break-word;">
                                        {{ Str::limit($message->message, 100) }}
                                    </div>
                                </td>
                                <td>
                                    @if($message->is_blocked)
                                        <span class="badge badge-danger">Bị chặn</span>
                                        @if($message->blocked_keywords)
                                            <br><small class="text-muted">
                                                Từ khóa: {{ implode(', ', $message->blocked_keywords) }}
                                            </small>
                                        @endif
                                    @else
                                        <span class="badge badge-success">Hoạt động</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $message->sent_at ? $message->sent_at->format('d/m/Y H:i:s') : ($message->created_at ? $message->created_at->format('d/m/Y H:i:s') : 'N/A') }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.chat.show', $message) }}"
                                           class="btn btn-info btn-sm" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.chat.toggle-block', $message) }}"
                                              style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm"
                                                    title="{{ $message->is_blocked ? 'Bỏ chặn' : 'Chặn' }}"
                                                    onclick="return confirm('Bạn có chắc chắn muốn {{ $message->is_blocked ? 'bỏ chặn' : 'chặn' }} tin nhắn này?')">
                                                <i class="fas fa-{{ $message->is_blocked ? 'unlock' : 'ban' }}"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.chat.destroy', $message) }}"
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Xóa"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa tin nhắn này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $messages->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-comments fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Không có tin nhắn nào</h5>
                    <p class="text-gray-500">Chưa có tin nhắn chat nào phù hợp với bộ lọc của bạn.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Use global Echo instance (already initialized by Vite)
// Same as frontend - no need to create new Echo instance
// console.log('🔍 Checking Echo:', typeof Echo !== 'undefined' ? 'Echo is available ✅' : 'Echo is NOT available ❌');

$(document).ready(function() {
    // Auto-submit form when date inputs change
    $('#date_from, #date_to').on('change', function() {
        $(this).closest('form').submit();
    });

    // Listen for new chat messages using global Echo (same as frontend)
    if (typeof Echo !== 'undefined') {
        try {
            //console.log('🔌 Setting up realtime chat listener...');

            Echo.channel('live-chat')
                .listen('.new-message', function(data) {
                    // console.log('📨 New message received in admin:', data);

                    // Update statistics
                    updateStatistics();

                    // Add new message to table (if not filtered or matches current filter)
                    if (!isFiltered() || matchesCurrentFilter(data)) {
                        addNewMessageToTable(data);
                    }

                    // Show notification
                    showNotification('Có tin nhắn mới từ ' + data.username);
                });

            // console.log('✅ Realtime chat listener ready!');
        } catch (error) {
            console.error('❌ Error setting up realtime listener:', error);
        }
    } else {
        console.warn('⚠️ Echo is not available. Realtime features will not work.');
        console.warn('💡 Make sure @@vite is loaded in admin layout.');
    }

    // Update statistics
    function updateStatistics() {
        // Auto-detect current route prefix (admin or live-staff)
        const currentPath = window.location.pathname;
        const statsUrl = currentPath.includes('/live-staff/')
            ? '{{ route('live-staff.chat.stats') }}'
            : '{{ route('admin.chat.stats') }}';

        // Reload statistics without refreshing page
        fetch(statsUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Stats API returned ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.stats) {
                    // Try to update stat numbers (may not exist in all layouts)
                    try {
                        const stats = data.stats;
                        $('.text-primary').closest('.card-body').find('.h5').text(stats.total_messages || 0);
                        $('.text-success').closest('.card-body').find('.h5').text(stats.active_messages || 0);
                        $('.text-danger').closest('.card-body').find('.h5').text(stats.blocked_messages || 0);
                        $('.text-info').closest('.card-body').find('.h5').text(stats.unique_users || 0);
                        // console.log('📊 Statistics updated');
                    } catch (e) {
                        console.warn('Could not update stat cards:', e.message);
                    }
                }
            })
            .catch(error => {
                console.warn('⚠️ Could not fetch statistics:', error.message);
                // Don't show error to user, it's not critical
            });
    }

    // Check if there are active filters
    function isFiltered() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.has('date_from') || urlParams.has('date_to') ||
               urlParams.has('status') || urlParams.has('username') ||
               urlParams.has('live_setting_id');
    }

    // Check if message matches current filter
    function matchesCurrentFilter(data) {
        const urlParams = new URLSearchParams(window.location.search);
        
        // Check live_setting_id filter
        if (urlParams.has('live_setting_id')) {
            const filterLiveId = urlParams.get('live_setting_id');
            if (filterLiveId && data.live_setting_id != filterLiveId) {
                return false;
            }
        }
        
        // Check status filter
        if (urlParams.has('status')) {
            const statusFilter = urlParams.get('status');
            if (statusFilter === 'blocked' && !data.is_blocked) return false;
            if (statusFilter === 'active' && data.is_blocked) return false;
        }
        
        // Check username filter
        if (urlParams.has('username')) {
            const usernameFilter = urlParams.get('username').toLowerCase();
            if (!data.username || !data.username.toLowerCase().includes(usernameFilter)) {
                return false;
            }
        }
        
        return true;
    }

    // Add new message to table
    function addNewMessageToTable(data) {
        const tbody = $('#dataTable tbody');

        // Check if empty state exists
        const emptyState = $('.text-center.py-4');
        if (emptyState.length > 0) {
            // Reload page if empty state exists
            location.reload();
            return;
        }

        // Format date
        const now = new Date();
        const formattedDate = now.toLocaleDateString('vi-VN') + ' ' +
                            now.toLocaleTimeString('vi-VN');

        // Create status badge
        const statusBadge = data.is_blocked
            ? '<span class="badge badge-danger">Bị chặn</span>'
            : '<span class="badge badge-success">Hoạt động</span>';

        // Create live setting badge
        const liveSettingBadge = data.live_setting_id
            ? '<span class="badge badge-info"><i class="fas fa-broadcast-tower"></i> Live #' + data.live_setting_id + '</span>'
            : '<span class="badge badge-secondary">Chưa xác định</span>';

        // Create new row
        const newRow = `
            <tr class="new-message-row" data-id="${data.id}">
                <td>${data.id}</td>
                <td>${liveSettingBadge}</td>
                <td><strong>${data.username}</strong></td>
                <td>
                    <div style="max-width: 300px; word-wrap: break-word;">
                        ${data.message.substring(0, 100)}${data.message.length > 100 ? '...' : ''}
                    </div>
                </td>
                <td>${statusBadge}</td>
                <td>${formattedDate}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="/admin/chat/${data.id}" class="btn btn-info btn-sm" title="Xem chi tiết">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form method="POST" action="/admin/chat/${data.id}/toggle-block" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm" title="${data.is_blocked ? 'Bỏ chặn' : 'Chặn'}">
                                <i class="fas fa-${data.is_blocked ? 'unlock' : 'ban'}"></i>
                            </button>
                        </form>
                        <form method="POST" action="/admin/chat/${data.id}" style="display: inline;">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm" title="Xóa"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa tin nhắn này?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        `;

        // Add to top of table with animation
        tbody.prepend(newRow);
        $('.new-message-row').addClass('table-success').delay(3000).queue(function() {
            $(this).removeClass('table-success').dequeue();
        });
    }

    // Show notification
    function showNotification(message) {
        // Check if browser supports notifications
        if (!("Notification" in window)) {
            return;
        }

        // Check if permission is granted
        if (Notification.permission === "granted") {
            new Notification("Quản lý Chat", {
                body: message,
                icon: '/favicon.ico'
            });
        } else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(function (permission) {
                if (permission === "granted") {
                    new Notification("Quản lý Chat", {
                        body: message,
                        icon: '/favicon.ico'
                    });
                }
            });
        }

        // Also show in-page toast notification
        showToast(message);
    }

    // Show toast notification
    function showToast(message) {
        const toast = $(`
            <div class="alert alert-info alert-dismissible fade show" role="alert"
                 style="position: fixed; top: 70px; right: 20px; z-index: 9999; min-width: 300px;">
                <strong><i class="fas fa-bell"></i> Thông báo:</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `);

        $('body').append(toast);

        setTimeout(function() {
            toast.fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }
});
</script>
@endpush
