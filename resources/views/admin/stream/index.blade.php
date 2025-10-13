@extends('layouts.app')

@section('title', 'Quản lý Livestream')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-video"></i>
                        Quản lý Livestream
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Trạng thái stream -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Trạng thái Stream</h5>
                                    <p class="card-text" id="stream-status">
                                        <span class="badge badge-secondary">Đang kiểm tra...</span>
                                    </p>
                                    <p class="card-text" id="stream-uptime"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success">
                                <div class="card-body">
                                    <h5 class="card-title">Cấu hình Stream</h5>
                                    <p class="card-text">
                                        <strong>URL:</strong> <span id="stream-url">{{ $liveSettings->stream_url ?? 'Chưa cấu hình' }}</span>
                                    </p>
                                    <button class="btn btn-sm btn-outline-light" onclick="testConnection()">
                                        <i class="fas fa-plug"></i> Test kết nối
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Control buttons -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <button class="btn btn-danger" onclick="stopStream()" id="stop-btn" disabled>
                                <i class="fas fa-stop"></i> Dừng Stream
                            </button>
                            <button class="btn btn-info" onclick="refreshStatus()">
                                <i class="fas fa-sync"></i> Làm mới
                            </button>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="streamTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="file-tab" data-toggle="tab" href="#file" role="tab">
                                <i class="fas fa-file-video"></i> Stream từ File
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="test-tab" data-toggle="tab" href="#test" role="tab">
                                <i class="fas fa-vial"></i> Test Stream
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="commands-tab" data-toggle="tab" href="#commands" role="tab">
                                <i class="fas fa-terminal"></i> Commands
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="streamTabsContent">
                        <!-- Stream từ file -->
                        <div class="tab-pane fade show active" id="file" role="tabpanel">
                            <div class="mt-3">
                                <form id="file-stream-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="video_file">Chọn file video</label>
                                                <input type="file" class="form-control-file" id="video_file" name="video_file" 
                                                       accept=".mp4,.avi,.mov,.mkv" required>
                                                <small class="form-text text-muted">
                                                    Hỗ trợ: MP4, AVI, MOV, MKV (tối đa 1GB)
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="quality">Chất lượng</label>
                                                <select class="form-control" id="quality" name="quality">
                                                    <option value="low">Thấp (640x480)</option>
                                                    <option value="medium" selected>Trung bình (1280x720)</option>
                                                    <option value="high">Cao (1920x1080)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="duration">Thời gian (giây)</label>
                                                <input type="number" class="form-control" id="duration" name="duration" 
                                                       min="1" max="3600" placeholder="Toàn bộ video">
                                                <small class="form-text text-muted">Để trống = toàn bộ video</small>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-play"></i> Bắt đầu Stream
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Test stream -->
                        <div class="tab-pane fade" id="test" role="tabpanel">
                            <div class="mt-3">
                                <form id="test-stream-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="test_duration">Thời gian test (giây)</label>
                                                <input type="number" class="form-control" id="test_duration" name="duration" 
                                                       min="10" max="3600" value="60" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="test_quality">Chất lượng</label>
                                                <select class="form-control" id="test_quality" name="quality">
                                                    <option value="low">Thấp (640x480)</option>
                                                    <option value="medium" selected>Trung bình (1280x720)</option>
                                                    <option value="high">Cao (1920x1080)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-play"></i> Bắt đầu Test
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        Test stream sẽ phát một pattern màu sắc và âm thanh test để kiểm tra kết nối.
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Commands -->
                        <div class="tab-pane fade" id="commands" role="tabpanel">
                            <div class="mt-3">
                                <h5>Lệnh FFmpeg để chạy trên server:</h5>
                                
                                <div class="mb-3">
                                    <h6>1. Stream từ file video:</h6>
                                    <div class="bg-dark text-light p-3 rounded">
                                        <code>
                                            ./scripts/ffmpeg_stream.sh -i /path/to/video.mp4 -q medium -d 300
                                        </code>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6>2. Test stream:</h6>
                                    <div class="bg-dark text-light p-3 rounded">
                                        <code>
                                            ./scripts/ffmpeg_stream.sh -t -d 60 -q medium
                                        </code>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6>3. Stream từ camera:</h6>
                                    <div class="bg-dark text-light p-3 rounded">
                                        <code>
                                            ./scripts/ffmpeg_stream.sh -c -q medium
                                        </code>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6>4. Screen capture:</h6>
                                    <div class="bg-dark text-light p-3 rounded">
                                        <code>
                                            ./scripts/ffmpeg_stream.sh -s -q medium -d 600
                                        </code>
                                    </div>
                                </div>

                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Lưu ý:</strong> Chạy các lệnh này trên production server. Script đã được tạo tại <code>scripts/ffmpeg_stream.sh</code>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal cho kết quả -->
<div class="modal fade" id="resultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kết quả</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Load trạng thái ban đầu
    refreshStatus();
    
    // Auto refresh mỗi 5 giây
    setInterval(refreshStatus, 5000);
    
    // Form submit handlers
    $('#file-stream-form').on('submit', function(e) {
        e.preventDefault();
        startFileStream();
    });
    
    $('#test-stream-form').on('submit', function(e) {
        e.preventDefault();
        startTestStream();
    });
});

function refreshStatus() {
    $.get('/admin/stream/status')
        .done(function(response) {
            updateStatusDisplay(response);
        })
        .fail(function() {
            $('#stream-status').html('<span class="badge badge-danger">Lỗi kết nối</span>');
        });
}

function updateStatusDisplay(response) {
    const statusElement = $('#stream-status');
    const uptimeElement = $('#stream-uptime');
    const stopBtn = $('#stop-btn');
    
    if (response.status === 'running') {
        statusElement.html('<span class="badge badge-success">Đang chạy</span>');
        uptimeElement.text('Thời gian chạy: ' + formatUptime(response.uptime));
        stopBtn.prop('disabled', false);
    } else {
        statusElement.html('<span class="badge badge-secondary">Đã dừng</span>');
        uptimeElement.text('');
        stopBtn.prop('disabled', true);
    }
}

function formatUptime(seconds) {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const secs = seconds % 60;
    
    return `${hours}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
}

function startFileStream() {
    const formData = new FormData($('#file-stream-form')[0]);
    
    $.ajax({
        url: '/admin/stream/start-file',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            showLoading('Đang bắt đầu stream...');
        },
        success: function(response) {
            hideLoading();
            if (response.success) {
                showModal('Thành công', response.message);
                refreshStatus();
            } else {
                showModal('Lỗi', response.message);
            }
        },
        error: function(xhr) {
            hideLoading();
            const response = xhr.responseJSON;
            showModal('Lỗi', response ? response.message : 'Có lỗi xảy ra');
        }
    });
}

function startTestStream() {
    const formData = $('#test-stream-form').serialize();
    
    $.ajax({
        url: '/admin/stream/start-test',
        type: 'POST',
        data: formData,
        beforeSend: function() {
            showLoading('Đang bắt đầu test stream...');
        },
        success: function(response) {
            hideLoading();
            if (response.success) {
                showModal('Thành công', response.message + '<br>Thời gian: ' + response.duration + ' giây');
                refreshStatus();
            } else {
                showModal('Lỗi', response.message);
            }
        },
        error: function(xhr) {
            hideLoading();
            const response = xhr.responseJSON;
            showModal('Lỗi', response ? response.message : 'Có lỗi xảy ra');
        }
    });
}

function stopStream() {
    if (!confirm('Bạn có chắc muốn dừng stream?')) {
        return;
    }
    
    $.ajax({
        url: '/admin/stream/stop',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            showLoading('Đang dừng stream...');
        },
        success: function(response) {
            hideLoading();
            if (response.success) {
                showModal('Thành công', response.message);
                refreshStatus();
            } else {
                showModal('Lỗi', response.message);
            }
        },
        error: function(xhr) {
            hideLoading();
            const response = xhr.responseJSON;
            showModal('Lỗi', response ? response.message : 'Có lỗi xảy ra');
        }
    });
}

function testConnection() {
    $.ajax({
        url: '/admin/stream/test-connection',
        type: 'GET',
        beforeSend: function() {
            showLoading('Đang test kết nối...');
        },
        success: function(response) {
            hideLoading();
            if (response.success) {
                const status = response.connection_status ? 'Thành công' : 'Thất bại';
                const message = `
                    <strong>Kết nối:</strong> ${status}<br>
                    <strong>Thông báo:</strong> ${response.connection_message}<br>
                    <strong>Host:</strong> ${response.host}<br>
                    <strong>Port:</strong> ${response.port}
                `;
                showModal('Kết quả Test Kết nối', message);
            } else {
                showModal('Lỗi', response.message);
            }
        },
        error: function(xhr) {
            hideLoading();
            const response = xhr.responseJSON;
            showModal('Lỗi', response ? response.message : 'Có lỗi xảy ra');
        }
    });
}

function showModal(title, message) {
    $('#resultModal .modal-title').text(title);
    $('#modal-body').html(message);
    $('#resultModal').modal('show');
}

function showLoading(message) {
    $('#modal-body').html('<i class="fas fa-spinner fa-spin"></i> ' + message);
    $('#resultModal .modal-title').text('Đang xử lý...');
    $('#resultModal').modal('show');
}

function hideLoading() {
    $('#resultModal').modal('hide');
}
</script>
@endsection
