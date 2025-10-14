@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-pencil"></i> Sửa User: {{ $user->name }}
            </h1>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger email-required">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}">
                                <small class="form-text text-muted">Email không bắt buộc với External Login</small>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                <small class="form-text text-muted">Để trống nếu không muốn thay đổi mật khẩu</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_type" class="form-label">Loại User <span class="text-danger">*</span></label>
                                <select class="form-select @error('user_type') is-invalid @enderror" 
                                        id="user_type" name="user_type" required>
                                    <option value="">Chọn loại user</option>
                                    <option value="admin_created" {{ old('user_type', $user->user_type) === 'admin_created' ? 'selected' : '' }}>Admin Created</option>
                                    <option value="external_login" {{ old('user_type', $user->user_type) === 'external_login' ? 'selected' : '' }}>External Login</option>
                                </select>
                                @error('user_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="roles" class="form-label">Vai trò <span class="text-danger">*</span></label>
                                <select class="form-select @error('roles') is-invalid @enderror" 
                                        id="roles" name="roles[]" multiple required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" 
                                                {{ in_array($role->name, old('roles', $user->roles->pluck('name')->toArray())) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Giữ Ctrl để chọn nhiều vai trò</small>
                                @error('roles')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="account" class="form-label">Tài khoản</label>
                                <input type="text" class="form-control @error('account') is-invalid @enderror" 
                                       id="account" name="account" value="{{ old('account', $user->account) }}">
                                @error('account')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="bank_account" class="form-label">Tài khoản ngân hàng</label>
                                <input type="text" class="form-control @error('bank_account') is-invalid @enderror" 
                                       id="bank_account" name="bank_account" value="{{ old('bank_account', $user->bank_account) }}">
                                @error('bank_account')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="platform" class="form-label">Platform</label>
                                <input type="text" class="form-control @error('platform') is-invalid @enderror" 
                                       id="platform" name="platform" value="{{ old('platform', $user->platform) }}">
                                @error('platform')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">Hủy</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> Cập nhật User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Information Card -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-info-circle"></i> Thông tin User
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $user->id }}</p>
                        <p><strong>Ngày tạo:</strong> {{ $user->created_at->format('d/m/Y H:i:s') }}</p>
                        <p><strong>Cập nhật lần cuối:</strong> {{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Vai trò hiện tại:</strong> 
                            @foreach($user->roles as $role)
                                @php
                                    $badgeClass = match($role->name) {
                                        'Admin' => 'bg-danger',
                                        'Nhân viên Live' => 'bg-info',
                                        'CSKH' => 'bg-warning',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $role->name }}</span>
                            @endforeach
                        </p>
                        <p><strong>Từ khóa đã tạo:</strong> {{ $user->keywords()->count() }} từ khóa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userTypeSelect = document.getElementById('user_type');
    const emailInput = document.getElementById('email');
    const emailRequired = document.querySelector('.email-required');
    
    function toggleEmailRequired() {
        const isExternalLogin = userTypeSelect.value === 'external_login';
        const isAdminCreated = userTypeSelect.value === 'admin_created';
        
        if (isExternalLogin) {
            emailInput.removeAttribute('required');
            if (emailRequired) emailRequired.style.display = 'none';
        } else if (isAdminCreated) {
            emailInput.removeAttribute('required'); // Admin created cũng không bắt buộc email
            if (emailRequired) emailRequired.style.display = 'none';
        } else {
            emailInput.setAttribute('required', 'required');
            if (emailRequired) emailRequired.style.display = 'inline';
        }
    }
    
    // Initial check
    toggleEmailRequired();
    
    // Listen for changes
    userTypeSelect.addEventListener('change', toggleEmailRequired);
});
</script>
@endpush
@endsection
