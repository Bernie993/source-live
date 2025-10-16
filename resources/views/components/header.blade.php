<!-- U888 Header -->
<header class="header">
    <div class="container-fluid">
        <div class="header-content">
            <!-- Left: Logo + Menu -->
            <div class="header-left">
                <div class="logo-container">
                    <!-- U888 Logo Image -->
                    <a href="/" class="logo-u888">
                        <img src="{{ asset('images/u888-abcvip-(2) 1.png') }}" alt="U888 - ABC VIP">
                    </a>
                </div>

                <!-- Navigation Menu (Dynamic from Database) -->
                <nav class="nav-menu">
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

            <!-- Right: Login Button -->
            <div class="header-right">
                @guest
                    <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Đăng nhập
                    </button>
                @else
                    <div class="dropdown">
                        <button class="btn btn-login dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Thông tin</a></li>
                            <li><hr class="dropdown-divider"></li>
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

