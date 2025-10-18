<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true" style="background: linear-gradient(#242424db 0%, #0000008c 100%);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: rgb(0 0 0) !important; position: relative;">
            <div class="modal-body">
                <form id="loginForm">
                    <div class="mb-3" style="text-align: center">
                        <label for="accountName" class="form-label" style="color: #FFFFFF">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="accountName" required>
                    </div>
                    <div class="mb-3" style="text-align: center">
                        <label class="form-label" style="color: #FFFFFF">4 số cuối tài khoản ngân hàng</label>
                        <div class="bank-account-inputs">
                            <input type="text" class="bank-digit" maxlength="1" required>
                            <input type="text" class="bank-digit" maxlength="1" required>
                            <input type="text" class="bank-digit" maxlength="1" required>
                            <input type="text" class="bank-digit" maxlength="1" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-confirm"  style="background: linear-gradient(#EC6612 0%, #F50000 100%);">
                        <span class="btn-text">ĐĂNG NHẬP NGAY</span>
                        <span class="loading">
                            <i class="fas fa-spinner fa-spin"></i> Đang xử lý...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Close Button -->
            <button type="button" class="login-modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                <img src="{{ asset('images/Group.png') }}" alt="Close">
            </button>
        </div>
    </div>
</div>

<style>
    .login-modal-close-btn {
        position: absolute;
        bottom: -50px;
        left: 50%;
        transform: translateX(-50%);
        background: transparent;
        border: none;
        width: 30px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        padding: 0;
        transition: transform 0.3s
        ease;
    }

    .login-modal-close-btn:hover {
        transform: translateX(-50%) scale(1.1);
    }

    .login-modal-close-btn img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    #loginModal .modal-dialog {
        margin-bottom: 80px;
    }

    #loginModal .bank-account-inputs {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: nowrap;
    }

    #loginModal .bank-digit {
        width: 60px;
        height: 60px;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        border: 2px solid #d1d5db;
        border-radius: 8px;
        color: #fff;
        background: transparent;
    }

    #loginModal .bank-digit:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
        outline: none;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        #loginModal .bank-account-inputs {
            gap: 8px;
            justify-content: center;
        }

        #loginModal .bank-digit {
            width: 50px;
            height: 50px;
            font-size: 16px;
        }

        #loginModal .modal-dialog {
            margin: 0.5rem;
            margin-bottom: 80px;
        }
    }
</style>


