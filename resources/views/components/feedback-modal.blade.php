<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true" style="background: linear-gradient(#242424db 0%, #0000008c 100%);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: rgb(0 0 0) !important; position: relative;">
            <div class="modal-body">
                <form id="feedbackForm" enctype="multipart/form-data">
                    @csrf
                    <div style="text-align: center; margin-bottom: 30px;">
                        <h2 style="background: linear-gradient(#EC6612 0%, #F50000 100%); color: white; padding: 15px; margin: -30px -30px 30px -30px; font-weight: 700; font-size: 24px; letter-spacing: 1px;">
                            PHẢN HỒI KHÁCH HÀNG
                        </h2>
                    </div>

                    <div class="mb-3">
                        <input type="text" 
                               class="form-control feedback-input" 
                               id="loginInfo" 
                               name="login_info"
                               placeholder="Thông tin đăng nhập*" 
                               required
                               style="background-color: #2d2d2d !important; color: #FFFFFF; border: 2px solid #00D9FF; border-radius: 8px; padding: 15px;">
                    </div>

                    <div class="mb-3">
                        <input type="text" 
                               class="form-control feedback-input" 
                               id="feedbackType" 
                               name="feedback_type"
                               placeholder="Loại phản hồi"
                               style="background-color: #2d2d2d !important; color: #FFFFFF; border: 2px solid #00D9FF; border-radius: 8px; padding: 15px;">
                    </div>

                    <div class="mb-3">
                        <textarea class="form-control feedback-input" 
                                  id="feedbackContent" 
                                  name="content"
                                  placeholder="Nội dung phản hồi*" 
                                  rows="5"
                                  required
                                  style="background-color: #2d2d2d !important; color: #FFFFFF; border: 2px solid #00D9FF; border-radius: 8px; padding: 15px; resize: vertical;"></textarea>
                    </div>

                    <div class="mb-4">
                        <label style="color: #FFFFFF; font-size: 14px; margin-bottom: 10px; display: block;">
                            Hình ảnh không biết nội đội (Đề dàng được thông qua) - Tối đa 10MB
                        </label>
                        <div class="image-upload-wrapper" style="text-align: center;">
                            <input type="file" 
                                   id="feedbackImage" 
                                   name="image"
                                   accept="image/*"
                                   data-max-size="10485760"
                                   style="display: none;">
                            <label for="feedbackImage" style="cursor: pointer; display: inline-block;">
                                <div style="background-color: #2d2d2d; border: 2px solid #00D9FF; border-radius: 12px; padding: 30px; display: inline-flex; flex-direction: column; align-items: center; gap: 10px; transition: all 0.3s ease;">
                                    <img src="{{ asset('images/icon-upload-img.png') }}" 
                                         alt="Upload" 
                                         style="width: 60px; height: 60px; opacity: 0.7;">
                                    <span style="color: #00D9FF; font-size: 14px; font-weight: 500;">Chọn ảnh để tải lên</span>
                                </div>
                            </label>
                            <div id="imagePreview" style="margin-top: 15px; display: none;">
                                <img id="previewImg" src="" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 2px solid #00D9FF;">
                                <div style="margin-top: 10px;">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeImage()" style="background: #F50000; border: none; padding: 5px 15px; border-radius: 5px;">
                                        <i class="fas fa-times"></i> Xóa ảnh
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" 
                            class="btn btn-confirm" 
                            style="background: linear-gradient(#EC6612 0%, #F50000 100%); color: white; width: 100%; padding: 15px; border: none; border-radius: 8px; font-weight: 700; font-size: 18px; letter-spacing: 1px;">
                        <span class="btn-text">GỬI PHẢN HỒI</span>
                        <span class="loading">
                            <i class="fas fa-spinner fa-spin"></i> Đang gửi...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Close Button -->
            <button type="button" class="feedback-modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                X
            </button>
        </div>
    </div>
</div>

<style>
    .feedback-modal-close-btn {
        position: absolute;
        bottom: -50px;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        padding: 0;
        transition: transform 0.3s ease;
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .feedback-modal-close-btn:hover {
        transform: translateX(-50%) scale(1.1);
    }

    #feedbackModal .modal-dialog {
        margin-bottom: 80px;
        max-width: 600px;
    }

    .feedback-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .feedback-input:focus {
        border-color: #00D9FF !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 217, 255, 0.25);
        color: #FFFFFF;
        background-color: #2d2d2d !important;
    }

    .image-upload-wrapper label:hover > div {
        background-color: #3d3d3d;
        transform: scale(1.02);
    }

    /* Responsive */
    @media (max-width: 768px) {
        #feedbackModal .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100% - 1rem);
        }

        .feedback-modal-close-btn {
            width: 40px;
            height: 40px;
            font-size: 20px;
            bottom: -45px;
        }
    }
</style>

<script>
    // Image preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('feedbackImage');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Check file size (10MB = 10485760 bytes)
                    const maxSize = 10485760; // 10MB
                    if (file.size > maxSize) {
                        alert('Kích thước ảnh tối đa là 10MB. Vui lòng chọn ảnh nhỏ hơn!');
                        imageInput.value = '';
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    function removeImage() {
        const imageInput = document.getElementById('feedbackImage');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        
        imageInput.value = '';
        previewImg.src = '';
        imagePreview.style.display = 'none';
    }

    // Handle feedback form submission
    document.addEventListener('DOMContentLoaded', function() {
        const feedbackForm = document.getElementById('feedbackForm');
        if (feedbackForm) {
            feedbackForm.addEventListener('submit', handleFeedbackSubmit);
        }
    });

    function handleFeedbackSubmit(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        // Debug: Log form data
        console.log('=== FEEDBACK FORM DEBUG ===');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + (pair[1] instanceof File ? pair[1].name + ' (' + pair[1].size + ' bytes)' : pair[1]));
        }

        // Show loading state
        const btnText = form.querySelector('.btn-text');
        const loading = form.querySelector('.loading');
        const submitBtn = form.querySelector('.btn-confirm');

        btnText.style.display = 'none';
        loading.classList.add('show');
        submitBtn.disabled = true;

        // Call API
        fetch('/api/feedbacks', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                alert(data.message || 'Phản hồi của bạn đã được gửi thành công!');

                // Close modal
                const feedbackModal = document.getElementById('feedbackModal');
                if (feedbackModal) {
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                    feedbackModal.classList.remove('show');
                    feedbackModal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                    document.body.style.removeProperty('overflow');
                    document.body.style.removeProperty('padding-right');
                }

                // Reset form
                form.reset();
                removeImage();
            } else {
                alert(data.message || 'Có lỗi xảy ra, vui lòng thử lại!');
            }
        })
        .catch(error => {
            console.error('=== ERROR ===', error);
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

