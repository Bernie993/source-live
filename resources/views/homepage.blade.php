<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J88 - Trang chủ</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }

        .header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo {
            background: #dc2626;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 24px;
        }

        .nav-menu {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-item {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .nav-item:hover {
            opacity: 0.8;
            color: white;
        }

        .btn-login {
            background: #dc2626;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background: #b91c1c;
            color: white;
        }

        .main-content {
            padding: 60px 0;
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
            color: #dc2626;
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
            color: #6b7280;
            font-size: 14px;
            margin: 0;
        }

        .app-download {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
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
    <!-- Header -->
    <header class="header py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="logo">J88</div>
                </div>
                <div class="col-md-6">
                    <div class="nav-menu justify-content-end">
                        <a href="#" class="nav-item">Trang chủ</a>
                        <a href="#" class="nav-item">Live</a>
                        <a href="#" class="nav-item">Liveshow</a>
                        <a href="#" class="nav-item">Game+</a>
                        <a href="#" class="nav-item">Tải App</a>
                        @guest
                            <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Đăng ký
                            </button>
                            <button class="btn btn-login ms-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Đăng nhập
                            </button>
                        @else

                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <!-- Livestream Section -->
                <div class="col-lg-8 mb-4">
                    <div class="livestream-container">
                        <div class="livestream-header">
                            <div class="admin-info">
                                <i class="fas fa-circle text-success me-2"></i>
                                <span>Admin J88</span>
                                <div class="viewer-count ms-3">
                                    <i class="fas fa-eye me-1"></i>
                                    <span id="viewer-count">0</span>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-share-alt"></i>
                                <span class="ms-2">Chia sẻ</span>
                            </div>
                        </div>
                        <div class="livestream-content" id="stream-container">
                            <!-- Video player will be inserted here -->
                            <div class="stream-placeholder" id="stream-placeholder">
                                <div class="decorative-elements"></div>
                                <div class="livestream-title" id="stream-title">
                                    ĐẶC BIỆT
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0-rc2/dist/web/pusher.min.js"></script>
    <script>
        // Global variables
        let isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        let currentUser = @json(Auth::user());
        let echo = null;

        document.addEventListener('DOMContentLoaded', function() {
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
            // Load stream status
            loadStreamStatus();

            // Load viewer count
            updateViewerCount();

            // Load online count
            updateOnlineCount();

            // Set up intervals
            setInterval(loadStreamStatus, 30000); // Check stream status every 30 seconds
            setInterval(updateViewerCount, 10000); // Update viewer count every 10 seconds
            setInterval(updateOnlineCount, 15000); // Update online count every 15 seconds
        }

        function loadStreamStatus() {
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
