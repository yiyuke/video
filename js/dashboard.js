document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('uploadForm');
    const deleteModal = document.getElementById('deleteModal');
    let videoToDelete = null;

    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'process_video_url.php');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    if (data.success) {
                        alert('Video added successfully!');
                        location.reload();
                    } else {
                        alert('Failed to add video: ' + data.message);
                    }
                }
            };
            xhr.onerror = function() {
                console.error('Error:', xhr.statusText);
                alert('Failed to add video');
            };
            xhr.send(formData);
        });
    }

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const videoCard = this.closest('.video-card');
            const titleElement = videoCard.querySelector('.video-title');
            const inputElement = videoCard.querySelector('.edit-title-input');
            
            titleElement.style.display = 'none';
            inputElement.style.display = 'block';
            inputElement.focus();
            
            inputElement.addEventListener('blur', function() {
                updateTitle(titleElement.dataset.videoId, this.value, titleElement, this);
            });
            
            inputElement.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    this.blur();
                }
            });
        });
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const videoCard = this.closest('.video-card');
            const videoId = videoCard.querySelector('.video-title').dataset.videoId;
            videoToDelete = { id: videoId, element: videoCard };
            deleteModal.style.display = 'block';
        });
    });

    document.querySelector('.cancel-delete').addEventListener('click', () => {
        deleteModal.style.display = 'none';
        videoToDelete = null;
    });

    document.querySelector('.confirm-delete').addEventListener('click', () => {
        if (videoToDelete) {
            deleteVideo(videoToDelete.id, videoToDelete.element);
        }
    });

    window.addEventListener('click', (e) => {
        if (e.target === deleteModal) {
            deleteModal.style.display = 'none';
            videoToDelete = null;
        }
    });

    function updateTitle(videoId, newTitle, titleElement, inputElement) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_video.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                if (data.success) {
                    titleElement.textContent = newTitle;
                    titleElement.style.display = 'block';
                    inputElement.style.display = 'none';
                } else {
                    alert('Failed to update title: ' + data.message);
                    inputElement.value = titleElement.textContent;
                }
            }
        };
        
        xhr.onerror = function() {
            console.error('Error:', xhr.statusText);
            alert('Failed to update title');
            inputElement.value = titleElement.textContent;
        };
        
        xhr.send(`video_id=${videoId}&title=${encodeURIComponent(newTitle)}`);
    }

    function deleteVideo(videoId, videoElement) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_video.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                if (data.success) {
                    videoElement.remove();
                    deleteModal.style.display = 'none';
                    videoToDelete = null;
                } else {
                    alert('Failed to delete video: ' + data.message);
                }
            }
        };
        
        xhr.onerror = function() {
            console.error('Error:', xhr.statusText);
            alert('Failed to delete video');
        };
        
        xhr.send(`video_id=${videoId}`);
    }
}); 