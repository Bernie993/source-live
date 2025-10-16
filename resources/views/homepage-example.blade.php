@extends('layouts.app')

@section('title', 'U888 - Trang chủ giải trí hàng đầu')

@push('styles')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<style>
    /* ============ PAGE-SPECIFIC STYLES (bỏ header/notification/modal vì đã có trong layout) ============ */
    
    /* ============ LIVE STREAMS SECTION ============ */
    .live-streams-section {
        max-width: 1920px;
        margin: 0 auto;
        padding: 40px 40px;
        background: #000;
    }

    .streams-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .main-live-box {
        background: linear-gradient(135deg, #FF6A3D 0%, #FF4419 100%);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(255, 69, 0, 0.4);
        position: relative;
    }

    .main-live-content {
        position: relative;
        aspect-ratio: 16 / 9;
        width: 100%;
    }

    #main-live-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .live-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 30px;
    }

    .live-logo-badge {
        background: rgba(255, 255, 255, 0.95);
        padding: 20px 30px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    }

    .live-logo-badge img {
        max-height: 60px;
        width: auto;
    }

    .btn-enter-live {
        background: linear-gradient(135deg, #FF4500 0%, #FF6347 100%);
        color: white;
        border: none;
        padding: 18px 50px;
        border-radius: 50px;
        font-size: 20px;
        font-weight: 900;
        letter-spacing: 2px;
        text-transform: uppercase;
        cursor: pointer;
        box-shadow: 0 10px 30px rgba(255, 69, 0, 0.6);
        transition: all 0.3s ease;
        animation: pulse-glow 2s infinite;
    }

    @keyframes pulse-glow {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 10px 30px rgba(255, 69, 0, 0.6);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(255, 69, 0, 0.8);
        }
    }

    .btn-enter-live:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(255, 69, 0, 0.8);
    }

    /* Side Live Boxes */
    .side-live-boxes {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .side-live-box {
        background: #1A1A1A;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .side-live-box:hover {
        transform: translateX(-5px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.6);
    }

    .side-live-content {
        position: relative;
    }

    .side-live-content img {
        width: 100%;
        height: auto;
        display: block;
    }

    .side-live-host {
        position: absolute;
        bottom: 15px;
        left: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(0, 0, 0, 0.7);
        padding: 8px 15px;
        border-radius: 25px;
        backdrop-filter: blur(10px);
    }

    .side-live-host-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid #FF4500;
    }

    .side-live-host-name {
        color: white;
        font-size: 13px;
        font-weight: 600;
    }

    .side-live-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, #FF4500 0%, #FF6347 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 4px 12px rgba(255, 69, 0, 0.5);
    }

    /* ... Copy all other page-specific styles here ... */
    /* Bao gồm: Promo Banner, News Section, App Download styles */
    
    @media (max-width: 1200px) {
        .streams-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <!-- Live Streams Section -->
    <div class="live-streams-section">
        <div class="streams-grid">
            <!-- Main Live Stream Box -->
            <div class="main-live-box" id="main-live-box">
                <div class="main-live-content" id="main-live-content">
                    <!-- Default placeholder image -->
                    <img src="{{ asset('images/738x512 3.png') }}" alt="Live Stream" id="main-live-image">

                    <!-- Overlay with button/info -->
                    <div class="live-overlay" id="main-live-overlay">
                        <div class="live-logo-badge">
                            <img src="{{ asset('images/u888-abcvip-(2) 1.png') }}" alt="U888 Logo">
                        </div>
                        <button class="btn-enter-live" id="btn-enter-live" style="display: none;">
                            VÀO PHÒNG LIVE
                        </button>
                    </div>
                </div>
            </div>

            <!-- Side Live Streams -->
            <div class="side-live-boxes" id="side-live-boxes">
                <!-- Will be populated by JavaScript -->
                <div class="side-live-box">
                    <div class="side-live-content">
                        <img src="{{ asset('images/738x512 3.png') }}" alt="Live Stream">
                        <div class="side-live-host">
                            <img src="https://ui-avatars.com/api/?name=Host&background=FF4500&color=fff"
                                 alt="Host" class="side-live-host-avatar">
                            <span class="side-live-host-name">Đang cập nhật...</span>
                        </div>
                        <div class="side-live-badge">
                            <i class="fas fa-gift"></i>
                            <span>Sắp diễn ra</span>
                        </div>
                    </div>
                </div>
                <div class="side-live-box">
                    <div class="side-live-content">
                        <img src="{{ asset('images/738x512 3.png') }}" alt="Live Stream">
                        <div class="side-live-host">
                            <img src="https://ui-avatars.com/api/?name=Host&background=FF4500&color=fff"
                                 alt="Host" class="side-live-host-avatar">
                            <span class="side-live-host-name">Đang cập nhật...</span>
                        </div>
                        <div class="side-live-badge">
                            <i class="fas fa-gift"></i>
                            <span>Sắp diễn ra</span>
                        </div>
                    </div>
                </div>
                <div class="side-live-box">
                    <div class="side-live-content">
                        <img src="{{ asset('images/738x512 3.png') }}" alt="Live Stream">
                        <div class="side-live-host">
                            <img src="https://ui-avatars.com/api/?name=Host&background=FF4500&color=fff"
                                 alt="Host" class="side-live-host-avatar">
                            <span class="side-live-host-name">Đang cập nhật...</span>
                        </div>
                        <div class="side-live-badge">
                            <i class="fas fa-gift"></i>
                            <span>Sắp diễn ra</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copy các sections khác từ file cũ:
         - Promotional Banner Slider
         - News Section  
         - App Download Section
    -->
@endsection

@push('scripts')
<!-- HLS.js -->
<script src="{{ asset('js/hls.min.js') }}"></script>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    // Copy all page-specific JavaScript from old file
    // Bao gồm: initializeApp, loadAllLiveStreams, enterLiveRoom, Swiper init, etc.
    
    console.log('Homepage initialized');
</script>
@endpush

