@extends('layouts.app')

@section('title', 'Phòng Live - U888')

@push('styles')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<style>
        .live-room-section {
            max-width: 1920px;
            margin: 0 auto;
            padding: 30px 40px;
        }

        .live-room-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 20px;
            margin-bottom: 40px;
        }

        /* Video Player Section (Left) */
        .video-section {
            background: #000;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(255, 69, 0, 0.3);
        }

        .video-header {
            background: linear-gradient(135deg, #FF6A3D 0%, #FF4419 100%);
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .video-header-left {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .host-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .host-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .host-details {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .host-name-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .streamer-badge {
            background: #7C3AED;
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .host-name {
            color: white;
            font-weight: 700;
            font-size: 18px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .host-description {
            color: white;
            font-size: 14px;
            font-weight: 500;
            opacity: 0.95;
        }

        .video-header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .social-icons {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .social-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.3s ease;
            text-decoration: none;
            font-size: 18px;
            color: white;
        }

        .social-icon:hover {
            transform: scale(1.1);
        }

        .social-icon.telegram {
            background: #0088cc;
        }

        .social-icon.twitter {
            background: #000000;
        }

        .social-icon.whatsapp {
            background: #25D366;
        }

        .social-icon.facebook {
            background: #1877F2;
        }

        .social-icon.messenger {
            background: linear-gradient(135deg, #00B2FF 0%, #006AFF 100%);
        }

        .copy-button {
            background: white;
            color: #FF4500;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .copy-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .viewer-stats {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: white;
            font-size: 14px;
            font-weight: 600;
        }

        .stat-item i {
            font-size: 16px;
        }

        .viewer-count {
            font-size: 16px;
            font-weight: 700;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }

        .video-player-wrapper {
            background: #000;
            aspect-ratio: 16/9;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #live-video-player {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Chat Section (Right) - New Design */
        .chat-section {
            background: linear-gradient(135deg, #FF6A3D 0%, #FF4419 100%);
            border-radius: 30px;
            box-shadow: 0 10px 40px rgba(255, 69, 0, 0.5);
            display: flex;
            flex-direction: column;
            height: fit-content;
            overflow: hidden;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .chat-header {
            background: linear-gradient(135deg, #CC3300 0%, #991100 100%);
            padding: 20px;
            color: white;
            font-weight: 700;
            font-size: 15px;
            line-height: 1.5;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .chat-header-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .chat-header-title i {
            color: #FFD700;
        }

        .chat-header-info {
            font-size: 13px;
            font-weight: 500;
            opacity: 0.95;
            line-height: 1.6;
        }

        .chat-messages {
            height: 520px;
            overflow-y: auto;
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            background: transparent;
        }

        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .chat-message {
            background: rgba(139, 0, 0, 0.5);
            border-radius: 12px;
            padding: 12px 15px;
            animation: slideIn 0.3s ease;
            position: relative;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .chat-message-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
        }

        .chat-message-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 12px;
            flex-shrink: 0;
            border: 2px solid rgba(255, 255, 255, 0.3);
            position: relative;
        }

        .chat-message-avatar::before {
            content: attr(data-level);
            position: absolute;
            top: -5px;
            left: -5px;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 900;
            border: 2px solid currentColor;
        }

        .chat-message-avatar.level-5 {
            background: linear-gradient(135deg, #FF8C00 0%, #FF6347 100%);
            color: white;
        }

        .chat-message-avatar.level-5::before {
            border-color: #FF8C00;
        }

        .chat-message-avatar.level-4 {
            background: linear-gradient(135deg, #9370DB 0%, #8A2BE2 100%);
            color: white;
        }

        .chat-message-avatar.level-4::before {
            border-color: #9370DB;
        }

        .chat-message-avatar.level-3 {
            background: linear-gradient(135deg, #4169E1 0%, #1E90FF 100%);
            color: white;
        }

        .chat-message-avatar.level-3::before {
            border-color: #4169E1;
        }

        .chat-message-avatar.level-2 {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            color: white;
        }

        .chat-message-avatar.level-2::before {
            border-color: #FFD700;
        }

        .chat-message-avatar.level-1 {
            background: linear-gradient(135deg, #A0522D 0%, #8B4513 100%);
            color: white;
        }

        .chat-message-avatar.level-1::before {
            border-color: #A0522D;
        }

        .chat-message-username {
            color: #FFD700;
            font-weight: 700;
            font-size: 14px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
        }

        .chat-message-text {
            color: white;
            font-size: 14px;
            line-height: 1.5;
            word-wrap: break-word;
            padding-left: 42px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .chat-message-time {
            color: rgba(255, 255, 255, 0.6);
            font-size: 10px;
            position: absolute;
            bottom: 8px;
            right: 12px;
            font-weight: 500;
        }

        .chat-input-form {
            padding: 12px;
            background: white;
            display: flex;
            align-items: center;
            gap: 10px;
            border-top: 2px solid rgba(255, 69, 0, 0.2);
        }

        .chat-input-icon {
            font-size: 24px;
            color: #FF4500;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .chat-input-icon:hover {
            transform: scale(1.1);
        }

        #chat-input {
            flex: 1;
            background: transparent;
            border: none;
            color: #666;
            padding: 10px 15px;
            outline: none;
            font-size: 14px;
        }

        #chat-input::placeholder {
            color: #999;
        }

        .chat-send-btn {
            background: linear-gradient(135deg, #FF4500 0%, #FF6347 100%);
            border: none;
            color: white;
            padding: 10px 24px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(255, 69, 0, 0.4);
        }

        .chat-send-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 69, 0, 0.6);
        }

        .chat-send-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .login-required {
            padding: 30px 20px;
            text-align: center;
            color: white;
            background: rgba(0, 0, 0, 0.2);
        }

        .login-required .btn-login {
            margin-top: 15px;
        }

        /* ============ PROMOTIONAL BANNER SLIDER ============ */
        .promo-banner-section {
            padding: 40px 40px 60px;
            max-width: 1920px;
            margin: 0 auto;
            position: relative;
        }

        .hot-badge {
            position: absolute;
            top: 25px;
            left: 25px;
            z-index: 10;
        }

        .hot-badge img {
            height: 60px;
            width: auto;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }

        .promo-swiper-container {
            padding: 0 60px;
        }

        .promo-slide {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease;
        }

        .promo-slide:hover {
            transform: translateY(-5px);
        }

        .promo-slide img {
            width: 100%;
            height: auto;
            display: block;
        }

        .promo-button-prev,
        .promo-button-next {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #FF4500 0%, #FF6347 100%);
            border-radius: 50%;
            color: white;
            box-shadow: 0 4px 15px rgba(255, 69, 0, 0.4);
            transition: all 0.3s ease;
        }

        .promo-button-prev:hover,
        .promo-button-next:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(255, 69, 0, 0.6);
        }

        .promo-pagination .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: #666;
            opacity: 1;
        }

        .promo-pagination .swiper-pagination-bullet-active {
            background: #FF4500;
            width: 30px;
            border-radius: 6px;
        }

        /* ============ NEWS SECTION ============ */
        .news-section {
            padding: 40px 40px 60px;
            max-width: 1920px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
        }

        .section-title-text {
            color: #FF4500;
            font-size: 32px;
            font-weight: 900;
            letter-spacing: 4px;
            text-transform: uppercase;
            text-shadow: 0 4px 8px rgba(255, 69, 0, 0.3);
            padding: 0 20px;
        }

        .section-title-line {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-title-line img {
            width: 100%;
            max-width: 500px;
            height: auto;
        }

        .section-title-line.left img {
            transform: scaleX(1);
        }

        .section-title-line.right img {
            transform: scaleX(-1);
        }

        .news-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            border: 3px solid #FF3C00;
            border-radius: 24px;
            padding: 10px;
        }

        .news-main {
            background: linear-gradient(135deg, #8B0000 0%, #DC143C 100%);
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .news-main:hover {
            transform: translateY(-5px);
        }

        .news-main img {
            width: 100%;
            height: auto;
            display: block;
        }

        .news-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .news-item {
            background: linear-gradient(135deg, #DC143C 0%, #8B0000 100%);
            border-radius: 16px;
            overflow: hidden;
            border: 1px dashed #ffffff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            display: flex;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 25px;
        }

        .news-item:hover {
            transform: translateX(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.6);
            border-color: #FFD700;
        }

        .news-item-image {
            width: 180px;
            flex-shrink: 0;
        }

        .news-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .news-item-content {
            padding: 15px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex: 1;
        }

        .news-item-title {
            color: #FFD700;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .news-item-description {
            color: white;
            font-size: 13px;
            line-height: 1.6;
        }

        /* ============ APP DOWNLOAD SECTION ============ */
        .app-download-section {
            padding: 40px 40px 60px;
            max-width: 1920px;
            margin: 0 auto;
        }

        .app-download-banner {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .app-download-banner:hover {
            transform: translateY(-5px);
        }

        .app-download-banner img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Modal Styles */
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

        .btn-confirm:hover {
            background: #b91c1c;
            color: white;
        }

        .bank-account-inputs {
            display: flex;
            gap: 10px;
        }

        .bank-digit {
            width: 60px;
            height: 60px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border: 2px solid #d1d5db;
            border-radius: 8px;
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
        @media (max-width: 1200px) {
            .live-room-grid {
                grid-template-columns: 1fr;
            }

            .chat-section {
                height: 400px;
            }

            .news-grid {
                grid-template-columns: 1fr;
            }
        }

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

            .live-room-section {
                padding: 20px 15px;
            }

            .promo-banner-section,
            .news-section,
            .app-download-section {
                padding: 30px 15px;
            }
        }
</style>
@endpush

@section('content')
    <div class="live-room-section">
        <div class="live-room-grid">
            <!-- Video Player Section (Left) -->
            <div class="video-section">
                <div class="video-header">
                    <div class="video-header-left">
                        <div class="host-info">
                            <img src="{{ $liveSetting->assignedUser->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($liveSetting->assignedUser->name ?? 'Host') . '&background=FF4500&color=fff' }}"
                                 alt="Host Avatar"
                                 class="host-avatar">
                            <div class="host-details">
                                <div class="host-name-row">
                                    <span class="streamer-badge">Streamer</span>
                                    <span class="host-name">{{ $liveSetting->assignedUser->name ?? 'Viruss' }}</span>
                                </div>
                                <div class="host-description">
                                    88CLB phát code siêu khủng
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="video-header-right">
                        <div class="social-icons">
                            <a href="http://t.me/ABC8LIVE" target="_blank" class="social-icon telegram" title="Telegram">
                                <i class="fab fa-telegram-plane"></i>
                            </a>
                            <a href="#" class="social-icon twitter" title="Twitter/X">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                            <a href="#" class="social-icon whatsapp" title="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="#" class="social-icon facebook" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-icon messenger" title="Messenger">
                                <i class="fab fa-facebook-messenger"></i>
                            </a>
                        </div>

                        <button class="copy-button" onclick="copyLiveUrl()">
                            Sao chép
                        </button>

                        <div class="viewer-stats">
                            <div class="stat-item">
                                <i class="fas fa-share-nodes"></i>
                                <span>Chia sẻ</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-eye"></i>
                                <span class="viewer-count" id="live-viewer-count">0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="video-player-wrapper">
                    <video id="live-video-player" controls autoplay muted playsinline></video>
                </div>
            </div>

            <!-- Chat Section (Right) -->
            <div class="chat-section">
                <div class="chat-header">
                    <div class="chat-header-title">
                        <i class="fas fa-user-circle"></i>
                        <span>Streamer {{ $liveSetting->assignedUser->name ?? 'Viruss' }}:</span>
                    </div>
                    <div class="chat-header-info">
                        Cập nhật thông tin ABC8 tại: http://t.me/ABC8LIVE<br>
                        Telegram CSKH hỗ trợ 24/7: http://t.me/ABC8LIVE
                    </div>
                </div>
                <div class="chat-messages" id="chat-messages">
                    <!-- Messages will be loaded here -->
                </div>
                @guest
                <div class="login-required">
                    Bạn cần đăng nhập để chat.
                    <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Đăng nhập
                    </button>
                </div>
                @else
                <form id="chat-form" class="chat-input-form">
                    @csrf
                    <i class="far fa-smile chat-input-icon"></i>
                    <input type="text" id="chat-input" placeholder="Nhập nội dung trò chuyện" autocomplete="off">
                    <button type="submit" class="chat-send-btn">
                        Gửi đi
                    </button>
                </form>
                @endguest
            </div>
        </div>
    </div>

    <!-- Promotional Banner Slider -->
    <div class="promo-banner-section">
        <div class="hot-badge">
            <img src="{{ asset('images/Frame 2147223991.png') }}" alt="HOT">
        </div>

        <div class="promo-swiper-container">
            <div class="swiper promoSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide promo-slide">
                        <img src="{{ asset('images/image 77.png') }}" alt="Vui Tết Trung Thu - Phát Thưởng 15.000 Tỷ">
                    </div>
                    <div class="swiper-slide promo-slide">
                        <img src="{{ asset('images/image 78.png') }}" alt="Đua Top Đặt Cược - Thưởng Lớn Đêm Trắng">
                    </div>
                    <div class="swiper-slide promo-slide">
                        <img src="{{ asset('images/image 79.png') }}" alt="Nhận Ngay Code Ưu Đãi Khủng">
                    </div>
                </div>
                <div class="swiper-button-next promo-button-next"></div>
                <div class="swiper-button-prev promo-button-prev"></div>
                <div class="swiper-pagination promo-pagination"></div>
            </div>
        </div>
    </div>
    <!-- App Download Section -->
    <div class="app-download-section">
        <div class="app-download-banner">
            <img src="{{ asset('images/Frame 2147224090.png') }}" alt="Download App">
        </div>
    </div>

@endsection

@push('scripts')
<!-- HLS.js -->
<script src="{{ asset('js/hls.min.js') }}"></script>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Initialize HLS Video Player
        const video = document.getElementById('live-video-player');
        const playUrl = '{{ $liveSetting->play_url }}';

        console.log('🎬 Initializing video player with URL:', playUrl);

        if (Hls.isSupported() && playUrl.includes('.m3u8')) {
            const hls = new Hls({
                enableWorker: true,
                lowLatencyMode: true,
                backBufferLength: 90
            });

            hls.loadSource(playUrl);
            hls.attachMedia(video);

            hls.on(Hls.Events.MANIFEST_PARSED, function() {
                console.log('✅ HLS manifest parsed, starting playback');
                video.play().catch(e => console.log('Autoplay prevented:', e));
            });

            hls.on(Hls.Events.ERROR, function(event, data) {
                console.error('❌ HLS error:', data);
                if (data.fatal) {
                    switch(data.type) {
                        case Hls.ErrorTypes.NETWORK_ERROR:
                            console.log('Network error, trying to recover...');
                            hls.startLoad();
                            break;
                        case Hls.ErrorTypes.MEDIA_ERROR:
                            console.log('Media error, trying to recover...');
                            hls.recoverMediaError();
                            break;
                        default:
                            hls.destroy();
                            break;
                    }
                }
            });
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            video.src = playUrl;
            video.addEventListener('loadedmetadata', function() {
                video.play();
            });
        }

        // Chat functionality
        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        const currentUser = @json(Auth::user());
        let lastMessageId = 0;
        let isRealtimeActive = false;

        console.log('🔍 Chat init - Logged in:', isLoggedIn, 'Echo available:', typeof Echo !== 'undefined');

        // Load initial messages
        loadChatMessages();

        if (isLoggedIn) {
            // Handle send message
            const chatForm = document.getElementById('chat-form');
            if (chatForm) {
                chatForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    sendMessage();
                });
            }

            // Try to use Echo for realtime
            if (typeof Echo !== 'undefined') {
                try {
                    const liveId = {{ $liveSetting->id }};
                    // Listen to this specific live room's channel
                    Echo.channel(`live-chat.${liveId}`)
                        .listen('.new-message', function(data) {
                            console.log('📨 New message via Echo for live room ' + liveId + ':', data);
                            // Only add message if it belongs to this live room
                            if (data.live_setting_id == liveId) {
                                addMessageToChat(data);
                                isRealtimeActive = true;
                            }
                        });
                    console.log('✅ Echo realtime listener set up for live room ' + liveId);
                } catch (error) {
                    console.warn('⚠️ Echo setup failed:', error);
                    startPolling();
                }
            } else {
                console.warn('⚠️ Echo not available, using polling');
                startPolling();
            }
        } else {
            console.log('ℹ️ User not logged in, chat is read-only');
        }

        // Fallback polling if Echo doesn't work
        function startPolling() {
            setInterval(() => {
                if (!isRealtimeActive) {
                    loadNewMessages();
                }
            }, 3000); // Poll every 3 seconds
        }

        function loadNewMessages() {
            const liveId = {{ $liveSetting->id }};
            fetch(`/api/chat/messages?after=${lastMessageId}&live_setting_id=${liveId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.messages && data.messages.length > 0) {
                        data.messages.forEach(msg => {
                            if (msg.id > lastMessageId) {
                                addMessageToChat(msg);
                            }
                        });
                    }
                })
                .catch(error => console.error('Error loading new messages:', error));
        }

        function loadChatMessages() {
            const liveId = {{ $liveSetting->id }};
            fetch(`/api/chat/messages?live_setting_id=${liveId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.messages) {
                        data.messages.forEach(msg => addMessageToChat(msg));
                        scrollChatToBottom();
                    }
                })
                .catch(error => console.error('Error loading messages:', error));
        }

        function sendMessage() {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            const liveId = {{ $liveSetting->id }};

            if (!message) return;

            // Disable input while sending
            input.disabled = true;

            fetch('/api/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ 
                    message: message,
                    live_setting_id: liveId
                })
            })
                .then(response => {
                    if (response.status === 401) {
                        alert('Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.');
                        window.location.href = '/';
                        throw new Error('Unauthorized');
                    }
                    if (!response.ok) {
                        throw new Error('HTTP error! status: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        input.value = '';
                    } else {
                        alert(data.message || 'Có lỗi xảy ra khi gửi tin nhắn');
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    if (error.message !== 'Unauthorized') {
                        alert('Không thể gửi tin nhắn. Vui lòng thử lại!');
                    }
                })
                .finally(() => {
                    input.disabled = false;
                    input.focus();
                });
        }

        function addMessageToChat(data) {
            const chatMessages = document.getElementById('chat-messages');

            // Track last message ID
            if (data.id && data.id > lastMessageId) {
                lastMessageId = data.id;
            }

            // Check if message already exists (prevent duplicates)
            const existingMsg = chatMessages.querySelector(`[data-message-id="${data.id}"]`);
            if (existingMsg) {
                return;
            }

            const messageDiv = document.createElement('div');
            messageDiv.className = 'chat-message';
            messageDiv.setAttribute('data-message-id', data.id || Date.now());

            // Random level between 1-5 for demo (you can use user level from database)
            const userLevel = data.level || (Math.floor(Math.random() * 5) + 1);
            const initial = data.username ? data.username.charAt(0).toUpperCase() : 'U';

            messageDiv.innerHTML = `
                <div class="chat-message-header">
                    <div class="chat-message-avatar level-${userLevel}" data-level="${userLevel}">
                        ${initial}
                    </div>
                    <div class="chat-message-username">${escapeHtml(data.username || 'User')} ${data.user_id || '1'}:</div>
                </div>
                <div class="chat-message-text">${escapeHtml(data.message)}</div>
                <div class="chat-message-time">${formatTime(data.created_at)}</div>
            `;

            chatMessages.appendChild(messageDiv);
            scrollChatToBottom();
        }

        function scrollChatToBottom() {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function formatTime(timestamp) {
            const date = new Date(timestamp);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');

            return `${hours}:${minutes}:${seconds} ${day}.${month}.${year}`;
        }

        // Copy Live URL function
        function copyLiveUrl() {
            const url = window.location.href;

            // Modern API
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(() => {
                    alert('Đã sao chép link live vào clipboard!');
                }).catch(err => {
                    console.error('Failed to copy:', err);
                    fallbackCopy(url);
                });
            } else {
                fallbackCopy(url);
            }
        }

        function fallbackCopy(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                document.execCommand('copy');
                alert('Đã sao chép link live vào clipboard!');
            } catch (err) {
                console.error('Fallback copy failed:', err);
                alert('Không thể sao chép. Vui lòng copy thủ công: ' + text);
            }

            document.body.removeChild(textArea);
        }

        // Track and update viewer count for this specific live
        const liveId = {{ $liveSetting->id }};
        let viewerTrackingInterval;

        function updateViewerCount() {
            fetch(`/api/live/${liveId}/viewer-count`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.viewer_count !== undefined) {
                    document.getElementById('live-viewer-count').textContent = data.viewer_count;
                    console.log('👥 Viewers:', data.viewer_count);
                }
            })
            .catch(error => {
                console.warn('⚠️ Could not update viewer count:', error);
            });
        }

        // Initial viewer count
        updateViewerCount();

        // Update viewer count every 10 seconds
        viewerTrackingInterval = setInterval(updateViewerCount, 10000);

        // Mark viewer as left when page unloads
        window.addEventListener('beforeunload', function() {
            navigator.sendBeacon(`/api/live/${liveId}/viewer-leave`, JSON.stringify({
                _token: document.querySelector('meta[name="csrf-token"]').content
            }));
        });

        // Chat is ready
        console.log('✅ Chat initialized successfully');

        // Initialize Swiper for promotional banners
        const promoSwiper = new Swiper('.promoSwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.promo-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.promo-button-next',
                prevEl: '.promo-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });

        // Login form handling
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', handleLogin);
        }

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
            const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
            dropdownElementList.forEach(dropdown => {
                new bootstrap.Dropdown(dropdown);
            });
        });
    </script>
@endpush
