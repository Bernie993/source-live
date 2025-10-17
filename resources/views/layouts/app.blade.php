<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'U888 - Trang chủ')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Additional CSS -->
    @stack('styles')

    <!-- Common Styles -->
    <style>
        body {
            background: #000000;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }

        /* Main Content Wrapper - Max width 1422px, centered */
        .main-content-wrapper {
            max-width: 1422px;
            margin: 0 auto;
            width: 100%;
        }

        /* ============ HEADER STYLES ============ */
        .header {
            background: linear-gradient(180deg, #1F1F1F 0%, #000000 100%);
            height: 99px;
            box-shadow: 0px 5px 5.8px 0px rgba(0, 0, 0, 0.55);
            position: relative;
            z-index: 1000;
        }

        .header .container-fluid {
            max-width: 1422px;
            height: 100%;
            padding: 0 20px;
            margin: 0 auto;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            gap: 40px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 50px;
            flex: 1;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .logo-u888 {
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: transform 0.3s ease;
        }


        .logo-u888 img {
            height: 50px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .header-right {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .nav-menu {
            display: flex;
            gap: 35px;
            align-items: center;
        }

        .nav-item {
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s ease;
            position: relative;
            padding: 8px 0;
            white-space: nowrap;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #FF4500;
            transition: width 0.3s ease;
        }

        .nav-item.active {
            color: #FF4500;
        }

        .nav-item.active::after {
            width: 100%;
        }

        .btn-login {
            background: linear-gradient(135deg, #FF4500 0%, #FF6347 100%);
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 69, 0, 0.4);
        }


        .dropdown-menu {
            background: white;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            padding: 10px;
            margin-top: 10px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }


        /* ============ NOTIFICATION BANNER ============ */
        .notification-banner {
            position: relative;
            z-index: 999;
            display: flex;
            justify-content: center;
            padding: 15px 20px;
        }

        .notification-banner-content {
            max-width: 1422px;
            width: 100%;
            background: linear-gradient(#EC6612 0%, #F50000 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-radius: 8px;
            border: 2px solid #D84500;
        }

        .notification-icon {
            width: 30px;
            height: 30px;
            object-fit: contain;
            flex-shrink: 0;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .notification-text {
            color: white;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.5px;
            flex: 1;
            overflow: hidden;
            white-space: nowrap;
        }
        .bank-account-inputs .text {
            background-color: #2d2d2d !important;
        }

        #notification-scroll {
            display: inline-block;
            animation: scroll-left 25s linear infinite;
        }

        @keyframes scroll-left {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        /* ============ MODAL STYLES ============ */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            border-bottom: 1px solid #e5e7eb;
            padding: 20px 30px;
            background: #f9fafb;
            border-radius: 12px 12px 0 0;
        }

        .modal-body {
            padding: 30px;
        }

        .j88-logo {
            background: #dc2626;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            margin: 0 auto 20px;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 12px 16px;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
        }

        .btn-confirm {
            background: #dc2626;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            font-size: 16px;
            transition: background 0.3s;
        }


        .bank-account-inputs {
            display: flex;
            gap: 10px;
            width: 60%;
            margin: 0 auto;
        }

        .bank-digit {
            width: 60px;
            height: 60px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            background-color: #2d2d2d !important;
        }

        .bank-digit:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
        }

        .loading {
            display: none;
        }

        .loading.show {
            display: inline-block;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-left {
                gap: 20px;
            }

            .nav-menu {
                gap: 15px;
            }

            .nav-item {
                font-size: 13px;
            }

            .btn-login {
                padding: 10px 20px;
                font-size: 13px;
            }
        }

        /* Custom Login Modal Styles */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.9) !important;
        }

        .modal-content.login-modal-custom {
            background: rgba(240, 240, 240, 0.98);
            border-radius: 16px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);
            padding: 40px;
            max-width: 500px;
            margin: auto;
        }

        .login-modal-custom .modal-body {
            padding: 0;
            position: relative;
        }

        .login-modal-title {
            color: #000;
            font-size: 22px;
            font-weight: 600;
            text-align: left;
            margin-bottom: 20px;
        }

        .login-label {
            color: #000;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 15px;
            display: block;
            text-align: left;
        }

        .login-input {
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 15px;
            color: #000;
            font-size: 14px;
            width: 100%;
        }

        .login-input::placeholder {
            color: rgba(0, 0, 0, 0.4);
        }

        .login-input:focus {
            background: white;
            border-color: #999;
            color: #000;
            box-shadow: none;
            outline: none;
        }

        .btn-login-submit {
            background: linear-gradient(135deg, #FF6A3D 0%, #FF4419 100%);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
            letter-spacing: 1px;
        }

        .btn-close-custom {
            position: absolute;
            bottom: -60px;
            left: 50%;
            transform: translateX(-50%);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-close-custom i {
            color: #1a1a1a;
            font-size: 20px;
        }

        .login-modal-custom .bank-account-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 0 auto;
        }

        .login-modal-custom .bank-digit {
            width: 80px;
            height: 80px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            border: 2px solid #d1d5db;
            border-radius: 12px;
            background: white;
            color: #000;
        }

        .login-modal-custom .bank-digit:focus {
            border-color: #999;
            background: white;
            outline: none;
            box-shadow: none;
        }

        .loading {
            display: none;
        }

        .loading.show {
            display: inline-block;
        }

        /* Mobile Menu Styles */
        .hamburger-menu {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 24px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            z-index: 1001;
        }

        .hamburger-menu span {
            width: 100%;
            height: 3px;
            background: #FF4500;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .hamburger-menu.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .hamburger-menu.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger-menu.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 280px;
            height: 100vh;
            background: #1a1a1a;
            z-index: 1002;
            transition: left 0.3s ease;
            overflow-y: auto;
        }

        .mobile-sidebar.active {
            left: 0;
        }

        .mobile-sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .mobile-logo {
            width: 100%;
            max-width: 180px;
            height: auto;
        }

        .mobile-menu {
            padding: 0;
        }

        .mobile-menu-item {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .mobile-menu-item:first-child {
            background: linear-gradient(135deg, #FF6A3D 0%, #FF4419 100%);
            border-bottom: none;
        }

        .mobile-menu-item:hover,
        .mobile-menu-item.active {
            background: rgba(255, 69, 0, 0.1);
            padding-left: 30px;
        }

        .mobile-sidebar-footer {
            padding: 20px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .btn-mobile-login {
            background: linear-gradient(135deg, #FF6A3D 0%, #FF4419 100%);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 16px;
            width: 100%;
            letter-spacing: 1px;
        }

        .mobile-user-info {
            color: white;
            text-align: center;
        }

        .mobile-user-info p {
            margin-bottom: 10px;
        }

        .mobile-user-info a {
            color: #FF4500;
            text-decoration: none;
        }

        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1001;
        }

        .mobile-overlay.active {
            display: block;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .hamburger-menu {
                display: flex;
            }

            .desktop-menu {
                display: none !important;
            }

            .desktop-only {
                display: none !important;
            }

            .header-left {
                justify-content: center;
                flex: 1;
            }

            .logo-container {
                margin-left: 0;
            }

            .notification-banner {
                padding: 8px 10px;
            }

            .notification-banner-content {
                padding: 8px 12px;
                gap: 10px;
            }

            .main-content-wrapper {
                padding: 0;
            }

            body {
                padding: 0;
                margin: 0;
            }
        }
    </style>

    @vite(['resources/js/app.js'])
</head>
<body>
    <!-- Header Component -->
    @include('components.header')

    <!-- Main Content -->
    <main class="main-content-wrapper">
        @yield('content')
    </main>

    <!-- Footer Component -->
    @include('components.footer')

    <!-- Login Modal Component -->
    @include('components.login-modal')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Mobile Menu Functions - MUST be defined before @stack('scripts') -->
    <script>
        // Mobile Menu Functions
        function toggleMobileMenu() {
            var hamburgerMenu = document.getElementById('hamburgerMenu');
            var mobileSidebar = document.getElementById('mobileSidebar');
            var mobileOverlay = document.getElementById('mobileOverlay');
            
            if (hamburgerMenu && mobileSidebar && mobileOverlay) {
                hamburgerMenu.classList.toggle('active');
                mobileSidebar.classList.toggle('active');
                mobileOverlay.classList.toggle('active');
                document.body.style.overflow = mobileSidebar.classList.contains('active') ? 'hidden' : '';
            }
        }

        function closeMobileMenu() {
            var hamburgerMenu = document.getElementById('hamburgerMenu');
            var mobileSidebar = document.getElementById('mobileSidebar');
            var mobileOverlay = document.getElementById('mobileOverlay');
            
            if (hamburgerMenu && mobileSidebar && mobileOverlay) {
                hamburgerMenu.classList.remove('active');
                mobileSidebar.classList.remove('active');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    </script>

    @stack('scripts')

    <!-- Common Login Script -->
    <script>
        (function() {
            // Bank digit auto-focus
            const bankDigits = document.querySelectorAll('.bank-digit');
        bankDigits.forEach((digit, index) => {
            digit.addEventListener('input', function(e) {
                const value = e.target.value;
                if (value && index < bankDigits.length - 1) {
                    bankDigits[index + 1].focus();
                }
            });

            digit.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    bankDigits[index - 1].focus();
                }
            });
        });

        // Login form handling
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', handleLogin);
        }

        function handleLogin(e) {
            e.preventDefault();

            const accountName = document.getElementById('accountName').value.trim();
            const bankAccount = Array.from(document.querySelectorAll('.bank-digit')).map(digit => digit.value).join('');

            if (!accountName || bankAccount.length !== 4) {
                alert('Vui lòng nhập đầy đủ thông tin!');
                return;
            }

            // Show loading state
            const btnText = document.querySelector('.btn-text');
            const loading = document.querySelector('.loading');
            const submitBtn = document.querySelector('.btn-confirm');

            btnText.style.display = 'none';
            loading.classList.add('show');
            submitBtn.disabled = true;

            // Call API
            fetch('/api/check-user-eligibility', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    account: accountName,
                    bank_account: bankAccount
                })
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success && data.authenticated) {
                        alert('Đăng nhập thành công!');

                        // Close modal using vanilla JS
                        const loginModal = document.getElementById('loginModal');
                        if (loginModal) {
                            // Remove backdrop manually
                            const backdrop = document.querySelector('.modal-backdrop');
                            if (backdrop) {
                                backdrop.remove();
                            }
                            loginModal.classList.remove('show');
                            loginModal.style.display = 'none';
                            document.body.classList.remove('modal-open');
                            document.body.style.removeProperty('overflow');
                            document.body.style.removeProperty('padding-right');
                        }

                        // Wait a bit for session to be saved, then reload
                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    } else {
                        alert(data.message || 'Tài khoản không hợp lệ!');
                    }
                })
                .catch(error => {
                    console.error('Detailed error:', error);
                    alert('Có lỗi xảy ra, vui lòng thử lại! Chi tiết: ' + error.message);
                })
                .finally(() => {
                    // Reset loading state
                    btnText.style.display = 'inline';
                    loading.classList.remove('show');
                    submitBtn.disabled = false;
                });
        }

            // Initialize Bootstrap dropdowns
            document.addEventListener('DOMContentLoaded', function() {
                var dropdownElementList = document.querySelectorAll('.dropdown-toggle');
                dropdownElementList.forEach(function(dropdown) {
                    new bootstrap.Dropdown(dropdown);
                });
            });
        })();
    </script>
</body>
</html>
