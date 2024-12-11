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
                try {
                    const data = JSON.parse(xhr.responseText);
                    if (data.success) {
                        alert('Profile updated successfully!');
                        // update all the profile images
                        if (data.profile_image) {
                            const newImagePath = data.profile_image;
                            document.querySelectorAll('.profile-img, .nav-user-info img').forEach(img => {
                                img.src = newImagePath;
                            });
                        }
                        // update the username
                        document.querySelectorAll('.user-info span').forEach(span => {
                            span.textContent = formData.get('username');
                        });
                    } else {
                        alert('Update failed: ' + (data.message || 'Unknown error'));
                    }
                } catch (e) {
                    console.error('JSON parsing error:', e);
                    console.log('Raw response:', xhr.responseText);
                    alert('Error processing server response');
                }
            } else {
                alert('Server error: ' + xhr.status);
            }
        };

        xhr.onerror = function() {
            console.error('Error:', xhr.statusText);
            alert('Update failed');
        };

        xhr.send(formData);
    });
}); 