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

    <!-- Live Chat Interface -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-comment-dots"></i> Chat Trực Tiếp
                        <span id="chat-status-indicator" class="badge bg-secondary ms-2" style="display: none;">
                            <i class="fas fa-circle" style="font-size: 8px;"></i> Đang kết nối
                        </span>
                        <small id="message-counter" class="text-muted ms-2" style="font-size: 0.85em; display: none;">
                            (<span id="message-count">0</span> tin nhắn)
                        </small>
                    </h6>
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-control form-control-sm" id="chat-live-select" style="min-width: 250px;">
                            <option value="">-- Chọn phòng live để chat --</option>
                            @foreach($liveSettings as $live)
                                <option value="{{ $live->id }}">
                                    {{ $live->live_title }} 
                                    @if($live->live_date && $live->live_time)
                                        - {{ $live->live_date->format('d/m/Y') }} {{ $live->live_time->format('H:i') }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-secondary" id="toggle-chat-box" title="Thu gọn/Mở rộng">
                            <i class="fas fa-chevron-up"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" id="chat-box-content" style="display: block;">
                    <div class="row">
                        <div class="col-12">
                            <!-- Chat Messages Display -->
                            <div id="admin-chat-messages" style="height: 400px; overflow-y: auto; border: 1px solid #e3e6f0; border-radius: 5px; padding: 15px; background-color: #f8f9fc; margin-bottom: 15px;">
                                <div class="text-center text-muted" id="chat-placeholder">
                                    <i class="fas fa-comments fa-3x mb-3"></i>
                                    <p>Chọn phòng live để bắt đầu chat</p>
                                </div>
                            </div>
                            
                            <!-- Chat Input Form -->
                            <form id="admin-chat-form">
                                @csrf
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-control" 
                                           id="admin-chat-input" 
                                           placeholder="Chọn phòng live để chat..." 
                                           maxlength="500"
                                           disabled>
                                    <button class="btn btn-primary" type="submit" id="admin-chat-send-btn" disabled>
                                        <i class="fas fa-paper-plane"></i> Gửi
                                    </button>
                                </div>
                                <small class="form-text text-muted" id="chat-status-text">
                                    Chọn phòng live để bắt đầu chat
                                </small>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
<style>
    .chat-message {
        margin-bottom: 10px;
        padding: 8px 12px;
        border-radius: 8px;
        max-width: 80%;
        word-wrap: break-word;
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .chat-message.own-message {
        background-color: #4e73df;
        color: white;
        margin-left: auto;
        text-align: right;
    }
    
    .chat-message.other-message {
        background-color: #e3e6f0;
        color: #5a5c69;
    }
    
    .chat-message .message-username {
        font-weight: bold;
        font-size: 0.85em;
        margin-bottom: 3px;
    }
    
    .chat-message .message-content {
        font-size: 0.95em;
    }
    
    .chat-message .message-time {
        font-size: 0.75em;
        opacity: 0.8;
        margin-top: 3px;
    }
    
    .chat-message.own-message .message-username {
        color: #ffd700;
    }
    
    .chat-message.other-message .message-username {
        color: #4e73df;
    }
    
    #admin-chat-messages::-webkit-scrollbar {
        width: 8px;
    }
    
    #admin-chat-messages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    #admin-chat-messages::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    
    #admin-chat-messages::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

<script>
// Use global Echo instance (already initialized by Vite)
// Same as frontend - no need to create new Echo instance
// console.log('🔍 Checking Echo:', typeof Echo !== 'undefined' ? 'Echo is available ✅' : 'Echo is NOT available ❌');

$(document).ready(function() {
    let selectedLiveId = null;
    let echoChannel = null;
    let lastMessageId = 0;
    const currentUsername = '{{ Auth::user()->name ?? Auth::user()->account }}';
    
    // Auto-submit form when date inputs change
    $('#date_from, #date_to').on('change', function() {
        $(this).closest('form').submit();
    });
    
    // Toggle chat box
    $('#toggle-chat-box').on('click', function() {
        const content = $('#chat-box-content');
        const icon = $(this).find('i');
        
        if (content.is(':visible')) {
            content.slideUp();
            icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        } else {
            content.slideDown();
            icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        }
    });
    
    // Handle live room selection
    $('#chat-live-select').on('change', function() {
        selectedLiveId = $(this).val();
        
        if (selectedLiveId) {
            enableChat();
            loadChatMessages(selectedLiveId);
            setupRealtimeChat(selectedLiveId);
        } else {
            disableChat();
            clearChat();
        }
    });
    
    // Handle chat form submission
    $('#admin-chat-form').on('submit', function(e) {
        e.preventDefault();
        sendChatMessage();
    });
    
    // Enable enter key to send
    $('#admin-chat-input').on('keypress', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            sendChatMessage();
        }
    });
    
    function enableChat() {
        $('#admin-chat-input').prop('disabled', false).attr('placeholder', 'Nhập tin nhắn...');
        $('#admin-chat-send-btn').prop('disabled', false);
        $('#chat-status-text').text('Đã kết nối với phòng live. Bạn có thể chat ngay!').removeClass('text-muted').addClass('text-success');
        $('#chat-status-indicator').show().removeClass('bg-secondary').addClass('bg-success').html('<i class="fas fa-circle" style="font-size: 8px;"></i> Đã kết nối');
        $('#message-counter').show();
    }
    
    function disableChat() {
        $('#admin-chat-input').prop('disabled', true).attr('placeholder', 'Chọn phòng live để chat...').val('');
        $('#admin-chat-send-btn').prop('disabled', true);
        $('#chat-status-text').text('Chọn phòng live để bắt đầu chat').removeClass('text-success').addClass('text-muted');
        $('#chat-status-indicator').hide();
        $('#message-counter').hide();
        
        // Leave Echo channel
        if (echoChannel && typeof Echo !== 'undefined') {
            Echo.leave(echoChannel);
            echoChannel = null;
        }
    }
    
    function clearChat() {
        $('#admin-chat-messages').html(`
            <div class="text-center text-muted" id="chat-placeholder">
                <i class="fas fa-comments fa-3x mb-3"></i>
                <p>Chọn phòng live để bắt đầu chat</p>
            </div>
        `);
        lastMessageId = 0;
        updateMessageCounter();
    }
    
    function loadChatMessages(liveId) {
        $('#chat-placeholder').remove();
        $('#admin-chat-messages').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Đang tải tin nhắn...</div>');
        
        fetch(`/api/chat/messages?live_setting_id=${liveId}`)
            .then(response => response.json())
            .then(data => {
                $('#admin-chat-messages').empty();
                
                if (data.success && data.messages && data.messages.length > 0) {
                    data.messages.forEach(msg => {
                        addMessageToChat(msg);
                    });
                    scrollChatToBottom();
                } else {
                    $('#admin-chat-messages').html('<div class="text-center text-muted"><p>Chưa có tin nhắn nào trong phòng này</p></div>');
                    updateMessageCounter();
                }
            })
            .catch(error => {
                console.error('Error loading messages:', error);
                $('#admin-chat-messages').html('<div class="text-center text-danger"><p>Không thể tải tin nhắn. Vui lòng thử lại!</p></div>');
            });
    }
    
    function setupRealtimeChat(liveId) {
        if (typeof Echo === 'undefined') {
            console.warn('Echo is not available. Real-time chat will not work.');
            return;
        }
        
        // Leave previous channel if exists
        if (echoChannel) {
            Echo.leave(echoChannel);
        }
        
        // Listen to this specific live room's channel
        echoChannel = `live-chat.${liveId}`;
        
        Echo.channel(echoChannel)
            .listen('.new-message', function(data) {
                if (data.live_setting_id == liveId && data.id > lastMessageId) {
                    addMessageToChat(data);
                    scrollChatToBottom();
                    
                    // Play notification sound if message from others
                    if (data.username !== currentUsername) {
                        playNotificationSound();
                    }
                }
            });
        
        console.log('✅ Connected to chat channel:', echoChannel);
    }
    
    function sendChatMessage() {
        const input = $('#admin-chat-input');
        const message = input.val().trim();
        
        if (!message || !selectedLiveId) return;
        
        // Disable input while sending
        input.prop('disabled', true);
        $('#admin-chat-send-btn').prop('disabled', true);
        
        fetch('/api/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                message: message,
                live_setting_id: selectedLiveId
            })
        })
        .then(response => {
            if (response.status === 401) {
                alert('Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.');
                window.location.href = '/login';
                throw new Error('Unauthorized');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                input.val('');
                // Add the message immediately
                if (data.chat_message) {
                    addMessageToChat(data.chat_message);
                    scrollChatToBottom();
                }
            } else {
                alert(data.message || 'Có lỗi xảy ra khi gửi tin nhắn');
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
            if (error.message !== 'Unauthorized') {
                alert('Không thể gửi tin nhắn. Vui lòng thử lại!');
            }
        })
        .finally(() => {
            input.prop('disabled', false);
            $('#admin-chat-send-btn').prop('disabled', false);
            input.focus();
        });
    }
    
    function addMessageToChat(data) {
        // Remove placeholder if exists
        $('#chat-placeholder').remove();
        
        // Update last message ID
        if (data.id > lastMessageId) {
            lastMessageId = data.id;
        }
        
        const isOwnMessage = data.username === currentUsername;
        const messageClass = isOwnMessage ? 'own-message' : 'other-message';
        
        const messageTime = new Date(data.created_at || data.sent_at).toLocaleTimeString('vi-VN', {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        const messageHtml = `
            <div class="chat-message ${messageClass}">
                <div class="message-username">${data.username}</div>
                <div class="message-content">${escapeHtml(data.message)}</div>
                <div class="message-time">${messageTime}</div>
            </div>
        `;
        
        $('#admin-chat-messages').append(messageHtml);
        updateMessageCounter();
    }
    
    function updateMessageCounter() {
        const count = $('#admin-chat-messages .chat-message').length;
        $('#message-count').text(count);
    }
    
    function scrollChatToBottom() {
        const chatBox = document.getElementById('admin-chat-messages');
        if (chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function playNotificationSound() {
        // Simple beep notification
        try {
            const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiDYHGGS45+SeSwwMUKzn77FeBgU7ldf0yH4yBilzxvLaizsIGGy76+OaRQwPUKTh67RaFAlDo+L0wGcfBiaFzvTTgDMGGWi56+GZRgwOUKzp77RdGAg+mtn0wGwhBSh+zPLVhTYIG2W46eKbSAwOT6rl8LJfGgc+nNn0v2ofBSl+zO/WgzMHGmS56+GZRwsOUKvm8LBeFwo9mtj1v2weByhzxvDUgTUGGGa45eKcSgsPUKzo8LJeGQhAnNn0wGwfBSh+zO/VhDUHGmW56+KcSgwOUKro8LFfGgk9nNj1v2weBSeEzvTWgDYHF2e45eOcSwsOUKzo8LFeFgk+m9n1wG0fBSl+zO/WhTUHGWW55+OaTgsOUKzp8LJfGgk9m9j1wGwfBSh+zO/WhzUHGGW56+OaSgsOUKzp8LJfGgk9m9j1wG0fBSh9zO/XhDQHGWa56+OaSgsOUK3p8LFfGgk9m9j1wG0fBSiAzO/WhDQHGWW46+KaSgsOUKzp8LJfGgk+m9n1wGweBSh/zO/WgzQHGWa56+OaSgsOUKzp8LJfGQk9m9j1wG0fBSh+zO/WhDQHGWW46+KaSgsOUKzp8LJeGQk9m9j1wG0fBSh+zO/WhDQHGWW56+OaSgsOUKzp8LJeGQk9m9j1wG0fBSh+zO/WhDQHGWW56+OaSgsOUKzp8LFfGgk9m9j1wG0fBSh+zO/WhDQHGWW56+OaSgsOUKzp8LJfGgk9m9j1wG0fBSh+zO/WhDQHGWW56+OaSgsOUKzp8LJfGgk9m9j1wG0fBSh+zO/WhDQHGWW56+OaSgsOUKzp8LJfGgk9m9j1wG0fBSh+zO/WhDQHGWW56+OaSgsOUKzp8LJfGgk9m9j1wG0fBSh+zO/WhDQHGWW56+OaSgsOUKzp8LJfGgk9m9j1wG0fBSh+zO/WhDQHGWW56+OaSgsOUKzp8LJfGgk9m9j1wG0fBSh+zO/WhDQHGWW56+OaSgsOUKzp8LJfGgk9m9j1wG0fBSh+zO/WhA==');
            audio.volume = 0.3;
            audio.play().catch(() => {});
        } catch (e) {
            // Ignore if audio fails
        }
    }

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
