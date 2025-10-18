<!-- Notification Modal - Success/Error Messages -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true"
     style="background: linear-gradient(#242424db 0%, #0000008c 100%);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: rgb(0 0 0 / 95%) !important; border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="modal-body text-center" style="padding: 40px 30px;">
                <!-- Icon -->
                <div class="notification-icon mb-4">
                    <div class="icon-circle" id="notificationIcon">
                        <!-- Will be filled dynamically -->
                    </div>
                </div>

                <!-- Title -->
                <h4 class="notification-title mb-3" id="notificationTitle" style="color: #FFFFFF; font-weight: 600; font-size: 28px;">
                    <!-- Will be filled dynamically -->
                </h4>

                <!-- Message -->
                <p class="notification-message mb-4" id="notificationMessage" style="color: #CCCCCC; font-size: 16px; line-height: 1.6;">
                    <!-- Will be filled dynamically -->
                </p>

                <!-- Details (optional) - Ẩn nếu không có -->
                <div id="notificationDetails" style="display: none; background: rgba(255, 255, 255, 0.05); padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: left;">
                    <ul style="color: #FF6B6B; margin: 0; padding-left: 20px; list-style: none;">
                        <!-- Will be filled dynamically -->
                    </ul>
                </div>

                <!-- Separator when no details -->
                <div style="height: 10px;"></div>

                <!-- OK Button -->
                <button type="button" class="btn btn-notification-ok" onclick="closeNotificationModal()"
                        style="background: linear-gradient(#EC6612 0%, #F50000 100%); color: white; border: none; padding: 12px 60px; border-radius: 8px; font-size: 16px; font-weight: 600; min-width: 150px;">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.notification-icon {
    display: flex;
    justify-content: center;
    align-items: center;
}

.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

.icon-circle.success {
    border: 4px solid #90EE90;
    background: rgba(144, 238, 144, 0.1);
}

.icon-circle.error {
    border: 4px solid #FF6B6B;
    background: rgba(255, 107, 107, 0.1);
}

.icon-circle.success::after {
    content: '✓';
    font-size: 50px;
    color: #90EE90;
    font-weight: bold;
}

.icon-circle.error::after {
    content: '✕';
    font-size: 50px;
    color: #FF6B6B;
    font-weight: bold;
}

.btn-notification-ok:hover {
    opacity: 0.9;
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

#notificationDetails ul li {
    padding: 5px 0;
    position: relative;
    padding-left: 20px;
}

#notificationDetails ul li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: #FF6B6B;
    font-weight: bold;
}
</style>

<script>
function showNotification(type, title, message, details = null) {
    const modal = document.getElementById('notificationModal');
    const icon = document.getElementById('notificationIcon');
    const titleEl = document.getElementById('notificationTitle');
    const messageEl = document.getElementById('notificationMessage');
    const detailsEl = document.getElementById('notificationDetails');

    // Set icon
    icon.className = 'icon-circle ' + type;

    // Set title
    titleEl.textContent = title;

    // Set message
    messageEl.textContent = message;

    // Set details if provided
    if (details && details.length > 0) {
        detailsEl.style.display = 'block';
        const ul = detailsEl.querySelector('ul');
        ul.innerHTML = details.map(detail => `<li>${detail}</li>`).join('');
    } else {
        detailsEl.style.display = 'none';
    }

    // Show modal
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}

function closeNotificationModal() {
    const modal = document.getElementById('notificationModal');
    const bsModal = bootstrap.Modal.getInstance(modal);
    if (bsModal) {
        bsModal.hide();
    }
}

// Success notification helper
function showSuccessNotification(title, message) {
    showNotification('success', title, message);
}

// Error notification helper with details
function showErrorNotification(title, message, details = null) {
    showNotification('error', title, message, details);
}
</script>

