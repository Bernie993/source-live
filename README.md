# Hệ thống Quản lý Live Stream với Admin Panel

Hệ thống Laravel với admin panel quản lý live stream, user, và chat với tính năng lọc từ khóa.

## Tính năng chính

### 1. Quản lý Roles & Permissions
- **Admin**: Toàn quyền quản lý hệ thống
- **Nhân viên Live**: Xem link live và quản lý từ khóa chặn
- **CSKH**: Quản lý từ khóa chặn

### 2. Tính năng Live
- Cài đặt link live và link play
- Cài đặt ngày và giờ live
- Nhân viên live có thể truy cập link trước 30 phút

### 3. Quản lý User
- User được tạo bởi admin (nhân viên live và CSKH)
- User đăng nhập từ ngoài qua API verification
- Tích hợp API external để xác thực user

### 4. Hệ thống Chat
- Lưu trữ tin nhắn chat real-time
- Hệ thống lọc từ khóa tự động
- API endpoints cho frontend integration

### 5. Quản lý Từ khóa
- Thêm/sửa/xóa từ khóa chặn
- Test tính năng lọc từ khóa
- Thống kê từ khóa

## Cài đặt

### 1. Clone project và cài đặt dependencies
```bash
git clone <repository>
cd live
composer install
```

### 2. Cấu hình môi trường
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Cấu hình database trong .env
```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

### 4. Chạy migrations và seeders
```bash
php artisan migrate
php artisan db:seed --class=RolePermissionSeeder
```

### 5. Cài đặt frontend assets (tùy chọn)
```bash
npm install
npm run dev
```

### 6. Khởi chạy server
```bash
php artisan serve
```

## Tài khoản mặc định

| Role | Email | Password |
|------|--------|----------|
| Admin | admin@example.com | password |
| Nhân viên Live | live@example.com | password |
| CSKH | cskh@example.com | password |

## API Endpoints

### Authentication
- `POST /api/external-login` - Đăng nhập user external
- `POST /api/user-profile` - Lấy thông tin user

### Chat
- `POST /api/chat/send` - Gửi tin nhắn
- `GET /api/chat/messages` - Lấy danh sách tin nhắn
- `POST /api/chat/filter-keywords` - Test lọc từ khóa
- `GET /api/chat/stats` - Thống kê chat

## Cấu trúc thư mục

```
app/
├── Http/Controllers/
│   ├── Admin/          # Controllers cho admin
│   ├── Api/            # API controllers
│   ├── CSKH/           # Controllers cho CSKH
│   └── LiveStaff/      # Controllers cho nhân viên live
├── Models/             # Eloquent models
└── Services/           # Business logic services

resources/views/
├── admin/              # Views cho admin panel
├── layouts/            # Layout templates
└── auth/               # Authentication views

database/
├── migrations/         # Database migrations
└── seeders/           # Database seeders
```

## Tính năng nâng cao

### 1. Keyword Filtering System
- Lọc tin nhắn dựa trên từ khóa bị chặn
- Hỗ trợ regex matching
- Thống kê từ khóa và tin nhắn bị chặn

### 2. Live Access Control
- Nhân viên live chỉ có thể truy cập link trước 30 phút
- Kiểm soát thời gian truy cập dựa trên cài đặt

### 3. External User Integration
- Tích hợp API external để xác thực user
- Tự động tạo user khi API trả về hợp lệ
- Lưu trữ response từ API

### 4. Role-based Access Control
- Sử dụng Spatie Laravel Permission
- Phân quyền chi tiết cho từng chức năng
- Middleware bảo vệ routes

## Phát triển thêm

### 1. Real-time Chat (Pusher/WebSocket)
```bash
composer require pusher/pusher-php-server
```

### 2. Queue System
```bash
php artisan queue:table
php artisan migrate
```

### 3. Logging và Monitoring
- Cấu hình logging cho chat messages
- Monitor keyword filtering performance

## Troubleshooting

### 1. Permission denied errors
```bash
chmod -R 775 storage bootstrap/cache
```

### 2. Database connection issues
- Kiểm tra cấu hình .env
- Đảm bảo database file tồn tại

### 3. Role/Permission issues
```bash
php artisan permission:cache-reset
```

## Liên hệ

Nếu có vấn đề hoặc cần hỗ trợ, vui lòng tạo issue trong repository.