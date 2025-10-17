@extends('layouts.app')

@section('title', 'U888 - Trang chủ giải trí hàng đầu')

@push('styles')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<style>
        .live-streams-section {
            padding: 30px 20px;
        }

        .streams-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 20px;
        }

        /* Main Live Stream Box */
        .main-live-box {
            position: relative;
            border-radius: 40px;
            overflow: hidden;
            background: linear-gradient(135deg, #8B4513 0%, #4a2409 100%);
            box-shadow: 0 10px 40px rgba(255, 69, 0, 0.4);
            aspect-ratio: 16/9;
            border: 8px solid #FF4500;
        }

        .main-live-content {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-live-content img,
        .main-live-content video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .live-overlay {
            background: url({{ asset('images/738x512%204.png') }});
            background-repeat: no-repeat;
            background-size: cover;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .live-logo-badge {
            position: absolute;
            top: 25px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 12px 40px;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.4);
            border: 3px solid rgba(255, 255, 255, 0.5);
        }

        .live-logo-badge img {
            height: 45px;
            width: auto;
        }

        .btn-enter-live {
            background: linear-gradient(135deg, #FF4500 0%, #FF6347 100%);
            color: white;
            border: none;
            padding: 18px 55px;
            border-radius: 50px;
            font-size: 22px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(255, 69, 0, 0.6);
            transition: all 0.3s ease;
            animation: pulse 2s ease-in-out infinite;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }


        /* Side Live Boxes */
        .side-live-boxes {
            display: grid;
            grid-template-rows: 1fr 1fr 1fr;
            gap: 15px;
            height: 100%;
        }

        .side-live-box {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: #2a2a2a;
            border: 5px solid #FF4500;
            box-shadow: 0 6px 20px rgba(255, 69, 0, 0.3);
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
        }


        .side-live-content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .side-live-content img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .side-live-host {
            position: absolute;
            top: 8px;
            left: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
            background: rgba(0, 0, 0, 0.8);
            padding: 3px 8px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .side-live-host-avatar {
            width: 18px !important;
            height: 18px !important;
            border-radius: 50%;
            border: 2px solid #FF4500;
            object-fit: cover;
            flex-shrink: 0;
        }

        .side-live-host-name {
            color: white;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100px;
        }

        .side-live-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: linear-gradient(135deg, #FF6347 0%, #FF4500 100%);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 3px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.4);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .side-live-badge.live-now {
            background: linear-gradient(135deg, #00FF00 0%, #00CC00 100%);
            animation: pulse-badge 1.5s infinite;
        }

        @keyframes pulse-badge {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .side-live-badge i {
            color: #FFD700;
            font-size: 8px;
        }

        /* Button for side live boxes */
        .side-live-enter-btn {
            position: absolute;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #FF4500 0%, #FF6347 100%);
            color: white;
            border: none;
            padding: 6px 16px;
            border-radius: 18px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(255, 69, 0, 0.5);
            transition: all 0.3s ease;
            white-space: nowrap;
        }


        /* Responsive */
        @media (max-width: 1200px) {
            .streams-grid {
                grid-template-columns: 1fr;
            }

            .side-live-boxes {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
                height: auto;
            }

            .side-live-box {
                aspect-ratio: 16/9;
            }
        }

        @media (max-width: 768px) {
            .live-streams-section {
                padding: 5px 8px;
                margin: 0;
            }

            .streams-grid {
                grid-template-columns: 1fr;
                gap: 5px;
            }

            .main-live-box {
                border-radius: 14px;
                border: 2px solid #FF4500;
                aspect-ratio: 16/9;
                margin: 0;
            }

            .live-logo-badge {
                padding: 5px 12px;
                top: 8px;
            }

            .live-logo-badge img {
                height: 20px;
            }

            .btn-enter-live {
                padding: 6px 18px;
                font-size: 11px;
                letter-spacing: 0.3px;
            }

            .side-live-boxes {
                display: flex;
                grid-template-columns: repeat(3, 1fr);
                gap: 5px;
                height: auto;
                width: 100%;
                margin: 0;
                padding: 0;
                margin-bottom: 50px;
            }

            .side-live-box {
                border-radius: 8px;
                border: 2px solid #FF4500;
                aspect-ratio: 1;
                position: relative;
                width: 100%;
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            .side-live-content {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }

            .side-live-content img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .side-live-host {
                top: 4px;
                left: 4px;
                gap: 2px;
                padding: 2px 4px;
                border-radius: 6px;
            }

            .side-live-host-avatar {
                width: 12px !important;
                height: 12px !important;
            }

            .side-live-host-name {
                font-size: 7px;
                max-width: 40px;
            }

            .side-live-badge {
                top: 4px;
                right: 4px;
                padding: 2px 4px;
                border-radius: 6px;
                font-size: 6px;
                gap: 2px;
            }

            .side-live-badge i {
                font-size: 6px;
            }

            .side-live-enter-btn {
                bottom: 4px;
                padding: 3px 8px;
                border-radius: 10px;
                font-size: 8px;
            }
        }

        /* ============ PROMOTIONAL BANNER SLIDER ============ */
        .promo-banner-section {
            padding: 40px 20px 60px;
            position: relative;
            background: #000;
        }

        .hot-badge {
            position: absolute;
            top: 0px;
            left: 20px;
            z-index: 10;
            width: auto;
            max-width: 70px;
        }

        .hot-badge img {
            width: 100%;
            height: auto;
            display: block;
            filter: drop-shadow(0 4px 12px rgba(255, 69, 0, 0.5));
        }

        .promo-swiper-container {
            margin-top: 0px;
            /*padding: 0 50px;*/
            position: relative;
        }

        .promo-slide {
            border-radius: 16px;
            overflow: visible;
            transition: transform 0.3s ease;
            position: relative;
        }

        .promo-slide img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3),
                        0 0 20px rgba(255, 215, 0, 0.3);
            transition: all 0.3s ease;
        }

        /* Swiper Navigation Buttons */
        .promo-button-prev,
        .promo-button-next {
            width: 45px;
            height: 45px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            border: 2px solid #FF4500;
        }

        .promo-button-prev {
            left: 0;
        }

        .promo-button-next {
            right: 0;
        }


        .promo-button-prev::after,
        .promo-button-next::after {
            font-size: 20px;
            font-weight: bold;
        }

        /* Swiper Pagination */
        .promo-pagination {
            bottom: -30px !important;
        }

        .promo-pagination .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: #666;
            opacity: 1;
            transition: all 0.3s ease;
        }

        .promo-pagination .swiper-pagination-bullet-active {
            background: #FF4500;
            width: 30px;
            border-radius: 6px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .promo-banner-section {
                padding: 15px 8px 40px;
                margin: 0;
            }

            .hot-badge {
                left: 10px;
                top: -5px;
                max-width: 45px;
            }

            .promo-button-prev,
            .promo-button-next {
                width: 30px;
                height: 30px;
                background: #FF4500;
            }

            .promo-button-prev::after,
            .promo-button-next::after {
                font-size: 16px;
            }

            .promo-slide {
                border-radius: 12px;
            }

            .promo-slide img {
                border-radius: 12px;
            }

            .promo-pagination {
                bottom: -20px !important;
            }

            .promo-pagination .swiper-pagination-bullet {
                width: 8px;
                height: 8px;
            }

            .promo-pagination .swiper-pagination-bullet-active {
                width: 20px;
            }
        }

        /* ============ NEWS SECTION ============ */
        .news-section {
            padding: 40px 20px 60px;
            background: transparent;
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
            width: 50%;
            /*max-width: 500px;*/
            height: auto;
            object-fit: contain;
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
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .news-grid {
                grid-template-columns: 1fr;
            }

            .news-item-image {
                width: 150px;
            }
        }

        @media (max-width: 768px) {
            .news-section {
                padding: 20px 8px 40px;
                margin: 0;
            }

            .section-title-text {
                font-size: 20px;
                letter-spacing: 2px;
            }

            .section-title-line {
                display: none;
            }

            .section-title {
                gap: 0;
                margin-bottom: 20px;
            }

            .news-grid {
                grid-template-columns: 1fr;
                gap: 0;
                padding: 8px;
                border: 2px solid #FF3C00;
                border-radius: 16px;
            }

            .news-main {
                border-radius: 12px;
                margin-bottom: 15px;
            }

            .news-list {
                gap: 12px;
            }

            .news-item {
                flex-direction: row;
                margin-bottom: 12px;
                border-radius: 12px;
            }

            .news-item-image {
                width: 100px;
                height: auto;
                min-height: 100px;
            }

            .news-item-content {
                padding: 10px 12px;
            }

            .news-item-title {
                font-size: 12px;
                margin-bottom: 5px;
                -webkit-line-clamp: 2;
                display: -webkit-box;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .news-item-description {
                font-size: 11px;
                line-height: 1.4;
                -webkit-line-clamp: 2;
            }
        }

        /* ============ APP DOWNLOAD SECTION ============ */
        .app-download-section {
            padding: 40px 20px;
        }

        .app-download-banner {
            width: 100%;
            border-radius: 24px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .app-download-banner img {
            width: 100%;
            height: auto;
            display: block;
        }

        @media (max-width: 768px) {
            .app-download-section {
                padding: 20px 8px;
                margin: 0;
            }
        }

        .livestream-container {
            background: rgba(0, 0, 0, 0.8);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .livestream-header {
            background: #dc2626;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .viewer-count {
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
        }

        .livestream-content {
            background: linear-gradient(45deg, #dc2626, #f59e0b);
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .video-player {
            width: 100%;
            height: 100%;
            background: #000;
        }

        .video-player video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .stream-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            text-align: center;
        }

        .livestream-title {
            text-align: center;
            color: white;
            font-size: 48px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            z-index: 2;
            position: relative;
        }

        .decorative-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="30" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="60" cy="70" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="30" cy="80" r="2.5" fill="rgba(255,255,255,0.1)"/></svg>');
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .sidebar {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .news-section h3 {
            color: #ffffff;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .news-item {
            padding: 15px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .news-item:last-child {
            border-bottom: none;
        }

        .news-item h5 {
            color: #1f2937;
            margin-bottom: 8px;
        }

        .news-item p {
            color: #ffffff;
            font-size: 14px;
            margin: 0;
        }

        .app-download {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin-top: 20px;
        }

        .app-download h4 {
            margin-bottom: 15px;
        }

        .download-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .download-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            transition: background 0.3s;
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
            border: 1px solid #ffffff;
            background-color: #2d2d2d !important;
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
        }

        .bank-digit {
            width: 60px;
            height: 60px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            color: #FFFFFF;
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

        /* Chat Styles */
        .chat-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: 500px;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background: #dc2626;
            color: white;
            padding: 15px 20px;
            border-radius: 12px 12px 0 0;
            font-weight: bold;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            max-height: 350px;
        }

        .chat-message {
            margin-bottom: 10px;
            padding: 8px 12px;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 14px;
        }

        .chat-message .username {
            font-weight: bold;
            color: #dc2626;
            margin-right: 8px;
        }

        .chat-message .message-text {
            color: #333;
        }

        .chat-input-container {
            padding: 15px;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 0 0 12px 12px;
        }

        .chat-input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #d1d5db;
            border-radius: 25px;
            outline: none;
            font-size: 14px;
        }

        .chat-input:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
        }

        .chat-send-btn {
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            margin-left: 10px;
            cursor: pointer;
            font-size: 14px;
        }


        .chat-send-btn:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        .login-required {
            text-align: center;
            padding: 20px;
            color: #6b7280;
        }

        .login-required button {
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            margin-top: 10px;
            cursor: pointer;
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
                    <video id="home-video-player"
                           autoplay
                           muted
                           loop
                           playsinline
                           style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </video>

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
                <div class="side-live-box" data-live-index="0">
                    <div class="side-live-content">
                        <img src="{{ asset('images/738x512 3.png') }}" alt="Live Stream">
                        <div class="side-live-host">
                            <img src="https://ui-avatars.com/api/?name=Host&background=FF4500&color=fff"
                                 alt="Host" class="side-live-host-avatar">
                            <span class="side-live-host-name">Đang cập nhật...</span>
                        </div>
                        <div class="side-live-badge">
                            <i class="fas fa-clock"></i>
                            <span class="badge-text">Sắp diễn ra</span>
                        </div>
                        <button class="side-live-enter-btn">VÀO PHÒNG</button>
                    </div>
                </div>
                <div class="side-live-box" data-live-index="1">
                    <div class="side-live-content">
                        <img src="{{ asset('images/738x512 3.png') }}" alt="Live Stream">
                        <div class="side-live-host">
                            <img src="https://ui-avatars.com/api/?name=Host&background=FF4500&color=fff"
                                 alt="Host" class="side-live-host-avatar">
                            <span class="side-live-host-name">Đang cập nhật...</span>
                        </div>
                        <div class="side-live-badge">
                            <i class="fas fa-clock"></i>
                            <span class="badge-text">Sắp diễn ra</span>
                        </div>
                        <button class="side-live-enter-btn">VÀO PHÒNG</button>
                    </div>
                </div>
                <div class="side-live-box" data-live-index="2">
                    <div class="side-live-content">
                        <img src="{{ asset('images/738x512 3.png') }}" alt="Live Stream">
                        <div class="side-live-host">
                            <img src="https://ui-avatars.com/api/?name=Host&background=FF4500&color=fff"
                                 alt="Host" class="side-live-host-avatar">
                            <span class="side-live-host-name">Đang cập nhật...</span>
                        </div>
                        <div class="side-live-badge">
                            <i class="fas fa-clock"></i>
                            <span class="badge-text">Sắp diễn ra</span>
                        </div>
                        <button class="side-live-enter-btn">VÀO PHÒNG</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Promotional Banner Slider -->
    <div class="promo-banner-section">
        <div class="hot-badge">
            <img src="{{ asset('images/Frame 2147223991.png') }}" alt="Vui Tết Trung Thu - Phát Thưởng 15.000 Tỷ">
        </div>

        <div class="promo-swiper-container">
            <div class="swiper promoSwiper">
                <div class="swiper-wrapper">
                    @forelse($slides as $slide)
                        <div class="swiper-slide promo-slide">
                            @if($slide->link)
                                <a href="{{ $slide->link }}" target="_blank">
                                    <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}">
                                </a>
                            @else
                                <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}">
                            @endif
                        </div>
                    @empty
                        <!-- Fallback slides if no slides in database -->
                        <div class="swiper-slide promo-slide">
                            <img src="{{ asset('images/image 77.png') }}" alt="Vui Tết Trung Thu - Phát Thưởng 15.000 Tỷ">
                        </div>
                        <div class="swiper-slide promo-slide">
                            <img src="{{ asset('images/image 78.png') }}" alt="Đua Top Đặt Cược - Thưởng Lớn Đêm Trắng">
                        </div>
                        <div class="swiper-slide promo-slide">
                            <img src="{{ asset('images/image 79.png') }}" alt="Trúng Thưởng Đoàn Viên - Quà Tặng Cao Cấp U888">
                        </div>
                    @endforelse
                </div>

                <!-- Navigation buttons -->
                <div class="swiper-button-prev promo-button-prev"></div>
                <div class="swiper-button-next promo-button-next"></div>

                <!-- Pagination -->
                <div class="swiper-pagination promo-pagination"></div>
            </div>
        </div>
    </div>

    <!-- News Section -->
    <div class="news-section">
        <!-- Section Title -->
        <div class="section-title">
            <div class="section-title-line left">
                <img src="{{ asset('images/Group 2087325152.png') }}" alt="Decorative Line">
            </div>
            <h2 class="section-title-text">TIN TỨC</h2>
            <div class="section-title-line right">
                <img src="{{ asset('images/Group 2087325152.png') }}" alt="Decorative Line">
            </div>
        </div>

        <!-- News Grid (Dynamic from Database) -->
        <div class="news-grid">
            @if(isset($mainPost) && $mainPost)
                <!-- Main News (Left) - Latest Post -->
                <div class="news-main">
                    <a href="{{ route('posts.show', $mainPost->slug) }}">
                        @if($mainPost->featured_image)
                            <img src="{{ asset('storage/' . $mainPost->featured_image) }}"
                                 alt="{{ $mainPost->title }}"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/738x512 4.png') }}" alt="{{ $mainPost->title }}">
                        @endif
                    </a>
                </div>

                <!-- News List (Right) - Other Posts -->
                <div class="news-list">
                    @if(isset($sidePosts) && $sidePosts->count() > 0)
                        @foreach($sidePosts as $post)
                        <div class="news-item">
                            <div class="news-item-image">
                                <a href="{{ route('posts.show', $post->slug) }}">
                                    @if($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}"
                                             alt="{{ $post->title }}"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('images/738x512 3.png') }}" alt="{{ $post->title }}">
                                    @endif
                                </a>
                            </div>
                            <div class="news-item-content">
                                <h3 class="news-item-title">
                                    <a href="{{ route('posts.show', $post->slug) }}" style="color: inherit; text-decoration: none;">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="news-item-description">
                                    {{ $post->short_description ?? Str::limit(strip_tags($post->content), 200) }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <!-- Fallback if no side posts -->
                        <div class="news-item">
                            <div class="news-item-image">
                                <img src="{{ asset('images/738x512 3.png') }}" alt="News">
                            </div>
                            <div class="news-item-content">
                                <h3 class="news-item-title">Chưa có tin tức</h3>
                                <p class="news-item-description">Vui lòng quay lại sau để xem tin tức mới nhất!</p>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <!-- Fallback if no posts -->
                <div class="news-main">
                    <img src="{{ asset('images/738x512 4.png') }}" alt="No News">
                </div>
                <div class="news-list">
                    <div class="news-item">
                        <div class="news-item-image">
                            <img src="{{ asset('images/738x512 3.png') }}" alt="News">
                        </div>
                        <div class="news-item-content">
                            <h3 class="news-item-title">Chưa có tin tức</h3>
                            <p class="news-item-description">Hãy tạo bài viết đầu tiên trong Admin Panel!</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- App Download Section -->
    <div class="app-download-section">
        <div class="app-download-banner">
            <img src="{{ asset('images/Frame 2147224090.png') }}" alt="U888 - Tải App Android & iOS">
        </div>
    </div>

    <!-- Hidden Chat Container (will be shown in modal when clicking live) -->
    <div class="col-lg-4" style="display: none;">
                    <!-- Chat Section -->
                    <div class="chat-container mb-4">
                        <div class="chat-header">
                            <i class="fas fa-comments me-2"></i>Chat Trực Tiếp
                            <span class="float-end">
                                <i class="fas fa-users me-1"></i>
                                <span id="online-count">0</span>
                            </span>
                        </div>
                        <div class="chat-messages" id="chat-messages">
                            <!-- Messages will be loaded here -->
                        </div>
                        <div class="chat-input-container" id="chat-input-container">
                            @auth
                                <div class="d-flex">
                                    <input type="text" id="chat-input" class="chat-input" placeholder="Nhập tin nhắn..." maxlength="500">
                                    <button id="send-btn" class="chat-send-btn">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            @else
                                <div class="login-required">
                                    <p>Bạn cần đăng nhập để chat</p>
                                    <button data-bs-toggle="modal" data-bs-target="#loginModal">
                                        Đăng nhập ngay
                                    </button>
                                </div>
                            @endauth
                        </div>
                    </div>

                    <div class="sidebar">
                        <!-- News Section -->
                        <div class="news-section">
                            <h3><i class="fas fa-newspaper me-2"></i>TIN TỨC</h3>
                            <div class="news-item">
                                <h5>XEM LIVE THẢ GA - NHẬN QUÀ CỰC ĐÁ</h5>
                                <p>XEM LIVE THẢ GA - NHẬN QUÀ CỰC ĐÁ</p>
                            </div>
                        </div>
                    </div>

                    <!-- App Download Section -->
                    <div class="app-download">
                        <h4>TẢI APP NGAY</h4>
                        <div class="download-buttons">
                            <a href="#" class="download-btn">
                                <i class="fab fa-google-play me-1"></i>
                                Google Play
                            </a>
                            <a href="#" class="download-btn">
                                <i class="fab fa-apple me-1"></i>
                                App Store
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<!-- HLS.js -->
<script src="{{ asset('js/hls.min.js') }}"></script>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    // Global variables
    let isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    let currentUser = @json(Auth::user());
    let currentLiveData = null;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Swiper for Promotional Banners - Always show 3 slides
        const promoSwiper = new Swiper('.promoSwiper', {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,
            centeredSlides: false,
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
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
            },
        });

        // Initialize Bootstrap Dropdown
        if (typeof bootstrap !== 'undefined') {
            const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');
            dropdowns.forEach(dropdown => {
                new bootstrap.Dropdown(dropdown);
            });
        }

        // Initialize app
        initializeApp();
    });

    function initializeApp() {
        loadAllLiveStreams();
    }

    function loadAllLiveStreams() {
        fetch('/api/live/all-streams')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.main_live) {
                        updateMainLiveDisplay(data.main_live);
                    } else {
                        playAdsWhenNoLive();
                    }

                    if (data.other_lives && data.other_lives.length > 0) {
                        updateSideLiveBoxes(data.other_lives);
                    }
                }
            })
            .catch(error => {
                playAdsWhenNoLive();
            });
    }

    function playAdsWhenNoLive() {
        const videoPlayer = document.getElementById('home-video-player');
        const playAds = '{{ asset('images/advertise.mp4') }}';

        if (videoPlayer) {
            videoPlayer.style.display = 'block';
            videoPlayer.src = playAds;
            videoPlayer.loop = true;
            videoPlayer.play().catch(e => {});
        }
    }

    function updateMainLiveDisplay(liveData) {
        currentLiveData = liveData;

        const btnEnterLive = document.getElementById('btn-enter-live');
        const videoPlayer = document.getElementById('home-video-player');
        const liveOverlay = document.getElementById('main-live-overlay');
        const playAds = '{{ asset("images/advertise.mp4") }}';

        if (!liveData) {
            if (videoPlayer) {
                videoPlayer.style.display = 'block';
                videoPlayer.src = playAds;
                videoPlayer.loop = true;
                videoPlayer.play().catch(e => {});
            }

            if (liveOverlay) {
                liveOverlay.style.display = 'none';
            }

            return;
        }

        const now = new Date();
        const liveDateTime = new Date(liveData.live_datetime);
        const isActuallyLiveNow = now >= liveDateTime;

        if (isActuallyLiveNow) {
            if (videoPlayer) {
                videoPlayer.style.display = 'none';
                videoPlayer.pause();
                videoPlayer.src = '';
            }

            if (liveOverlay) {
                liveOverlay.style.display = 'flex';
            }

            if (btnEnterLive) {
                btnEnterLive.style.display = 'block';
                btnEnterLive.textContent = 'VÀO PHÒNG LIVE';
                btnEnterLive.classList.add('live-active');
                btnEnterLive.onclick = function() {
                    enterLiveRoom(liveData);
                };
            }

        } else {
            if (videoPlayer) {
                videoPlayer.style.display = 'block';
                videoPlayer.src = playAds;
                videoPlayer.loop = true;
                videoPlayer.play().catch(e => {});
            }

            if (liveOverlay) {
                liveOverlay.style.display = 'none';
            }

            const checkInterval = setInterval(() => {
                const nowCheck = new Date();
                const liveTimeCheck = new Date(liveData.live_datetime);

                if (nowCheck >= liveTimeCheck) {
                    clearInterval(checkInterval);
                    updateMainLiveDisplay(liveData);
                }
            }, 5000);
        }
    }

    function updateSideLiveBoxes(otherLives) {
        const sideLiveBoxes = document.querySelectorAll('.side-live-box');

        otherLives.forEach((live, index) => {
            if (sideLiveBoxes[index]) {
                const box = sideLiveBoxes[index];
                const hostAvatar = box.querySelector('.side-live-host-avatar');
                const hostName = box.querySelector('.side-live-host-name');
                const badge = box.querySelector('.side-live-badge');
                const badgeText = box.querySelector('.badge-text');
                const badgeIcon = badge ? badge.querySelector('i') : null;
                const enterBtn = box.querySelector('.side-live-enter-btn');

                // Update host info
                if (live.host) {
                    if (hostAvatar) {
                        hostAvatar.src = live.host.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(live.host.name)}&background=FF4500&color=fff`;
                    }
                    if (hostName) {
                        hostName.textContent = live.host.name;
                    }
                }

                // Update badge based on live status
                if (badge && badgeText) {
                    if (live.is_live_now) {
                        badge.classList.add('live-now');
                        badgeText.textContent = 'Đang diễn ra';
                        if (badgeIcon) {
                            badgeIcon.className = 'fas fa-circle';
                        }
                    } else {
                        badge.classList.remove('live-now');
                        badgeText.textContent = 'Sắp diễn ra';
                        if (badgeIcon) {
                            badgeIcon.className = 'fas fa-clock';
                        }
                    }
                }

                // Add click handler to button
                if (enterBtn) {
                    enterBtn.onclick = function(e) {
                        e.stopPropagation();
                        enterLiveRoom(live);
                    };
                }
            }
        });
    }

    function enterLiveRoom(liveData) {
        const liveRoomUrl = `{{ url('/live-room') }}/${liveData.id}`;
        window.location.href = liveRoomUrl;
    }

    // Utility function to format time
    function formatTime(timestamp) {
        const date = new Date(timestamp);
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${hours}:${minutes}`;
    }
</script>
@endpush
