<!-- Footer -->
<footer class="footer">
    <div class="footer-container">
        <!-- Footer Top Section -->
        <div class="footer-top">
            <!-- Column 1: Logo & Description -->
            <div class="footer-column footer-left">
                <div class="footer-logo">
                    <img src="{{ asset('images/U888-LOGO-NET-slogan 2.png') }}" alt="U888 Logo">
                </div>
                <p class="footer-description">
                    U888 là một công ty giải trí được đăng ký hợp pháp ở Costa Rica, tất cả các hoạt động kinh doanh cá cược đều tuân theo hiệp ước cá cược quốc tế của Costa Rica. Trong thị trường cá cược trực tuyến ngày càng sôi nổi, ABC8 được đông đảo người chơi lựa chọn, chúng tôi không ngừng tìm kiếm những đổi mới để thay đổi, luôn đem lại cho người chơi chất lượng phục vụ tốt nhất.
                </p>
                <a href="#" class="footer-read-more">... Xem thêm</a>
                
                <!-- Certificates & Awards -->
                <div class="footer-certificates">
                    <img src="{{ asset('images/Frame 2147223976.png') }}" alt="Certificates & Awards">
                </div>
            </div>

            <!-- Column 2: Menu Links (Dynamic from Database) -->
            <div class="footer-column footer-center">
                <nav class="footer-menu">
                    @if(isset($footerMenus) && $footerMenus->count() > 0)
                        <?php
                            // Split menus into 2 rows for better layout
                            $half = ceil($footerMenus->count() / 2);
                            $row1 = $footerMenus->take($half);
                            $row2 = $footerMenus->slice($half);
                        ?>
                        
                        <!-- Row 1 (First half) -->
                        @if($row1->count() > 0)
                        <div class="footer-menu-row">
                            @foreach($row1 as $index => $menu)
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
                        @endif
                        
                        <!-- Row 2 (Second half) -->
                        @if($row2->count() > 0)
                        <div class="footer-menu-row">
                            @foreach($row2 as $index => $menu)
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
                        @endif
                    @else
                        <!-- Fallback menu if no menus in database -->
                        <div class="footer-menu-row">
                            <a href="#" class="footer-menu-item">Điều khoản và điều kiện</a>
                            <span class="footer-separator">|</span>
                            <a href="#" class="footer-menu-item">Giới thiệu</a>
                            <span class="footer-separator">|</span>
                            <a href="#" class="footer-menu-item">Quyền riêng tư</a>
                        </div>
                    @endif
                </nav>
            </div>

            <!-- Column 3: Brand Ambassador -->
            <div class="footer-column footer-right">
                <div class="footer-brand-section">
                    <h3 class="footer-title">Giám đốc thương hiệu ABCVIP</h3>
                    <div class="footer-brand-image">
                        <img src="{{ asset('images/Frame 2147224093.png') }}" alt="Kevin Phillips & ABCVIP">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Middle Section (Payment & Social) -->
        <div class="footer-middle">
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
        max-width: 1920px;
        margin: 0 auto;
        padding: 0 40px;
    }

    /* Footer Top - 3 Columns */
    .footer-top {
        display: grid;
        grid-template-columns: 1fr 2fr 1fr;
        gap: 50px;
        padding-bottom: 40px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        align-items: start;
    }

    .footer-column {
        display: flex;
        flex-direction: column;
    }

    /* Left Column - Logo & Description */
    .footer-left {
        gap: 15px;
    }

    .footer-logo {
        margin-bottom: 10px;
    }

    .footer-logo img {
        max-width: 200px;
        height: auto;
        filter: brightness(1.1);
    }

    .footer-description {
        color: #B8B8B8;
        font-size: 13px;
        line-height: 1.8;
        margin: 0 0 5px 0;
        text-align: justify;
    }

    .footer-read-more {
        color: #FF4500;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
        margin-bottom: 15px;
        display: inline-block;
    }

    .footer-read-more:hover {
        color: #FF6347;
    }

    .footer-certificates {
        margin-top: 10px;
    }

    .footer-certificates img {
        max-width: 100%;
        height: auto;
        display: block;
    }

    /* Center Column - Menu (2 rows) */
    .footer-center {
        justify-content: center;
        align-items: center;
    }

    .footer-menu {
        display: flex;
        flex-direction: column;
        gap: 18px;
        align-items: center;
    }

    .footer-menu-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .footer-menu-item {
        color: #FFFFFF;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s ease;
        white-space: nowrap;
    }

    .footer-menu-item:hover {
        color: #FF4500;
    }

    .footer-separator {
        color: rgba(255, 255, 255, 0.3);
        font-size: 14px;
        margin: 0 5px;
    }

    /* Right Column - Brand Ambassador */
    .footer-right {
        align-items: center;
    }

    .footer-title {
        color: #FF4500;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 18px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .footer-brand-section {
        width: 100%;
    }

    .footer-brand-image {
        text-align: center;
    }

    .footer-brand-image img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
    }

    /* Footer Middle - Payment & Social */
    .footer-middle {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        padding: 35px 0;
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
        .footer-top {
            grid-template-columns: 1fr;
            gap: 35px;
            text-align: center;
        }

        .footer-left {
            align-items: center;
        }

        .footer-description {
            text-align: center;
        }

        .footer-menu-row {
            flex-direction: column;
            gap: 10px;
        }

        .footer-separator {
            display: none;
        }

        .footer-middle {
            grid-template-columns: 1fr;
            gap: 30px;
        }
    }

    @media (max-width: 768px) {
        .footer {
            padding: 40px 0 20px;
        }

        .footer-container {
            padding: 0 20px;
        }

        .footer-top {
            gap: 30px;
            padding-bottom: 30px;
        }

        .footer-logo img {
            max-width: 150px;
        }

        .footer-description {
            font-size: 12px;
            line-height: 1.7;
        }

        .footer-menu-item {
            font-size: 13px;
        }

        .footer-title {
            font-size: 13px;
            margin-bottom: 12px;
        }

        .footer-middle {
            padding: 25px 0;
            gap: 25px;
        }

        .footer-bottom {
            padding-top: 20px;
        }

        .footer-copyright {
            font-size: 12px;
        }
    }
</style>
