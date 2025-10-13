# API Testing Examples

## 1. External User Login

### Request
```bash
curl -X POST http://localhost:8000/api/external-login \
  -H "Content-Type: application/json" \
  -d '{
    "account": "hungkoi1234",
    "bank_account": "5556",
    "platform": "u888"
  }'
```

### Response
```json
{
  "success": true,
  "message": "Đăng nhập thành công",
  "user": {
    "id": 1,
    "name": "hungkoi1234",
    "account": "hungkoi1234",
    "bank_account": "5556",
    "platform": "u888"
  },
  "api_data": {
    // API response from external service
  }
}
```

## 2. Send Chat Message

### Request
```bash
curl -X POST http://localhost:8000/api/chat/send \
  -H "Content-Type: application/json" \
  -d '{
    "username": "testuser",
    "message": "Hello world! This is a test message."
  }'
```

### Response
```json
{
  "success": true,
  "message": {
    "id": 1,
    "username": "testuser",
    "message": "Hello world! This is a test message.",
    "is_blocked": false,
    "blocked_keywords": [],
    "sent_at": "2025-10-03T01:50:00.000000Z"
  },
  "is_blocked": false,
  "blocked_keywords": []
}
```

## 3. Get Chat Messages

### Request
```bash
curl -X GET "http://localhost:8000/api/chat/messages?limit=10&show_blocked=false"
```

### Response
```json
{
  "success": true,
  "messages": [
    {
      "id": 1,
      "username": "testuser",
      "message": "Hello world!",
      "is_blocked": false,
      "blocked_keywords": [],
      "sent_at": "2025-10-03T01:50:00.000000Z"
    }
  ]
}
```

## 4. Test Keyword Filtering

### Request
```bash
curl -X POST http://localhost:8000/api/chat/filter-keywords \
  -H "Content-Type: application/json" \
  -d '{
    "message": "This message contains badword and spam"
  }'
```

### Response
```json
{
  "success": true,
  "is_blocked": true,
  "blocked_keywords": ["badword", "spam"],
  "original_message": "This message contains badword and spam"
}
```

## 5. Get Chat Statistics

### Request
```bash
curl -X GET http://localhost:8000/api/chat/stats
```

### Response
```json
{
  "success": true,
  "stats": {
    "total_messages": 150,
    "blocked_messages": 25,
    "allowed_messages": 125,
    "recent_messages": 10,
    "active_keywords": 15
  }
}
```

## 6. Get User Profile

### Request
```bash
curl -X POST http://localhost:8000/api/user-profile \
  -H "Content-Type: application/json" \
  -d '{
    "account": "hungkoi1234",
    "bank_account": "5556"
  }'
```

### Response
```json
{
  "success": true,
  "user": {
    "id": 1,
    "name": "hungkoi1234",
    "account": "hungkoi1234",
    "bank_account": "5556",
    "platform": "u888",
    "created_at": "2025-10-03T01:00:00.000000Z"
  }
}
```

## Frontend Integration Example

### JavaScript/jQuery Example
```javascript
// Send chat message
function sendMessage(username, message) {
    $.ajax({
        url: '/api/chat/send',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            username: username,
            message: message
        }),
        success: function(response) {
            if (response.success) {
                if (response.is_blocked) {
                    console.log('Message blocked:', response.blocked_keywords);
                } else {
                    displayMessage(response.message);
                }
            }
        },
        error: function(xhr) {
            console.error('Error sending message:', xhr.responseJSON);
        }
    });
}

// Get messages
function loadMessages() {
    $.ajax({
        url: '/api/chat/messages?limit=50',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                response.messages.forEach(displayMessage);
            }
        }
    });
}

// External user login
function externalLogin(account, bankAccount, platform = 'u888') {
    $.ajax({
        url: '/api/external-login',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            account: account,
            bank_account: bankAccount,
            platform: platform
        }),
        success: function(response) {
            if (response.success) {
                console.log('Login successful:', response.user);
                // Store user info for chat
                localStorage.setItem('chatUser', JSON.stringify(response.user));
            }
        },
        error: function(xhr) {
            console.error('Login failed:', xhr.responseJSON);
        }
    });
}
```

## Error Responses

### Validation Error
```json
{
  "success": false,
  "message": "The given data was invalid.",
  "errors": {
    "username": ["The username field is required."],
    "message": ["The message field is required."]
  }
}
```

### External API Error
```json
{
  "success": false,
  "message": "Thông tin không hợp lệ hoặc không tìm thấy dữ liệu"
}
```

### Server Error
```json
{
  "success": false,
  "message": "Lỗi kết nối API: Connection timeout"
}
```
