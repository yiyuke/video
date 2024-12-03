document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profileForm');
    const profileImage = document.getElementById('profileImage');
    const profilePreview = document.getElementById('profilePreview');

    //review the picture
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

    // deal with the form
    profileForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_profile.php');

        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                if (data.success) {
                    alert('Profile updated successfully!');
                    // update all the profile images
                    const newImagePath = data.profile_image;
                    document.querySelectorAll('.profile-img, .nav-user-info img').forEach(img => {
                        img.src = newImagePath;
                    });
                    // update the username
                    document.querySelectorAll('.user-info span').forEach(span => {
                        span.textContent = formData.get('username');
                    });
                } else {
                    alert('Update failed: ' + data.message);
                }
            }
        };

        xhr.onerror = function() {
            console.error('Error:', xhr.statusText);
            alert('Update failed');
        };

        xhr.send(formData);
    });
}); 