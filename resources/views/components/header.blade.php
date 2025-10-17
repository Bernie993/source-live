<!-- U888 Header -->
<header class="header">
    <div class="container-fluid">
        <div class="header-content">
            <!-- Mobile: Hamburger Icon -->
            <button class="hamburger-menu" id="hamburgerMenu" aria-label="Menu" onclick="toggleMobileMenu()">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Left: Logo + Menu -->
            <div class="header-left">
                <div class="logo-container">
                    <!-- U888 Logo Image -->
                    <a href="/" class="logo-u888">
                        <img src="{{ asset('images/u888-abcvip-(2) 1.png') }}" alt="U888 - ABC VIP">
                    </a>
                </div>

                <!-- Navigation Menu (Dynamic from Database) - Desktop -->
                <nav class="nav-menu desktop-menu">
                    @if(isset($headerMenus) && $headerMenus->count() > 0)
                        @foreach($headerMenus as $menu)
                            <a href="{{ $menu->link }}"
                               class="nav-item {{ Request::is(trim($menu->link, '/')) ? 'active' : '' }}"
                               @if(str_starts_with($menu->link, 'http'))
                                   target="_blank"
                               @endif>
                                {{ $menu->text }}
                            </a>
                        @endforeach
                    @else
                        <!-- Fallback menu if no menus in database -->
                        <a href="/" class="nav-item {{ Request::is('/') ? 'active' : '' }}">Trang chủ</a>
                        <a href="#" class="nav-item">Quà tặng</a>
                        <a href="#" class="nav-item">Tải APP</a>
                    @endif
                </nav>
            </div>

            <!-- Right: Login Button - Desktop -->
            <div class="header-right desktop-only">
                @guest
                    <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Đăng nhập
                    </button>
                @else
                    <div class="dropdown">
                        <button class="btn btn-login dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest
            </div>
        </div>
    </div>
</header>

<!-- Mobile Sidebar Menu -->
<div class="mobile-sidebar" id="mobileSidebar">
    <div class="mobile-sidebar-header">
        <img src="{{ asset('images/u888-abcvip-(2) 1.png') }}" alt="U888 - ABC VIP" class="mobile-logo">
    </div>

    <nav class="mobile-menu">
        @if(isset($headerMenus) && $headerMenus->count() > 0)
            @foreach($headerMenus as $menu)
                <a href="{{ $menu->link }}"
                   class="mobile-menu-item {{ Request::is(trim($menu->link, '/')) ? 'active' : '' }}"
                   onclick="setTimeout(closeMobileMenu, 300)"
                   @if(str_starts_with($menu->link, 'http'))
                       target="_blank"
                   @endif>
                    {{ $menu->text }}
                </a>
            @endforeach
        @else
            <a href="/" class="mobile-menu-item {{ Request::is('/') ? 'active' : '' }}" onclick="setTimeout(closeMobileMenu, 300)">TRANG CHỦ</a>
            <a href="#" class="mobile-menu-item" onclick="setTimeout(closeMobileMenu, 300)">QUÀ TẶNG</a>
            <a href="#" class="mobile-menu-item" onclick="setTimeout(closeMobileMenu, 300)">TẢI APP</a>
            <a href="#" class="mobile-menu-item" onclick="setTimeout(closeMobileMenu, 300)">NHẬN CODE</a>
            <a href="#" class="mobile-menu-item" onclick="setTimeout(closeMobileMenu, 300)">PHẢN HỒI</a>
        @endif
    </nav>

    <div class="mobile-sidebar-footer">
        @guest
            <button class="btn btn-mobile-login" data-bs-toggle="modal" data-bs-target="#loginModal" onclick="closeMobileMenu()">
                ĐĂNG NHẬP
            </button>
        @else
            <div class="mobile-user-info">
                <p><i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}</p>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                </a>
            </div>
        @endguest
    </div>
</div>

<!-- Mobile Menu Overlay -->
<div class="mobile-overlay" id="mobileOverlay" onclick="closeMobileMenu()"></div>
<!-- Notification Banner -->
<div class="notification-banner">
    <div class="notification-banner-content">
        <img src="{{ asset('images/image_2025-07-05_16-38-07 1.png') }}" alt="Notification" class="notification-icon">
        <div class="notification-text">
            <span id="notification-scroll">
                🎁 THỂ THAO BẢO HIỂM CƯỢC THUA LÊN ĐẾN 5% 🎁 THỂ THAO THẮNG LIÊN TIẾP NHẬN THƯỞNG LÊN ĐẾN 8.888K 🎁 HÃY CÙNG BẠN BÈ THAM GIA ABC8 VÀ NHẬN THƯỞNG NHÉ 🎁
            </span>
        </div>
    </div>
</div>

