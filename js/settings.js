document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profileForm');
    const profileImage = document.getElementById('profileImage');
    const profilePreview = document.getElementById('profilePreview');

    // 預覽選擇的圖片
    profileImage.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // 處理表單提交
    profileForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        fetch('update_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Profile updated successfully!');
                // 使用服務器返回的圖片路徑更新所有頭像
                const newImagePath = data.profile_image;
                document.querySelectorAll('.profile-img, .nav-user-info img').forEach(img => {
                    img.src = newImagePath;
                });
                // 更新用戶名
                document.querySelectorAll('.user-info span').forEach(span => {
                    span.textContent = formData.get('username');
                });
            } else {
                alert('Update failed: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Update failed');
        });
    });
}); 