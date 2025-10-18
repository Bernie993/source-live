@extends('layouts.admin')

@section('title', 'Cài đặt Chat')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cài đặt Chat</h1>
        <div>
            <a href="{{ route('admin.chat.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại Quản lý Chat
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Settings Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-cog"></i> Cấu hình giới hạn gửi tin nhắn
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.chat.settings.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- Enable/Disable Throttle -->
                        <div class="mb-4">
                            <label class="form-label">
                                <strong>Trạng thái:</strong>
                            </label>
                            <div class="form-check form-switch">
                                <!-- Hidden input để đảm bảo luôn có giá trị khi checkbox unchecked -->
                                <input type="hidden" name="throttle_enabled" value="0">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       role="switch" 
                                       id="throttle_enabled" 
                                       name="throttle_enabled" 
                                       value="1"
                                       {{ ($settings['throttle_enabled']->value ?? true) ? 'checked' : '' }}
                                       onchange="toggleThrottleSettings(this)">
                                <label class="form-check-label" for="throttle_enabled">
                                    <span id="throttle_status_text">
                                        {{ ($settings['throttle_enabled']->value ?? true) ? 'Đang bật' : 'Đang tắt' }}
                                    </span>
                                    - Giới hạn thời gian giữa các tin nhắn
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Khi bật, người dùng phải chờ một khoảng thời gian trước khi gửi tin nhắn tiếp theo
                            </small>
                        </div>

                        <!-- Throttle Seconds -->
                        <div class="mb-4" id="throttle_seconds_group">
                            <label for="message_throttle_seconds" class="form-label">
                                <strong>Thời gian chờ giữa các tin nhắn (giây):</strong>
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="number" 
                                           class="form-control form-control-lg" 
                                           id="message_throttle_seconds" 
                                           name="message_throttle_seconds" 
                                           value="{{ $settings['message_throttle_seconds']->value ?? 10 }}"
                                           min="0" 
                                           max="300"
                                           required
                                           oninput="updatePreview(this.value)">
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <div class="alert alert-info mb-0 w-100">
                                        <i class="fas fa-clock"></i> 
                                        <strong id="preview_text">
                                            Người dùng phải chờ {{ $settings['message_throttle_seconds']->value ?? 10 }} giây
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Giá trị từ 0 đến 300 giây (5 phút). Khuyến nghị: 5-15 giây
                            </small>
                        </div>

                        <!-- Example Display -->
                        <div class="mb-4">
                            <label class="form-label">
                                <strong>Ví dụ:</strong>
                            </label>
                            <div class="border rounded p-3 bg-light">
                                <div class="d-flex align-items-start mb-2">
                                    <div class="badge bg-primary me-2">User123</div>
                                    <div>
                                        <div class="bg-white rounded p-2 border">Tin nhắn 1</div>
                                        <small class="text-muted">14:30:00</small>
                                    </div>
                                </div>
                                <div class="text-center text-muted my-2">
                                    <i class="fas fa-arrow-down"></i> 
                                    <span id="wait_time_text">Chờ {{ $settings['message_throttle_seconds']->value ?? 10 }} giây</span>
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                                <div class="d-flex align-items-start">
                                    <div class="badge bg-primary me-2">User123</div>
                                    <div>
                                        <div class="bg-white rounded p-2 border">Tin nhắn 2</div>
                                        <small class="text-muted">14:30:<span id="seconds_text">{{ str_pad($settings['message_throttle_seconds']->value ?? 10, 2, '0', STR_PAD_LEFT) }}</span></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recommendations -->
                        <div class="alert alert-warning">
                            <h6 class="alert-heading">
                                <i class="fas fa-lightbulb"></i> Khuyến nghị:
                            </h6>
                            <ul class="mb-0">
                                <li><strong>0 giây:</strong> Không giới hạn (có thể gây spam)</li>
                                <li><strong>3-5 giây:</strong> Chat nhanh, phù hợp với live chat sôi động</li>
                                <li><strong>10-15 giây:</strong> Cân bằng giữa chống spam và trải nghiệm người dùng</li>
                                <li><strong>30-60 giây:</strong> Chat chậm, phù hợp với Q&A hoặc chat quan trọng</li>
                                <li><strong>120+ giây:</strong> Rất chặt, chỉ dùng cho trường hợp đặc biệt</li>
                            </ul>
                        </div>

                        <hr class="my-5">

                        <!-- Block Links Setting -->
                        <div class="mb-4">
                            <label class="form-label">
                                <strong>Chặn gửi link:</strong>
                            </label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="block_links_enabled" value="0">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       role="switch" 
                                       id="block_links_enabled" 
                                       name="block_links_enabled" 
                                       value="1"
                                       {{ ($settings['block_links_enabled']->value ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="block_links_enabled">
                                    {{ ($settings['block_links_enabled']->value ?? true) ? 'Đang bật' : 'Đang tắt' }} - Chặn người dùng gửi link/URL
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Khi bật, người dùng thường không thể gửi tin nhắn chứa link. Admin và Nhân viên Live vẫn có thể gửi link.
                            </small>
                        </div>

                        <hr class="my-5">

                        <!-- Max Message Length Setting -->
                        <div class="mb-4">
                            <label for="max_message_length" class="form-label">
                                <strong>Giới hạn số ký tự tin nhắn:</strong>
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="number" 
                                           class="form-control form-control-lg" 
                                           id="max_message_length" 
                                           name="max_message_length" 
                                           value="{{ $settings['max_message_length']->value ?? 200 }}"
                                           min="50" 
                                           max="1000"
                                           required
                                           oninput="updateLengthPreview(this.value)">
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <div class="alert alert-info mb-0 w-100">
                                        <i class="fas fa-text-width"></i> 
                                        <strong id="length_preview_text">
                                            Giới hạn: {{ $settings['max_message_length']->value ?? 200 }} ký tự
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Số ký tự tối đa cho mỗi tin nhắn. Giá trị từ 50 đến 1000 ký tự. Admin và Nhân viên Live không bị giới hạn.
                            </small>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Lưu cài đặt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Thông tin
                    </h6>
                </div>
                <div class="card-body">
                    <h6 class="font-weight-bold">Giới hạn gửi tin nhắn là gì?</h6>
                    <p class="small text-muted">
                        Đây là tính năng giúp kiểm soát tốc độ gửi tin nhắn của người dùng. 
                        Khi được bật, mỗi người dùng phải chờ một khoảng thời gian nhất định 
                        trước khi có thể gửi tin nhắn tiếp theo.
                    </p>

                    <hr>

                    <h6 class="font-weight-bold">Lợi ích:</h6>
                    <ul class="small text-muted">
                        <li>Chống spam tin nhắn</li>
                        <li>Giữ chat room gọn gàng và dễ theo dõi</li>
                        <li>Giảm tải cho server</li>
                        <li>Khuyến khích người dùng suy nghĩ trước khi gửi</li>
                    </ul>

                    <hr>

                    <h6 class="font-weight-bold">Áp dụng cho:</h6>
                    <ul class="small text-muted">
                        <li><i class="fas fa-check text-success"></i> Tất cả người dùng thường</li>
                        <li><i class="fas fa-check text-success"></i> Người dùng khách</li>
                        <li><i class="fas fa-times text-danger"></i> Admin (không bị giới hạn)</li>
                        <li><i class="fas fa-times text-danger"></i> Nhân viên Live (không bị giới hạn)</li>
                    </ul>

                    <hr>

                    <div class="alert alert-info mb-0">
                        <small>
                            <i class="fas fa-shield-alt"></i> 
                            <strong>Bảo mật:</strong> Admin và Nhân viên Live không bị ảnh hưởng 
                            bởi giới hạn này để có thể phản hồi nhanh chóng.
                        </small>
                    </div>
                </div>
            </div>

            <!-- Current Settings -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-check-circle"></i> Cài đặt hiện tại
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <div class="h2 text-{{ ($settings['throttle_enabled']->value ?? true) ? 'success' : 'secondary' }}">
                                    <i class="fas fa-{{ ($settings['throttle_enabled']->value ?? true) ? 'toggle-on' : 'toggle-off' }}"></i>
                                </div>
                                <div class="text-xs text-uppercase text-muted">Trạng thái</div>
                                <div class="small font-weight-bold">
                                    {{ ($settings['throttle_enabled']->value ?? true) ? 'Đang bật' : 'Đang tắt' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="h2 text-primary">
                                {{ $settings['message_throttle_seconds']->value ?? 10 }}s
                            </div>
                            <div class="text-xs text-uppercase text-muted">Thời gian chờ</div>
                            <div class="small font-weight-bold">giữa tin nhắn</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updatePreview(seconds) {
    document.getElementById('preview_text').textContent = `Người dùng phải chờ ${seconds} giây`;
    document.getElementById('wait_time_text').textContent = `Chờ ${seconds} giây`;
    document.getElementById('seconds_text').textContent = String(seconds).padStart(2, '0');
}

function updateLengthPreview(length) {
    document.getElementById('length_preview_text').textContent = `Giới hạn: ${length} ký tự`;
}

function toggleThrottleSettings(checkbox) {
    const throttleGroup = document.getElementById('throttle_seconds_group');
    const statusText = document.getElementById('throttle_status_text');
    
    if (checkbox.checked) {
        throttleGroup.style.opacity = '1';
        throttleGroup.querySelector('input').disabled = false;
        statusText.textContent = 'Đang bật';
    } else {
        throttleGroup.style.opacity = '0.5';
        throttleGroup.querySelector('input').disabled = true;
        statusText.textContent = 'Đang tắt';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('throttle_enabled');
    if (!checkbox.checked) {
        toggleThrottleSettings(checkbox);
    }
});
</script>
@endsection

