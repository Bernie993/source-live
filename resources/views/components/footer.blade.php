<!-- Footer -->
<footer class="footer">
    <div class="footer-container">
        <!-- Row 1: Logo + Description | Brand Ambassador -->
        <div class="footer-row-1">
            <!-- Left: Logo & Description -->
            <div class="footer-left-content">
                <div class="footer-logo">
                    <img src="{{ asset('images/U888-LOGO-NET-slogan 2.png') }}" alt="U888 Logo">
                </div>
                <p class="footer-description">
                    U888 là một công ty giải trí được đăng ký hợp pháp ở Costa Rica, tất cả các hoạt động kinh doanh cá cược đều tuân theo hiệp ước cá cược quốc tế của Costa Rica. Trong thị trường cá cược trực tuyến ngày càng sôi nổi, ABC8 được đông đảo người chơi lựa chọn, chúng tôi không ngừng tìm kiếm những đổi mới để thay đổi, luôn đem lại cho người chơi chất lượng phục vụ tốt nhất.
                </p>
                <a href="#" class="footer-read-more">... Xem thêm</a>
            </div>

            <!-- Right: Brand Ambassador -->
            <div class="footer-right-content">
                <h3 class="footer-title">Giám đốc thương hiệu ABCVIP</h3>
                <div class="footer-brand-image">
                    <img src="{{ asset('images/Frame 2147224093.png') }}" alt="Kevin Phillips & ABCVIP">
                </div>
            </div>
        </div>

        <!-- Row 2: Certificates & Awards -->
        <div class="footer-row-2">
            <div class="footer-certificates">
                <img src="{{ asset('images/Frame 2147223976.png') }}" alt="Certificates & Awards">
            </div>
        </div>

        <!-- Row 3: Menu Navigation -->
        <div class="footer-row-3">
            <nav class="footer-menu">
                @if(isset($footerMenus) && $footerMenus->count() > 0)
                    <div class="footer-menu-row">
                        @foreach($footerMenus as $menu)
                            <a href="{{ $menu->link }}"
                               class="footer-menu-item"
                               @if(str_starts_with($menu->link, 'http'))
                                   target="_blank"
                               @endif>
                                {{ $menu->text }}
                            </a>
                            @if(!$loop->last)
                                <span class="footer-separator">|</span>
                            @endif
                        @endforeach
                    </div>
                @else
                    <!-- Fallback menu if no menus in database -->
                    <div class="footer-menu-row">
                        <a href="#" class="footer-menu-item">Điều khoản và điều kiện</a>
                        <span class="footer-separator">|</span>
                        <a href="#" class="footer-menu-item">Giới thiệu</a>
                        <span class="footer-separator">|</span>
                        <a href="#" class="footer-menu-item">Chơi có trách nhiệm</a>
                        <span class="footer-separator">|</span>
                        <a href="#" class="footer-menu-item">Miễn trừ trách nhiệm</a>
                        <span class="footer-separator">|</span>
                        <a href="#" class="footer-menu-item">Quyền riêng tư</a>
                        <span class="footer-separator">|</span>
                        <a href="#" class="footer-menu-item">Những câu hỏi thường gặp</a>
                    </div>
                @endif
            </nav>
        </div>

        <!-- Row 4: Payment & Social -->
        <div class="footer-row-4">
            <!-- Payment Methods -->
            <div class="footer-payment-section">
                <h3 class="footer-title">Phương Thức Thanh Toán</h3>
                <div class="footer-payment-icons">
                    <img src="{{ asset('images/Frame 2147223977.png') }}" alt="Payment Methods">
                </div>
            </div>

            <!-- Social Media -->
            <div class="footer-social-section">
                <h3 class="footer-title">Theo Dõi Chúng Tôi</h3>
                <div class="footer-social-icons">
                    <img src="{{ asset('images/Frame 2147223979.png') }}" alt="Follow Us">
                </div>
            </div>
        </div>

        <!-- Footer Bottom Section -->
        <div class="footer-bottom">
            <p class="footer-copyright">
                Copyright © ABC8 Reserved
            </p>
        </div>
    </div>
</footer>

<style>
    /* Footer Styles */
    .footer {
        background: #1A1A1A;
        color: #FFFFFF;
        padding: 50px 0 20px;
        margin-top: 60px;
    }

    .footer-container {
        max-width: 1422px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Row 1: Logo + Description | Brand Ambassador */
    .footer-row-1 {
        display: grid;
        grid-template-columns: 524px 1fr 320px;
        gap: 40px;
        padding-bottom: 30px;
        align-items: start;
    }

    .footer-left-content {
        grid-column: 1 / 2;
    }

    .footer-right-content {
        grid-column: 3 / 4;
    }

    .footer-logo {
        margin-bottom: 15px;
    }

    .footer-logo img {
        max-width: 200px;
        height: auto;
        filter: brightness(1.1);
    }

    .footer-description {
        color: #B8B8B8;
        font-size: 12px;
        line-height: 1.7;
        margin: 0 0 8px 0;
        text-align: justify;
    }

    .footer-read-more {
        color: #888888;
        font-size: 12px;
        font-weight: 400;
        text-decoration: none;
        transition: color 0.3s ease;
        display: inline-block;
    }

    .footer-title {
        color: #FFFFFF;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 15px;
        text-align: center;
        text-transform: none;
        letter-spacing: 0.3px;
    }

    .footer-brand-image {
        text-align: center;
    }

    .footer-brand-image img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    /* Row 2: Certificates & Awards */
    .footer-row-2 {
        padding: 30px 0;
        text-align: center;
    }

    .footer-certificates img {
        max-width: 100%;
        height: auto;
        display: inline-block;
    }

    /* Row 3: Menu Navigation */
    .footer-row-3 {
        padding: 30px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-menu {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .footer-menu-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .footer-menu-item {
        color: #FFFFFF;
        font-size: 13px;
        font-weight: 400;
        text-decoration: none;
        transition: color 0.3s ease;
        white-space: nowrap;
    }

    .footer-separator {
        color: rgba(255, 255, 255, 0.3);
        font-size: 13px;
        margin: 0 3px;
    }

    /* Row 4: Payment & Social */
    .footer-row-4 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        padding: 35px 0 25px;
        align-items: start;
    }

    .footer-payment-section,
    .footer-social-section {
        text-align: center;
    }

    .footer-payment-icons,
    .footer-social-icons {
        margin-top: 10px;
    }

    .footer-payment-icons img,
    .footer-social-icons img {
        max-width: 100%;
        height: auto;
        display: inline-block;
    }

    /* Footer Bottom */
    .footer-bottom {
        text-align: center;
        padding-top: 25px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .footer-copyright {
        color: #888888;
        font-size: 13px;
        margin: 0;
        font-weight: 500;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .footer-row-1 {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .footer-left-content {
            grid-column: 1;
            text-align: center;
        }

        .footer-right-content {
            grid-column: 1;
        }

        .footer-description {
            text-align: center;
        }

        .footer-menu-row {
            gap: 8px;
        }

        .footer-menu-item {
            font-size: 12px;
        }

        .footer-separator {
            font-size: 12px;
        }

        .footer-row-4 {
            grid-template-columns: 1fr;
            gap: 30px;
        }
    }

    @media (max-width: 768px) {
        .footer {
            padding: 40px 0 20px;
        }

        .footer-container {
            padding: 0 15px;
        }

        .footer-row-1 {
            padding-bottom: 25px;
            gap: 25px;
        }

        .footer-logo img {
            max-width: 150px;
        }

        .footer-description {
            font-size: 11px;
            line-height: 1.6;
        }

        .footer-read-more {
            font-size: 11px;
        }

        .footer-row-2 {
            padding: 25px 0;
        }

        .footer-row-3 {
            padding: 25px 0;
        }

        .footer-menu-row {
            flex-direction: column;
            gap: 10px;
        }

        .footer-menu-item {
            font-size: 12px;
        }

        .footer-separator {
            display: none;
        }

        .footer-title {
            font-size: 12px;
            margin-bottom: 12px;
        }

        .footer-row-4 {
            padding: 25px 0 20px;
            gap: 25px;
        }

        .footer-bottom {
            padding-top: 20px;
        }

        .footer-copyright {
            font-size: 11px;
        }
    }
</style>
