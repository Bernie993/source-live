@extends('layouts.app')

@section('title', 'Phòng Live - U888')

@push('styles')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<style>
        .live-room-section {
            padding: 30px 20px;
            width: 100%;
            box-sizing: border-box;
        }

        .live-room-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 20px;
            margin-bottom: 40px;
            align-items: start;
            width: 100%;
        }

        /* Video Column - Contains both header and player */
        .video-column {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Video Header Box (Separate) */
        .video-header-box {
            background: linear-gradient(#EC6612 0%, #F50000 100%);
            border-radius: 24px;
            overflow: visible;
            box-shadow: 0 10px 40px rgba(255, 69, 0, 0.3);
            border: 1px solid #ffffff;
        }

        .video-header {
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 24px;
        }

        /* Video Player Section (Separate) */
        .video-section {
            background: #000;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(255, 69, 0, 0.3);
            border: 6px solid #FF4500;
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
            position: relative;
        }

        .stat-item.share-trigger {
            cursor: pointer;
        }

        .stat-item i {
            font-size: 16px;
        }

        .viewer-count {
            font-size: 16px;
            font-weight: 700;
        }

        /* Share Popup Styles */
        .share-popup {
            position: absolute;
            bottom: calc(100% + 15px);
            right: 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .share-popup.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .share-popup-content {
            background: white;
            border-radius: 30px;
            padding: 12px 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
        }

        .share-popup-arrow {
            position: absolute;
            bottom: -8px;
            right: 30px;
            width: 16px;
            height: 16px;
            background: white;
            transform: rotate(45deg);
        }

        .social-icons-popup {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .copy-button-popup {
            background: #FF4500;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
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
            background: linear-gradient(#EC6612 0%, #F50000 100%);
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(255, 69, 0, 0.5);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            height: 658px;
        }

        .chat-header-wrapper {
            padding: 10px;
        }

        .chat-header {
            background: #380000;
            border-radius: 12px;
            padding: 15px;
            color: white;
            font-weight: 700;
            font-size: 15px;
            line-height: 1.5;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .chat-header-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .chat-header-title img {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }

        .chat-header-info {
            font-size: 13px;
            font-weight: 500;
            opacity: 0.95;
            line-height: 1.6;
        }

        .chat-messages {
            flex: 1;
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
            position: relative;
        }

        .chat-input-icon:hover {
            transform: scale(1.1);
        }

        .emoji-picker {
            position: absolute;
            bottom: 60px;
            left: 12px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 16px;
            display: none;
            width: 320px;
            max-height: 350px;
            overflow-y: auto;
            z-index: 1000;
            animation: slideUp 0.3s ease;
        }

        .emoji-picker.show {
            display: block;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .emoji-picker-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        .emoji-picker-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .emoji-picker-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
            overflow-x: auto;
            padding-bottom: 8px;
        }

        .emoji-tab {
            padding: 6px 12px;
            border-radius: 6px;
            background: #f5f5f5;
            border: none;
            cursor: pointer;
            font-size: 12px;
            color: #666;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .emoji-tab.active {
            background: #FF4500;
            color: white;
        }

        .emoji-tab:hover {
            background: #FF6347;
            color: white;
        }

        .emoji-grid {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 8px;
        }

        .emoji-item {
            font-size: 24px;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            text-align: center;
            transition: all 0.2s ease;
            user-select: none;
        }

        .emoji-item:hover {
            background: #f5f5f5;
            transform: scale(1.2);
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

        .login-required span {
            margin-left: 10px;

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
        /* Tablet: 768px - 1024px */
        @media (min-width: 768px) and (max-width: 1024px) {
            .promo-banner-section {
                padding: 30px 15px 50px;
            }

            .hot-badge {
                left: 15px;
                top: 0px;
                max-width: 60px;
            }

            .promo-button-prev,
            .promo-button-next {
                width: 40px;
                height: 40px;
            }

            .promo-slide {
                border-radius: 14px;
            }

            .promo-slide img {
                border-radius: 14px;
            }

            .app-download-section {
                padding: 30px 15px;
            }
        }

        /* Mobile: max-width 768px */
        @media (max-width: 768px) {
            .promo-banner-section {
                padding: 30px 20px 50px;
            }

            .hot-badge {
                left: 20px;
                top: 5px;
                max-width: 50px;
            }


            .promo-button-prev,
            .promo-button-next {
                width: 35px;
                height: 35px;
            }

            .promo-pagination {
                bottom: -25px !important;
            }
        }

        /* ============ NEWS SECTION ============ */
        .news-section {
            padding: 40px 20px 60px;
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
        }

        /* ============ APP DOWNLOAD SECTION ============ */
        .app-download-section {
            padding: 40px 20px 60px;
        }

        .app-download-banner {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            cursor: pointer;
            transition: transform 0.3s ease;
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
            border: 1px solid #ffffff;
            background-color: #2d2d2d !important;
            padding: 12px 16px;
            font-size: 16px;
            color: #FFFFFF;
        }

        .form-control:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
            color: #FFFFFF;
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
            color: #fff;
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

        .notification-banner {
            display: none !important;
        }


        /* Responsive */
        /* Tablet Landscape: 1025px - 1200px */
        @media (min-width: 1025px) and (max-width: 1200px) {
            .live-room-grid {
                grid-template-columns: 1fr 350px;
                gap: 18px;
            }

            .chat-section {
                height: 600px;
            }

            .video-header {
                padding: 12px 20px;
            }

            .host-avatar {
                width: 50px;
                height: 50px;
            }

            .host-name {
                font-size: 16px;
            }

            .host-description {
                font-size: 13px;
            }
        }

        /* Tablet Portrait: 768px - 1024px */
        @media (min-width: 768px) and (max-width: 1024px) {
            .live-room-section {
                padding: 25px 15px;
            }

            .live-room-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .video-header-box {
                border-radius: 20px;
            }

            .video-section {
                border-radius: 20px;
                border: 5px solid #FF4500;
            }

            .video-header {
                padding: 12px 20px;
            }

            .host-avatar {
                width: 50px;
                height: 50px;
            }

            .host-name {
                font-size: 16px;
            }

            .host-description {
                font-size: 13px;
            }

            .social-icon {
                width: 32px;
                height: 32px;
                font-size: 16px;
            }

            .copy-button {
                padding: 7px 18px;
                font-size: 12px;
            }

            .stat-item {
                font-size: 13px;
            }

            .viewer-count {
                font-size: 15px;
            }

            .chat-section {
                height: 600px;
                border-radius: 20px;
            }

            .chat-header-wrapper {
                padding: 8px;
            }

            .chat-header {
                padding: 12px;
                border-radius: 10px;
            }

            .chat-header-title {
                font-size: 14px;
            }

            .chat-header-info {
                font-size: 11px;
            }

            .chat-messages {
                padding: 12px;
            }

            .chat-message {
                padding: 10px 12px;
                border-radius: 16px;
            }

            .message-username {
                font-size: 13px;
            }

            .message-text {
                font-size: 13px;
            }

            .chat-input-form {
                padding: 12px;
            }

            #chat-input {
                padding: 10px 40px 10px 15px;
                font-size: 13px;
            }

            .chat-send-btn {
                padding: 10px 20px;
                font-size: 13px;
            }

            .login-required {
                padding: 18px 16px;
                font-size: 14px;
            }

            .chat-section-not-start-mobile {
                height: 200px;
            }
        }

        /* Mobile: max-width 768px */
        @media (max-width: 768px) {
            .live-room-grid {
                grid-template-columns: 1fr;
            }

            .chat-section {
                height: 667px;
            }

            .news-grid {
                grid-template-columns: 1fr;
            }
            .chat-section-not-start-mobile {
                height: 225px;
            }
            .login-required {
                padding: 20px 18px;
                text-align: center;
                color: white;
                background: rgba(0, 0, 0, 0.2);
                font-size: 15px;
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
            .video-header {
                display: none;
            }
            .notification-banner {
                display: block !important;
            }
        }
</style>
@endpush

@section('content')
    <div class="live-room-section">
        <div class="live-room-grid">
            <!-- Left Column: Video Header + Video Player -->
            <div class="video-column">
                <!-- Video Header (Separate Box) -->
                <div class="video-header-box">
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
                            <div class="viewer-stats">
                                <div class="stat-item share-trigger" onclick="toggleSharePopup()">
                                    <i class="fas fa-share-nodes"></i>
                                    <span>Chia sẻ</span>

                                    <!-- Share Popup -->
                                    <div class="share-popup" id="sharePopup">
                                        <div class="share-popup-content">
                                            <div class="social-icons-popup">
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
                                            <button class="copy-button-popup" onclick="copyLiveUrl(event)">
                                                Sao chép
                                            </button>
                                        </div>
                                        <div class="share-popup-arrow"></div>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-eye"></i>
                                    <span class="viewer-count" id="live-viewer-count">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Player (Separate Box) -->
                <div class="video-section">
                    <div class="video-player-wrapper">
                        <video id="live-video-player" controls autoplay muted playsinline></video>
                    </div>
                </div>
            </div>

            <!-- Chat Section (Right) -->
            <div class="chat-section">
                <div class="chat-header-wrapper">
                    <div class="chat-header">
                        <div class="chat-header-title">
                            <img src="{{ asset('images/Vector.png') }}" alt="Streamer Icon">
                            <span style="background: linear-gradient(#EC6612 0%, #F50000 100%); border-radius: 20px; padding: 0 10px;">Streamer</span> <span>{{ $liveSetting->assignedUser->name ?? 'Viruss' }}:</span>
                        </div>
                        <div class="chat-header-info">
                            Cập nhật thông tin ABC8 tại: http://t.me/ABC8LIVE<br>
                            Telegram CSKH hỗ trợ 24/7: http://t.me/ABC8LIVE
                        </div>
                    </div>
                </div>
                <div class="chat-messages" id="chat-messages">
                    <!-- Messages will be loaded here -->
                </div>
                @guest
                <div class="login-required" id="login-required-message">
                    Bạn cần đăng nhập để chat.
                    <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Đăng nhập
                    </button>
                </div>
                @else
                <div class="login-required" id="chat-not-started-message" style="display: none;">
                    Chat sẽ mở khi live stream bắt đầu lúc  <span id="live-start-time"></span>
                </div>
                <form id="chat-form" class="chat-input-form">
                    @csrf
                    <div style="position: relative;">
                        <i class="far fa-smile chat-input-icon" id="emoji-toggle"></i>
                        <div class="emoji-picker" id="emoji-picker">
                            <div class="emoji-picker-header">
                                <span class="emoji-picker-title">Chọn biểu tượng cảm xúc</span>
                            </div>
                            <div class="emoji-picker-tabs">
                                <button type="button" class="emoji-tab active" data-category="smileys">😊 Mặt cười</button>
                                <button type="button" class="emoji-tab" data-category="gestures">👋 Cử chỉ</button>
                                <button type="button" class="emoji-tab" data-category="hearts">❤️ Trái tim</button>
                                <button type="button" class="emoji-tab" data-category="symbols">🔥 Biểu tượng</button>
                            </div>
                            <div class="emoji-grid" id="emoji-grid">
                                <!-- Emojis will be loaded here -->
                            </div>
                        </div>
                    </div>
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
                            <img src="{{ asset('images/image 79.png') }}" alt="Nhận Ngay Code Ưu Đãi Khủng">
                        </div>
                    @endforelse
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
<!-- FLV.js for .flv files -->
<script src="https://cdn.jsdelivr.net/npm/flv.js@1.6.2/dist/flv.min.js"></script>
<!-- HLS.js for .m3u8 files -->
<script src="https://cdn.jsdelivr.net/npm/hls.js@1.5.13/dist/hls.min.js"></script>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        (function() {
            // Initialize Video Player
            const video = document.getElementById('live-video-player');
            const playUrlFlv = '{{ $liveSetting->play_url_flv ?? '' }}';
            const playUrlM3u8 = '{{ $liveSetting->play_url_m3u8 ?? '' }}';
            const playAds = '{{ asset('images/advertise.mp4') }}';

            let flvPlayer = null;
            let hls = null;

            // Kiểm tra thời gian live
            const liveStartTimeStr = '{{ $liveSetting->live_date->format('Y-m-d') }} {{ $liveSetting->live_time->format('H:i:s') }}';
            const liveStartTime = new Date(liveStartTimeStr.replace(' ', 'T'));
            const now = new Date();
            const isLiveStarted = now >= liveStartTime;

            function playAdvertisement() {
                video.src = playAds;
                video.loop = true;
                video.play().catch(e => {});
            }

            // Function để chuyển sang live stream
            function switchToLiveStream() {
                video.loop = false;
                video.src = '';

                // Try M3U8 FIRST (more stable), fallback to FLV
                if (playUrlM3u8) {
                    loadM3u8Stream();
                } else if (playUrlFlv && typeof flvjs !== 'undefined' && flvjs.isSupported()) {
                    try {
                        flvPlayer = flvjs.createPlayer({
                            type: 'flv',
                            url: playUrlFlv,
                            isLive: true,
                            hasAudio: true,
                            hasVideo: true
                        }, {
                            enableWorker: true,
                            enableStashBuffer: false,
                            stashInitialSize: 128,
                            lazyLoad: false,
                            autoCleanupSourceBuffer: true
                        });

                        flvPlayer.attachMediaElement(video);
                        flvPlayer.load();

                        video.addEventListener('loadedmetadata', function() {
                            video.play().catch(e => {});
                        });

                        flvPlayer.on(flvjs.Events.ERROR, function(errorType, errorDetail) {
                            if (flvPlayer) {
                                flvPlayer.destroy();
                                flvPlayer = null;
                            }
                            loadM3u8Stream();
                        });
                    } catch (e) {
                        if (flvPlayer) {
                            flvPlayer.destroy();
                            flvPlayer = null;
                        }
                        loadM3u8Stream();
                    }
                }
            }

            // Function to load M3U8 stream
            function loadM3u8Stream() {
                if (!playUrlM3u8) {
                    return;
                }

                // Use HLS.js for .m3u8 files
                if (typeof Hls !== 'undefined' && Hls.isSupported()) {
                    hls = new Hls({
                        enableWorker: true,
                        lowLatencyMode: true,
                        backBufferLength: 90
                    });

                    hls.loadSource(playUrlM3u8);
                    hls.attachMedia(video);

                    hls.on(Hls.Events.MANIFEST_PARSED, function() {
                        video.play().catch(e => {});
                    });

                    hls.on(Hls.Events.ERROR, function(event, data) {
                        if (data.fatal) {
                            switch(data.type) {
                                case Hls.ErrorTypes.NETWORK_ERROR:
                                    hls.startLoad();
                                    break;
                                case Hls.ErrorTypes.MEDIA_ERROR:
                                    hls.recoverMediaError();
                                    break;
                                default:
                                    hls.destroy();
                                    break;
                            }
                        }
                    });
                } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                    // Native HLS support (Safari)
                    video.src = playUrlM3u8;
                    video.addEventListener('loadedmetadata', function() {
                        video.play().catch(e => {});
                    });
                }
            }

            // Khởi chạy video player
            if (!isLiveStarted) {
                playAdvertisement();

                const checkLiveInterval = setInterval(() => {
                    const currentTime = new Date();
                    if (currentTime >= liveStartTime) {
                        clearInterval(checkLiveInterval);
                        switchToLiveStream();
                    }
                }, 1000);
            } else {
                switchToLiveStream();
            }

        // Chat functionality - prevent double initialization
        if (window.chatInitialized) {
            return;
        }
        window.chatInitialized = true;

        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        const currentUser = @json(Auth::user());
        let lastMessageId = 0;
        let isRealtimeActive = false;
        const addedMessageIds = new Set(); // Track all added message IDs to prevent duplicates


        // Check if chat is allowed
        function isChatAllowed() {
            const currentTime = new Date();
            return currentTime >= liveStartTime;
        }

        // Update chat UI based on live status
        function updateChatStatus() {
            const chatInput = document.getElementById('chat-input');
            const chatForm = document.getElementById('chat-form');
            const sendBtn = document.querySelector('.chat-send-btn');
            const chatNotStartedMessage = document.getElementById('chat-not-started-message');
            const chatSection = document.querySelector('.chat-section');
            const liveStartTimeSpan = document.getElementById('live-start-time');
            const allowed = isChatAllowed();

            if (!allowed) {
                console.log(chatSection);
                // Show "chat not started" message
                if (chatNotStartedMessage) {
                    chatNotStartedMessage.style.display = 'flex';
                    chatSection.classList.add('chat-section-not-start-mobile');
                    if (liveStartTimeSpan) {
                        liveStartTimeSpan.textContent = liveStartTime.toLocaleTimeString('vi-VN', {hour: '2-digit', minute: '2-digit'});
                    }
                }
                // Hide chat form
                if (chatForm) {
                    chatForm.style.display = 'none';
                }
            } else {
                // Hide "chat not started" message
                if (chatNotStartedMessage) {
                    chatNotStartedMessage.style.display = 'none';
                }
                // Show chat form
                if (chatForm) {
                    chatForm.style.display = 'flex';
                }
                if (chatInput) {
                    chatInput.disabled = false;
                    chatInput.placeholder = 'Nhập nội dung trò chuyện';
                }
                if (sendBtn) {
                    sendBtn.disabled = false;
                }
            }
        }

        // Initial status update
        if (isLoggedIn) {
            updateChatStatus();

            // Check every second if live has started
            if (!isLiveStarted) {
                const checkInterval = setInterval(() => {
                    if (isChatAllowed()) {
                        updateChatStatus();
                        clearInterval(checkInterval);
                        // Don't reload all messages, polling will get new ones
                    }
                }, 1000);
            }
        }

        // Load initial messages ONCE
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

            // Emoji Picker Functionality
            const emojiCategories = {
                smileys: ['😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '😚', '😙', '🥲', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐', '🤨', '😐', '😑', '😶', '😏', '😒', '🙄', '😬', '🤥', '😌', '😔', '😪', '🤤', '😴', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '🥵', '🥶', '😎', '🤓', '🧐'],
                gestures: ['👋', '🤚', '🖐️', '✋', '🖖', '👌', '🤌', '🤏', '✌️', '🤞', '🤟', '🤘', '🤙', '👈', '👉', '👆', '🖕', '👇', '☝️', '👍', '👎', '✊', '👊', '🤛', '🤜', '👏', '🙌', '👐', '🤲', '🤝', '🙏', '✍️', '💪', '🦾', '🦿', '🦵', '🦶', '👂', '🦻', '👃', '🧠', '🫀', '🫁', '🦷', '🦴', '👀', '👁️', '👅', '👄', '💋'],
                hearts: ['❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '🤎', '💔', '❤️‍🔥', '❤️‍🩹', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '💟', '☮️', '✝️', '☪️', '🕉️', '☸️', '✡️', '🔯', '🕎', '☯️', '☦️', '🛐', '⛎', '♈', '♉', '♊', '♋', '♌', '♍', '♎', '♏', '♐', '♑', '♒', '♓'],
                symbols: ['🔥', '⭐', '✨', '💫', '🌟', '💥', '💢', '💦', '💨', '🎉', '🎊', '🎈', '🎁', '🏆', '🥇', '🥈', '🥉', '⚽', '🏀', '🏈', '⚾', '🥎', '🎾', '🏐', '🏉', '🥏', '🎱', '🪀', '🏓', '🏸', '🏒', '🏑', '🥍', '🏏', '🥅', '⛳', '🪁', '🏹', '🎣', '🤿', '🥊', '🥋', '🎽', '🛹', '🛼', '🛷', '⛸️', '🥌', '🎿', '⛷️', '🏂', '🪂', '🏋️', '🤼', '🤸', '⛹️', '🤺', '🤾', '🏌️', '🏇', '🧘', '🏊', '🤽', '🚣', '🧗', '🚴', '🚵', '🎖️', '🏅']
            };

            let currentCategory = 'smileys';
            const emojiPicker = document.getElementById('emoji-picker');
            const emojiToggle = document.getElementById('emoji-toggle');
            const emojiGrid = document.getElementById('emoji-grid');
            const chatInput = document.getElementById('chat-input');

            // Load emojis for current category
            function loadEmojis(category) {
                emojiGrid.innerHTML = '';
                const emojis = emojiCategories[category];
                emojis.forEach(emoji => {
                    const emojiItem = document.createElement('span');
                    emojiItem.className = 'emoji-item';
                    emojiItem.textContent = emoji;
                    emojiItem.addEventListener('click', function() {
                        insertEmoji(emoji);
                    });
                    emojiGrid.appendChild(emojiItem);
                });
            }

            // Insert emoji into chat input
            function insertEmoji(emoji) {
                const cursorPos = chatInput.selectionStart;
                const textBefore = chatInput.value.substring(0, cursorPos);
                const textAfter = chatInput.value.substring(cursorPos);
                chatInput.value = textBefore + emoji + textAfter;
                
                // Move cursor after emoji
                const newCursorPos = cursorPos + emoji.length;
                chatInput.setSelectionRange(newCursorPos, newCursorPos);
                chatInput.focus();
                
                // Close emoji picker
                emojiPicker.classList.remove('show');
            }

            // Toggle emoji picker
            if (emojiToggle) {
                emojiToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    emojiPicker.classList.toggle('show');
                    if (emojiPicker.classList.contains('show')) {
                        loadEmojis(currentCategory);
                    }
                });
            }

            // Emoji category tabs
            const emojiTabs = document.querySelectorAll('.emoji-tab');
            emojiTabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.stopPropagation();
                    // Remove active class from all tabs
                    emojiTabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tab
                    this.classList.add('active');
                    // Load emojis for selected category
                    currentCategory = this.getAttribute('data-category');
                    loadEmojis(currentCategory);
                });
            });

            // Close emoji picker when clicking outside
            document.addEventListener('click', function(e) {
                if (!emojiPicker.contains(e.target) && e.target !== emojiToggle) {
                    emojiPicker.classList.remove('show');
                }
            });

            // Prevent emoji picker from closing when clicking inside it
            if (emojiPicker) {
                emojiPicker.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Try to use Echo for realtime
            if (typeof Echo !== 'undefined') {
                try {
                    const liveId = {{ $liveSetting->id }};
                    // Listen to this specific live room's channel
                    Echo.channel(`live-chat.${liveId}`)
                        .listen('.new-message', function(data) {
                            // Only add message if it belongs to this live room
                            if (data.live_setting_id == liveId) {
                                addMessageToChat(data);
                                isRealtimeActive = true;
                            }
                        });
                } catch (error) {
                    startPolling();
                }
            } else {
                startPolling();
            }
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

            // Check if chat is allowed
            if (!isChatAllowed()) {
                alert('Chat chỉ được phép khi live stream đã bắt đầu!');
                return;
            }

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
                    if (response.status === 403) {
                        return response.json().then(data => {
                            alert(data.message || 'Chat chỉ được phép khi live stream đã bắt đầu!');
                            throw new Error('Forbidden');
                        });
                    }
                    if (!response.ok) {
                        throw new Error('HTTP error! status: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        input.value = '';
                        // Add the message immediately to prevent duplicate from Echo
                        // Echo will broadcast to others, we add our own message here
                        if (data.chat_message) {
                            addMessageToChat(data.chat_message);
                        }
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

            // Check if message already added (prevent duplicates)
            if (data.id && addedMessageIds.has(data.id)) {
                return;
            }

            // Track last message ID
            if (data.id && data.id > lastMessageId) {
                lastMessageId = data.id;
            }

            // Add message ID to set
            if (data.id) {
                addedMessageIds.add(data.id);
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
        // Toggle share popup
        function toggleSharePopup() {
            const popup = document.getElementById('sharePopup');
            popup.classList.toggle('show');
        }

        // Close popup when clicking outside
        document.addEventListener('click', function(event) {
            const sharePopup = document.getElementById('sharePopup');
            const shareTrigger = document.querySelector('.share-trigger');

            if (sharePopup && shareTrigger && !shareTrigger.contains(event.target)) {
                sharePopup.classList.remove('show');
            }
        });

        function copyLiveUrl(event) {
            if (event) {
                event.stopPropagation(); // Prevent popup from closing
            }

            const url = window.location.href;

            // Modern API
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(() => {
                    alert('Đã sao chép link live vào clipboard!');
                    // Close popup after copying
                    const sharePopup = document.getElementById('sharePopup');
                    if (sharePopup) {
                        sharePopup.classList.remove('show');
                    }
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
                // Close popup after copying
                const sharePopup = document.getElementById('sharePopup');
                if (sharePopup) {
                    sharePopup.classList.remove('show');
                }
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

        // Initialize Swiper for promotional banners
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
                        // alert('Đăng nhập thành công!');

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

        })(); // End of IIFE
    </script>
@endpush
