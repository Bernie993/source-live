<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Đăng Nhập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="j88-logo">J88</div>
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="accountName" class="form-label">Tên tài khoản</label>
                        <input type="text" class="form-control" id="accountName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">4 số cuối tài khoản ngân hàng</label>
                        <div class="bank-account-inputs">
                            <input type="text" class="bank-digit" maxlength="1" required>
                            <input type="text" class="bank-digit" maxlength="1" required>
                            <input type="text" class="bank-digit" maxlength="1" required>
                            <input type="text" class="bank-digit" maxlength="1" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-confirm">
                        <span class="btn-text">Xác Nhận</span>
                        <span class="loading">
                            <i class="fas fa-spinner fa-spin"></i> Đang xử lý...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


