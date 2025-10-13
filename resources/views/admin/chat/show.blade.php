@extends('layouts.admin')

@section('title', 'Chi tiết tin nhắn')

@section('content')
@if(!$message)
    <div class="container-fluid">
        <div class="alert alert-danger">
            <h4>Lỗi</h4>
            <p>Tin nhắn không tồn tại hoặc đã bị xóa.</p>
            <a href="{{ route('admin.chat.index') }}" class="btn btn-primary">Quay lại danh sách</a>
        </div>
    </div>
@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chi tiết tin nhắn</h1>
        <div>
            <a href="{{ route('admin.chat.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Message Details -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin tin nhắn</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>ID:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $message->id }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Tên người dùng:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="badge badge-primary">{{ $message->username }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Nội dung tin nhắn:</strong>
                        </div>
                        <div class="col-sm-9">
                            <div class="border p-3 bg-light rounded">
                                {{ $message->message }}
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Trạng thái:</strong>
                        </div>
                        <div class="col-sm-9">
                            @if($message->is_blocked)
                                <span class="badge badge-danger">Bị chặn</span>
                            @else
                                <span class="badge badge-success">Hoạt động</span>
                            @endif
                        </div>
                    </div>

                    @if($message->is_blocked && $message->blocked_keywords)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Từ khóa bị chặn:</strong>
                        </div>
                        <div class="col-sm-9">
                            @foreach($message->blocked_keywords as $keyword)
                                <span class="badge badge-warning mr-1">{{ $keyword }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Thời gian gửi:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $message->sent_at ? $message->sent_at->format('d/m/Y H:i:s') : 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Ngày tạo:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $message->created_at ? $message->created_at->format('d/m/Y H:i:s') : 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Ngày cập nhật:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $message->updated_at ? $message->updated_at->format('d/m/Y H:i:s') : 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thao tác</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <form method="POST" action="{{ route('admin.chat.toggle-block', $message) }}">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-block" 
                                    onclick="return confirm('Bạn có chắc chắn muốn {{ $message->is_blocked ? 'bỏ chặn' : 'chặn' }} tin nhắn này?')">
                                <i class="fas fa-{{ $message->is_blocked ? 'unlock' : 'ban' }}"></i>
                                {{ $message->is_blocked ? 'Bỏ chặn tin nhắn' : 'Chặn tin nhắn' }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.chat.destroy', $message) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" 
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa tin nhắn này? Hành động này không thể hoàn tác!')">
                                <i class="fas fa-trash"></i>
                                Xóa tin nhắn
                            </button>
                        </form>

                        <a href="{{ route('admin.chat.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i>
                            Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>

            <!-- Message Statistics -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-right">
                                <div class="h4 text-primary">{{ $message->id }}</div>
                                <div class="text-xs text-uppercase text-muted">ID Tin nhắn</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="h4 text-{{ $message->is_blocked ? 'danger' : 'success' }}">
                                {{ $message->is_blocked ? 'Bị chặn' : 'Hoạt động' }}
                            </div>
                            <div class="text-xs text-uppercase text-muted">Trạng thái</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
