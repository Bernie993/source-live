@extends('layouts.admin')

@section('title', 'Chi tiết Phản hồi')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chi tiết Phản hồi #{{ $feedback->id }}</h1>
        <a href="{{ route('admin.feedbacks.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin Phản hồi</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">ID</th>
                            <td>{{ $feedback->id }}</td>
                        </tr>
                        <tr>
                            <th>Thông tin đăng nhập</th>
                            <td><strong>{{ $feedback->login_info }}</strong></td>
                        </tr>
                        <tr>
                            <th>Loại phản hồi</th>
                            <td>{{ $feedback->feedback_type ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Nội dung</th>
                            <td>
                                <div style="white-space: pre-wrap;">{{ $feedback->content }}</div>
                            </td>
                        </tr>
                        <tr>
                            <th>Hình ảnh đính kèm</th>
                            <td>
                                @if($feedback->image)
                                    <a href="{{ asset('storage/' . $feedback->image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $feedback->image) }}" 
                                             alt="Feedback Image" 
                                             style="max-width: 100%; max-height: 400px; cursor: pointer;">
                                    </a>
                                @else
                                    <span class="text-muted">Không có hình ảnh</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Người gửi</th>
                            <td>
                                @if($feedback->user)
                                    {{ $feedback->user->name }} (ID: {{ $feedback->user->id }})
                                @else
                                    <span class="text-muted">Khách</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Ngày gửi</th>
                            <td>{{ $feedback->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Trạng thái</th>
                            <td>
                                @if($feedback->status == 'pending')
                                    <span class="badge badge-warning badge-lg">Chờ xử lý</span>
                                @elseif($feedback->status == 'processed')
                                    <span class="badge badge-success badge-lg">Đã xử lý</span>
                                @else
                                    <span class="badge badge-danger badge-lg">Từ chối</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thao tác</h6>
                </div>
                <div class="card-body">
                    <!-- Update Status -->
                    <div class="mb-3">
                        <label class="font-weight-bold">Cập nhật trạng thái:</label>
                        <form method="POST" action="{{ route('admin.feedbacks.updateStatus', $feedback) }}" class="mb-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn btn-warning btn-block" 
                                    {{ $feedback->status == 'pending' ? 'disabled' : '' }}>
                                <i class="fas fa-clock"></i> Chờ xử lý
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.feedbacks.updateStatus', $feedback) }}" class="mb-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="processed">
                            <button type="submit" class="btn btn-success btn-block"
                                    {{ $feedback->status == 'processed' ? 'disabled' : '' }}>
                                <i class="fas fa-check"></i> Đã xử lý
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.feedbacks.updateStatus', $feedback) }}" class="mb-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-secondary btn-block"
                                    {{ $feedback->status == 'rejected' ? 'disabled' : '' }}>
                                <i class="fas fa-times"></i> Từ chối
                            </button>
                        </form>
                    </div>

                    <hr>

                    <!-- Delete -->
                    <div class="mb-3">
                        <label class="font-weight-bold text-danger">Xóa phản hồi:</label>
                        <form method="POST" action="{{ route('admin.feedbacks.destroy', $feedback) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa phản hồi này? Hành động này không thể hoàn tác!')">
                                <i class="fas fa-trash"></i> Xóa phản hồi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge-lg {
        font-size: 14px;
        padding: 8px 12px;
    }
</style>
@endsection

