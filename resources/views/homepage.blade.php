<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J88 - Trang chủ</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <style>
        body {
            background: #000000;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }

        /* ============ NEW U888 HEADER DESIGN ============ */
        .header {
            background: linear-gradient(180deg, #1F1F1F 0%, #000000 100%);
            height: 99px;
            box-shadow: 0px 5px 5.8px 0px rgba(0, 0, 0, 0.55);
            position: relative;
            z-index: 1000;
        }

        .header .container-fluid {
            max-width: 1920px;
            height: 100%;
            padding: 0 40px;
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

        .logo-u888:hover {
            transform: scale(1.02);
        }

        .logo-u888 img {
            height: 50px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .tagline {
            color: #FF4500;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-left: 10px;
            text-shadow: 0 0 8px rgba(255, 69, 0, 0.3);
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

        .nav-item:hover {
            color: #FF4500;
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

        .nav-item:hover::after {
            width: 100%;
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

        .btn-login:hover {
            background: linear-gradient(135deg, #FF6347 0%, #FF4500 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 69, 0, 0.6);
            color: white;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Dropdown Menu for Logged In User */
        .header .dropdown {
            position: relative;
        }

        .header .dropdown-menu {
            background: linear-gradient(180deg, #1F1F1F 0%, #0a0a0a 100%);
            border: 1px solid rgba(255, 69, 0, 0.2);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8), 0 0 20px rgba(255, 69, 0, 0.1);
            margin-top: 12px;
            min-width: 220px;
            padding: 8px 0;
            animation: dropdownFadeIn 0.2s ease-out;
        }

        @keyframes dropdownFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header .dropdown-item {
            color: white;
            padding: 12px 20px;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header .dropdown-item i {
            width: 18px;
            text-align: center;
        }

        .header .dropdown-item:hover {
            background: rgba(255, 69, 0, 0.15);
            color: #FF4500;
            padding-left: 24px;
        }

        .header .dropdown-item:active {
            background: rgba(255, 69, 0, 0.25);
        }

        .header .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 8px 0;
        }

        /* Logout specific styling */
        .header .dropdown-item[onclick*="logout"] {
            color: #ff6b6b;
        }

        .header .dropdown-item[onclick*="logout"]:hover {
            color: #ff4444;
            background: rgba(255, 69, 0, 0.15);
        }

        /* User button when logged in */
        .header .btn-login.dropdown-toggle {
            padding-right: 20px;
            position: relative;
        }

        .header .btn-login.dropdown-toggle::after {
            margin-left: 8px;
        }

        /* Responsive adjustments */
        @media (max-width: 1400px) {
            .header-left {
                gap: 35px;
            }

            .nav-menu {
                gap: 25px;
            }

            .tagline {
                font-size: 11px;
            }
        }

        @media (max-width: 1200px) {
            .header-left {
                gap: 25px;
            }

            .tagline {
                display: none;
            }

            .nav-menu {
                gap: 20px;
            }

            .nav-item {
                font-size: 14px;
            }
        }

        @media (max-width: 992px) {
            .header {
                height: auto;
                padding: 15px 0;
            }

            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .header-left {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .logo-container {
                flex-direction: column;
                gap: 10px;
            }

            .logo-u888 img {
                height: 40px;
            }

            .nav-menu {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }

            .header-right {
                width: 100%;
                justify-content: center;
            }

            .btn-login {
                width: 100%;
                max-width: 300px;
            }
        }

        .main-content {
            padding: 0;
            margin: 0;
        }

        /* ============ NOTIFICATION BANNER ============ */
        .notification-banner {
            background: linear-gradient(135deg, #FF4500 0%, #FF6347 100%);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 12px rgba(255, 69, 0, 0.3);
            overflow: hidden;
        }

        .notification-icon {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            object-fit: contain;
            animation: bell-ring 2s ease-in-out infinite;
        }

        @keyframes bell-ring {
            0%, 100% { transform: rotate(0deg); }
            10%, 30% { transform: rotate(-10deg); }
            20%, 40% { transform: rotate(10deg); }
        }

        .notification-text {
            flex: 1;
            color: white;
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
        }

        .notification-text span {
            display: inline-block;
            padding-left: 100%;
            animation: scroll-left 30s linear infinite;
        }

        @keyframes scroll-left {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        /* ============ LIVE STREAMS GRID ============ */
        .live-streams-section {
            padding: 30px 40px;
            max-width: 1920px;
            margin: 0 auto;
        }

        .streams-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 20px;
            align-items: start;
        }

        /* Main Live Stream Box */
        .main-live-box {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: linear-gradient(135deg, #8B4513 0%, #4a2409 100%);
            box-shadow: 0 10px 40px rgba(255, 69, 0, 0.4);
            aspect-ratio: 16/9;
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
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .live-logo-badge {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 10px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .live-logo-badge img {
            height: 40px;
            width: auto;
        }

        .btn-enter-live {
            background: linear-gradient(135deg, #FF4500 0%, #FF6347 100%);
            color: white;
            border: none;
            padding: 16px 48px;
            border-radius: 50px;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(255, 69, 0, 0.5);
            transition: all 0.3s ease;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .btn-enter-live:hover {
            transform: scale(1.08);
            box-shadow: 0 12px 32px rgba(255, 69, 0, 0.7);
        }

        /* Side Live Boxes */
        .side-live-boxes {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .side-live-box {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            background: #2a2a2a;
            border: 3px solid #FF4500;
            box-shadow: 0 6px 20px rgba(255, 69, 0, 0.3);
            aspect-ratio: 16/9;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .side-live-box:hover {
            transform: translateX(-5px);
            box-shadow: 0 8px 28px rgba(255, 69, 0, 0.5);
            border-color: #FF6347;
        }

        .side-live-content {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .side-live-content img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .side-live-host {
            position: absolute;
            top: 10px;
            left: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(0, 0, 0, 0.8);
            padding: 4px 10px;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .side-live-host-avatar {
            width: 22px !important;
            height: 22px !important;
            border-radius: 50%;
            border: 2px solid #FF4500;
            object-fit: cover;
            flex-shrink: 0;
        }

        .side-live-host-name {
            color: white;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 120px;
        }

        .side-live-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: linear-gradient(135deg, #FF0000 0%, #CC0000 100%);
            color: white;
            padding: 5px 10px;
            border-radius: 14px;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.4);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .side-live-badge i {
            color: #FFD700;
            font-size: 8px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .streams-grid {
                grid-template-columns: 1fr;
            }

            .side-live-boxes {
                flex-direction: row;
                overflow-x: auto;
            }

            .side-live-box {
                min-width: 300px;
            }
        }

        @media (max-width: 768px) {
            .live-streams-section {
                padding: 20px 15px;
            }

            .btn-enter-live {
                padding: 12px 32px;
                font-size: 16px;
            }
        }

        /* ============ PROMOTIONAL BANNER SLIDER ============ */
        .promo-banner-section {
            padding: 30px 40px 60px;
            max-width: 1920px;
            margin: 0 auto;
            position: relative;
        }

        .hot-badge {
            position: absolute;
            top: -10px;
            left: 50px;
            z-index: 10;
            width: auto;
            max-width: 150px;
        }

        .hot-badge img {
            width: 100%;
            height: auto;
            display: block;
            filter: drop-shadow(0 6px 20px rgba(255, 69, 0, 0.6));
            animation: float-badge 3s ease-in-out infinite;
        }

        @keyframes float-badge {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }


        @keyframes flame {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.1) rotate(5deg); }
        }

        .promo-swiper-container {
            margin-top: 20px;
            padding: 0 50px;
            position: relative;
        }

        .promo-slide {
            border-radius: 16px;
            overflow: visible;
            transition: transform 0.3s ease;
            position: relative;
        }

        .promo-slide:hover {
            transform: translateY(-5px);
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

        .promo-slide:hover img {
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.4),
                        0 0 30px rgba(255, 215, 0, 0.5);
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

        .promo-button-prev:hover,
        .promo-button-next:hover {
            background: #FF4500;
            transform: translateY(-50%) scale(1.1);
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
                padding: 20px 15px 50px;
            }

            .hot-badge {
                left: 15px;
                font-size: 16px;
                padding: 6px 15px;
            }

            .promo-swiper-container {
                padding: 0 40px;
            }

            .promo-button-prev,
            .promo-button-next {
                width: 35px;
                height: 35px;
            }
        }

        /* ============ NEWS SECTION ============ */
        .news-section {
            padding: 40px 40px 60px;
            max-width: 1920px;
            margin: 0 auto;
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
            width: 100%;
            max-width: 500px;
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
                padding: 30px 15px 50px;
            }

            .section-title-text {
                font-size: 24px;
            }

            .news-item {
                flex-direction: column;
            }

            .news-item-image {
                width: 100%;
                height: 200px;
            }

            .section-title-line {
                display: none;
            }

            .section-title {
                gap: 0;
            }
        }

        /* ============ APP DOWNLOAD SECTION ============ */
        .app-download-section {
            padding: 40px 40px;
            max-width: 1920px;
            margin: 0 auto;
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
                padding: 30px 15px;
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

        .download-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
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

        .chat-send-btn:hover {
            background: #b91c1c;
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
    @vite(['resources/js/app.js'])
    <!-- HLS.js for HLS stream support -->
    <script src="{{ asset('js/hls.min.js') }}"></script>
</head>
<body>
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

                    <!-- Navigation Menu -->
                    <nav class="nav-menu">
                        <a href="#" class="nav-item active">Trang chủ</a>
                        <a href="#" class="nav-item">Quà tặng</a>
                        <a href="#" class="nav-item">Tải APP</a>
                        <a href="#" class="nav-item">Nhận Code</a>
                        <a href="#" class="nav-item">Phần hồi</a>
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
        <img src="{{ asset('images/image_2025-07-05_16-38-07 1.png') }}" alt="Notification" class="notification-icon">
        <div class="notification-text">
            <span id="notification-scroll">
                🎁 THỂ THAO BẢO HIỂM CƯỢC THUA LÊN ĐẾN 5% 🎁 THỂ THAO THẮNG LIÊN TIẾP NHẬN THƯỞNG LÊN ĐẾN 8.888K 🎁 HÃY CÙNG BẠN BÈ THAM GIA ABC8 VÀ NHẬN THƯỞNG NHÉ 🎁
            </span>
                                </div>
                            </div>

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

    <!-- Promotional Banner Slider -->
    <div class="promo-banner-section">
        <div class="hot-badge">
            <img src="{{ asset('images/Frame 2147223991.png') }}" alt="Vui Tết Trung Thu - Phát Thưởng 15.000 Tỷ">
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
                        <img src="{{ asset('images/image 79.png') }}" alt="Trúng Thưởng Đoàn Viên - Quà Tặng Cao Cấp U888">
                    </div>
                    <div class="swiper-slide promo-slide">
                        <img src="{{ asset('images/image 79.png') }}" alt="Trúng Thưởng Đoàn Viên - Quà Tặng Cao Cấp U888">
                    </div>
                    <div class="swiper-slide promo-slide">
                        <img src="{{ asset('images/image 79.png') }}" alt="Trúng Thưởng Đoàn Viên - Quà Tặng Cao Cấp U888">
                    </div>
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

        <!-- News Grid -->
        <div class="news-grid">
            <!-- Main News (Left) -->
            <div class="news-main">
                <img src="{{ asset('images/738x512 4.png') }}" alt="Sinh Nhật Vàng - MEGALIVE Rinh Xe Sang">
            </div>

            <!-- News List (Right) -->
            <div class="news-list">
                <div class="news-item">
                    <div class="news-item-image">
                        <img src="{{ asset('images/738x512 3.png') }}" alt="News 1">
                    </div>
                    <div class="news-item-content">
                        <h3 class="news-item-title">SINH NHẬT VÀNG - MEGALIVE RINH XE SANG</h3>
                        <p class="news-item-description">
                            Chào mừng sinh nhật đặc biệt, chương trình MEGALIVE hoành tráng trở lại với hàng loạt quà tặng giá trị! Đừng bỏ lỡ cơ hội nhận ngay chiếc xe sang đẳng cấp, cùng hàng ngàn phần quà hấp dẫn khác. Chỉ cần tham gia livestream, bạn có thể trở thành chủ nhân may mắn tiếp theo. Hãy cùng chúng tôi đón sinh nhật tưng bừng - quà rinh liền tay!
                        </p>
                    </div>
                </div>

                <div class="news-item">
                    <div class="news-item-image">
                        <img src="{{ asset('images/738x512 3.png') }}" alt="News 2">
                    </div>
                    <div class="news-item-content">
                        <h3 class="news-item-title">SINH NHẬT VÀNG - MEGALIVE RINH XE SANG</h3>
                        <p class="news-item-description">
                            Chào mừng sinh nhật đặc biệt, chương trình MEGALIVE hoành tráng trở lại với hàng loạt quà tặng giá trị! Đừng bỏ lỡ cơ hội nhận ngay chiếc xe sang đẳng cấp, cùng hàng ngàn phần quà hấp dẫn khác. Chỉ cần tham gia livestream, bạn có thể trở thành chủ nhân may mắn tiếp theo. Hãy cùng chúng tôi đón sinh nhật tưng bừng - quà rinh liền tay!
                        </p>
                    </div>
                </div>

                <div class="news-item">
                    <div class="news-item-image">
                        <img src="{{ asset('images/738x512 3.png') }}" alt="News 3">
                    </div>
                    <div class="news-item-content">
                        <h3 class="news-item-title">SINH NHẬT VÀNG - MEGALIVE RINH XE SANG</h3>
                        <p class="news-item-description">
                            Chào mừng sinh nhật đặc biệt, chương trình MEGALIVE hoành tráng trở lại với hàng loạt quà tặng giá trị! Đừng bỏ lỡ cơ hội nhận ngay chiếc xe sang đẳng cấp, cùng hàng ngàn phần quà hấp dẫn khác. Chỉ cần tham gia livestream, bạn có thể trở thành chủ nhân may mắn tiếp theo. Hãy cùng chúng tôi đón sinh nhật tưng bừng - quà rinh liền tay!
                        </p>
                    </div>
                </div>
            </div>
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

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="j88-logo">J88</div>
                    <h4 class="text-center mb-4">Đăng Nhập</h4>

                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="accountName" class="form-label">Tên tài khoản của bạn</label>
                            <input type="text" class="form-control" id="accountName" placeholder="Vui Lòng Nhập Tên Tài Khoản" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Xác nhận 4 số cuối tài khoản ngân hàng</label>
                            <div class="bank-account-inputs justify-content-center">
                                <input type="text" class="form-control bank-digit" maxlength="1" id="digit1" required>
                                <input type="text" class="form-control bank-digit" maxlength="1" id="digit2" required>
                                <input type="text" class="form-control bank-digit" maxlength="1" id="digit3" required>
                                <input type="text" class="form-control bank-digit" maxlength="1" id="digit4" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-confirm">
                            <span class="btn-text">XÁC NHẬN</span>
                            <span class="loading">
                                <i class="fas fa-spinner fa-spin"></i>
                                Đang xác thực...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Pusher for realtime (if needed for fallback) -->
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0-rc2/dist/web/pusher.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Global variables
        let isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        let currentUser = @json(Auth::user());
        let echo = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Swiper for Promotional Banners
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
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                },
            });
            console.log('✅ Swiper initialized:', promoSwiper);
            // Initialize Bootstrap Dropdown (ensure it works)
            if (typeof bootstrap !== 'undefined') {
                console.log('✅ Bootstrap loaded successfully');
                // Initialize all dropdowns
                const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');
                dropdowns.forEach(dropdown => {
                    new bootstrap.Dropdown(dropdown);
                });
            } else {
                console.warn('⚠️ Bootstrap not loaded');
            }

            // Initialize
            initializeApp();

            // Handle bank account digit inputs
            const bankDigits = document.querySelectorAll('.bank-digit');

            bankDigits.forEach((digit, index) => {
                digit.addEventListener('input', function(e) {
                    if (e.target.value.length === 1 && index < bankDigits.length - 1) {
                        bankDigits[index + 1].focus();
                    }
                });

                digit.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                        bankDigits[index - 1].focus();
                    }
                });
            });

            // Handle form submission
            document.getElementById('loginForm').addEventListener('submit', handleLogin);

            // Handle chat functionality if logged in
            if (isLoggedIn) {
                initializeChat();
            }

            // Check auth status periodically (in case of session changes)
            setInterval(checkAuthStatus, 30000);
        });

        function checkAuthStatus() {
            // Only check if user is not currently logged in
            if (!isLoggedIn) {
                fetch('/api/user', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Not authenticated');
                })
                .then(user => {
                    // User is now authenticated, reload to update UI
                    if (user && user.id) {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    // User still not authenticated, continue
                    console.log('User not authenticated');
                });
            }
        }

        function initializeApp() {
            // Load all live streams
            loadAllLiveStreams();

            // Load online count
            updateOnlineCount();

            // Set up intervals
            setInterval(loadAllLiveStreams, 30000); // Check streams every 30 seconds
            setInterval(updateOnlineCount, 15000); // Update online count every 15 seconds
        }

        function loadAllLiveStreams() {
            fetch('/api/live/all-streams')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateMainLiveDisplay(data.main_live);
                        updateSideLiveBoxes(data.other_lives);
                    }
                })
                .catch(error => {
                    console.error('Error loading live streams:', error);
                });
        }

        function updateMainLiveDisplay(mainLive) {
            const mainLiveBox = document.getElementById('main-live-box');
            const mainLiveContent = document.getElementById('main-live-content');
            const mainLiveImage = document.getElementById('main-live-image');
            const btnEnterLive = document.getElementById('btn-enter-live');

            if (!mainLive) {
                // No live scheduled
                mainLiveImage.src = "{{ asset('images/738x512 3.png') }}";
                btnEnterLive.style.display = 'none';
                return;
            }

            console.log('Main Live:', mainLive);

            if (mainLive.is_live_now) {
                // Live is happening NOW - Show "VÀO PHÒNG LIVE" button
                mainLiveImage.src = mainLive.default_video_url ? mainLive.default_video_url : "{{ asset('images/738x512 3.png') }}";
                btnEnterLive.style.display = 'block';
                btnEnterLive.textContent = 'VÀO PHÒNG LIVE';

                // Add click handler to enter live room
                btnEnterLive.onclick = function() {
                    enterLiveRoom(mainLive);
                };
            } else {
                // Live not started yet - Show default image/video
                if (mainLive.default_video_url && mainLive.default_video_url.match(/\.(mp4|webm|ogg)$/i)) {
                    // Replace image with video
                    mainLiveContent.innerHTML = `
                        <video autoplay muted loop style="width: 100%; height: 100%; object-fit: cover;">
                            <source src="${mainLive.default_video_url}" type="video/mp4">
                        </video>
                        <div class="live-overlay" id="main-live-overlay">
                            <div class="live-logo-badge">
                                <img src="{{ asset('images/u888-abcvip-(2) 1.png') }}" alt="U888 Logo">
                            </div>
                            <button class="btn-enter-live" id="btn-enter-live-countdown" disabled>
                                Sắp bắt đầu: ${mainLive.live_time} - ${mainLive.live_date}
                            </button>
                        </div>
                    `;
                } else {
                    mainLiveImage.src = "{{ asset('images/738x512 3.png') }}";
                    btnEnterLive.style.display = 'block';
                    btnEnterLive.disabled = true;
                    btnEnterLive.textContent = `Sắp bắt đầu: ${mainLive.live_time} - ${mainLive.live_date}`;
                    btnEnterLive.style.opacity = '0.7';
                    btnEnterLive.style.cursor = 'not-allowed';
                }
            }
        }

        function updateSideLiveBoxes(otherLives) {
            const sideBoxesContainer = document.getElementById('side-live-boxes');

            if (!otherLives || otherLives.length === 0) {
                // Keep default placeholders
                return;
            }

            sideBoxesContainer.innerHTML = '';

            // Always show 3 boxes
            for (let i = 0; i < 3; i++) {
                const live = otherLives[i];
                const box = document.createElement('div');
                box.className = 'side-live-box';

                if (live) {
                    const hostAvatar = live.host && live.host.avatar
                        ? live.host.avatar
                        : `https://ui-avatars.com/api/?name=${encodeURIComponent(live.host?.name || 'Host')}&background=FF4500&color=fff`;

                    const hostName = live.host ? live.host.name : 'Đang cập nhật...';
                    const badgeText = live.is_live_now ? 'ĐANG LIVE' : `${live.live_time} - ${live.live_date}`;
                    const badgeIcon = live.is_live_now ? 'fa-circle' : 'fa-clock';

                    box.innerHTML = `
                        <div class="side-live-content">
                            <img src="{{ asset('images/738x512 3.png') }}" alt="Live Stream">
                            <div class="side-live-host">
                                <img src="${hostAvatar}" alt="${hostName}" class="side-live-host-avatar">
                                <span class="side-live-host-name">${hostName}</span>
                            </div>
                            <div class="side-live-badge">
                                <i class="fas ${badgeIcon}"></i>
                                <span>${badgeText}</span>
                            </div>
                        </div>
                    `;

                    // Add click handler if live is happening
                    if (live.is_live_now) {
                        box.style.cursor = 'pointer';
                        box.onclick = function() {
                            enterLiveRoom(live);
                        };
                    }
                } else {
                    // Placeholder
                    box.innerHTML = `
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
                    `;
                }

                sideBoxesContainer.appendChild(box);
            }
        }

        function enterLiveRoom(liveData) {
            console.log('Entering live room:', liveData);

            // TODO: Implement full-screen live room with video player and chat
            // For now, just play the video in the main box
            if (liveData.play_url) {
                const mainLiveContent = document.getElementById('main-live-content');
                mainLiveContent.innerHTML = `
                    <video id="live-video" controls autoplay style="width: 100%; height: 100%; object-fit: cover;">
                        <source src="${liveData.play_url}" type="application/x-mpegURL">
                        Trình duyệt của bạn không hỗ trợ video.
                    </video>
                    <div class="live-overlay" style="background: rgba(0,0,0,0.3); pointer-events: none;">
                        <div class="live-logo-badge">
                            <img src="{{ asset('images/u888-abcvip-(2) 1.png') }}" alt="U888 Logo">
                        </div>
                    </div>
                `;

                // Initialize HLS player if URL is HLS
                if (liveData.play_url.includes('.m3u8')) {
                    initializeVideoPlayer(liveData.play_url);
                }
            }
        }

        function loadStreamStatus() {
            // Legacy function - now using loadAllLiveStreams
            fetch('/api/live/status')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateStreamDisplay(data);
                    }
                })
                .catch(error => {
                    console.error('Error loading stream status:', error);
                });
        }

        function updateStreamDisplay(streamData) {
            const streamContainer = document.getElementById('stream-container');
            const streamTitle = document.getElementById('stream-title');

            // Kiểm tra element tồn tại trước khi sử dụng
            if (!streamContainer || !streamTitle) {
                console.error('Stream elements not found');
                return;
            }

            if (streamData.is_live && streamData.stream_url) {
                // Show live stream
                streamContainer.innerHTML = `
                    <div class="video-player">
                        <video id="live-video" controls autoplay muted>
                            Trình duyệt của bạn không hỗ trợ video.
                        </video>
                    </div>
                `;
                streamTitle.textContent = streamData.live_title || 'ĐANG LIVE';

                // Initialize video player with HLS support
                initializeVideoPlayer(streamData.stream_url);
            } else if (streamData.video_url) {
                // Show default video
                streamContainer.innerHTML = `
                    <div class="video-player">
                        <video controls autoplay muted loop>
                            <source src="${streamData.video_url}" type="video/mp4">
                            Trình duyệt của bạn không hỗ trợ video.
                        </video>
                    </div>
                `;
                streamTitle.textContent = 'ĐẶC BIỆT';
            } else {
                // Show placeholder
                streamContainer.innerHTML = `
                    <div class="stream-placeholder">
                        <div class="decorative-elements"></div>
                        <div class="livestream-title">ĐẶC BIỆT</div>
                    </div>
                `;
            }
        }

        // New function to initialize video player with HLS support
        function initializeVideoPlayer(streamUrl) {
            const video = document.getElementById('live-video');
            if (!video) return;

            // Check if stream URL is HLS (.m3u8)
            if (streamUrl.includes('.m3u8') || streamUrl.includes('m3u8')) {
                // Use HLS.js for HLS streams
                if (typeof Hls !== 'undefined' && Hls.isSupported()) {
                    const hls = new Hls({
                        debug: false,
                        enableWorker: true,
                        lowLatencyMode: true,
                        backBufferLength: 90
                    });

                    hls.loadSource(streamUrl);
                    hls.attachMedia(video);

                    hls.on(Hls.Events.MANIFEST_PARSED, function() {
                        console.log('HLS manifest parsed, starting playback');
                        video.play().catch(e => console.log('Autoplay prevented:', e));
                    });

                    hls.on(Hls.Events.ERROR, function(event, data) {
                        console.error('HLS error:', data);
                        if (data.fatal) {
                            switch(data.type) {
                                case Hls.ErrorTypes.NETWORK_ERROR:
                                    console.log('Fatal network error, trying to recover...');
                                    hls.startLoad();
                                    break;
                                case Hls.ErrorTypes.MEDIA_ERROR:
                                    console.log('Fatal media error, trying to recover...');
                                    hls.recoverMediaError();
                                    break;
                                default:
                                    console.log('Fatal error, cannot recover');
                                    hls.destroy();
                                    break;
                            }
                        }
                    });
                } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                    // Native HLS support (Safari)
                    video.src = streamUrl;
                    video.addEventListener('loadedmetadata', function() {
                        video.play().catch(e => console.log('Autoplay prevented:', e));
                    });
                } else {
                    console.error('HLS is not supported in this browser');
                    video.innerHTML = 'Trình duyệt của bạn không hỗ trợ HLS stream.';
                }
            } else {
                // Regular MP4 or other formats
                video.src = streamUrl;
                video.addEventListener('loadedmetadata', function() {
                    video.play().catch(e => console.log('Autoplay prevented:', e));
                });
            }
        }

        function updateViewerCount() {
            fetch('/api/live/viewer-count')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('viewer-count').textContent = data.viewer_count;
                    }
                })
                .catch(error => {
                    console.error('Error updating viewer count:', error);
                });
        }

        function updateOnlineCount() {
            fetch('/api/chat/online-count')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('online-count').textContent = data.count;
                    }
                })
                .catch(error => {
                    console.error('Error updating online count:', error);
                });
        }

        function initializeChat() {
            // Initialize Reverb (Laravel Echo with Pusher protocol) for real-time chat
            try {
                Echo.channel('live-chat').listen('.new-message', function(data) {
                    console.log('Received new message:', data);
                    addMessageToChat(data);
                })

                console.log('Reverb WebSocket connected successfully');
            } catch (error) {
                console.error('Reverb connection error:', error);
                console.log('Falling back to polling for messages');
                // Fallback to polling for messages
                setInterval(loadChatMessages, 5000);
            }

            // Load initial messages
            loadChatMessages();

            // Set up chat input handlers
            const chatInput = document.getElementById('chat-input');
            const sendBtn = document.getElementById('send-btn');

            if (chatInput && sendBtn) {
                chatInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        sendMessage();
                    }
                });

                sendBtn.addEventListener('click', sendMessage);
            }
        }

        function loadChatMessages() {
            fetch('/api/chat/messages')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayMessages(data.messages);
                    }
                })
                .catch(error => {
                    console.error('Error loading chat messages:', error);
                });
        }

        function displayMessages(messages) {
            const chatMessages = document.getElementById('chat-messages');
            if (!chatMessages) return;

            chatMessages.innerHTML = '';
            messages.forEach(message => {
                addMessageToChat(message);
            });

            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function addMessageToChat(message) {
            const chatMessages = document.getElementById('chat-messages');
            if (!chatMessages) return;

            const messageElement = document.createElement('div');
            messageElement.className = 'chat-message';

            const timeStr = new Date(message.sent_at || message.created_at).toLocaleTimeString('vi-VN', {
                hour: '2-digit',
                minute: '2-digit'
            });

            messageElement.innerHTML = `
                <span class="username">${escapeHtml(message.username)}:</span>
                <span class="message-text">${escapeHtml(message.message)}</span>
                <small class="text-muted ms-2">${timeStr}</small>
            `;

            chatMessages.appendChild(messageElement);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

       function sendMessage() {
    const chatInput = document.getElementById('chat-input');
    const sendBtn = document.getElementById('send-btn');

    if (!chatInput || !sendBtn) return;

    const message = chatInput.value.trim();
    if (!message) return;

    chatInput.disabled = true;
    sendBtn.disabled = true;

    fetch('/api/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ message: message })
    })
    .then(response => {
        if (response.status === 401) {
            // Session expired, reload page
            window.location.reload();
            throw new Error('Phiên đăng nhập đã hết hạn');
        }
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            chatInput.value = '';
        }
    })
    .catch(error => {
        alert('Có lỗi xảy ra khi gửi tin nhắn: ' + error.message);
    })
    .finally(() => {
        chatInput.disabled = false;
        sendBtn.disabled = false;
        chatInput.focus();
    });
}
function checkSession() {
    fetch('/api/check-session', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
    })
    .then(response => {
        if (!response.ok) {
            window.location.reload();
        }
    });
}

// Add this to your initializeApp function:
if (isLoggedIn) {
    setInterval(checkSession, 60000); // Check session every minute
}

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
                        currentUser = data.user; // Add this line
                    alert('Đăng nhập thành công!');
                    // Close modal first
                    const modal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
                    if (modal) {
                        modal.hide();
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
    </script>
</body>
</html>
