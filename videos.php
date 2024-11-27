<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Videos - VideoLingo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Left Navigation -->
        <nav class="dashboard-nav">
            <div class="user-info">
                <?php
                $stmt = $pdo->prepare("SELECT profile_image FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch();
                ?>
                <img src="<?php echo $user['profile_image'] ?? 'images/default.png'; ?>" alt="Profile" class="profile-img">
                <span><?php echo $_SESSION['username']; ?></span>
            </div>
            <ul>
                <li><a href="dashboard.php">Overview</a></li>
                <li class="active"><a href="videos.php">Videos</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li class="nav-divider"></li>
                <li><a href="index.php">Homepage</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </nav>

        <!-- Main Content Area -->
        <main class="dashboard-main">
            <h1>My Videos</h1>
            
            <div class="videos-section">
                <div class="videos-grid">
                    <?php
                    // Get all user videos
                    $stmt = $pdo->prepare("SELECT * FROM videos WHERE user_id = ? ORDER BY created_at DESC");
                    $stmt->execute([$_SESSION['user_id']]);
                    $videos = $stmt->fetchAll();

                    foreach ($videos as $video) {
                        $embedUrl = '';
                        if ($video['platform'] === 'youtube') {
                            $embedUrl = "https://www.youtube.com/embed/" . $video['video_id'];
                        } elseif ($video['platform'] === 'vimeo') {
                            $embedUrl = "https://player.vimeo.com/video/" . $video['video_id'];
                        }
                        ?>
                        <div class="video-card">
                            <div class="video-wrapper">
                                <iframe 
                                    width="100%" 
                                    height="200" 
                                    src="<?php echo htmlspecialchars($embedUrl); ?>" 
                                    frameborder="0" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <div class="video-info">
                                <h3 class="video-title" data-video-id="<?php echo $video['id']; ?>">
                                    <?php echo htmlspecialchars($video['title']); ?>
                                </h3>
                                <input type="text" class="edit-title-input" style="display: none;" value="<?php echo htmlspecialchars($video['title']); ?>">
                                <p class="video-date">Added: <?php echo date('Y-m-d', strtotime($video['created_at'])); ?></p>
                                <div class="video-actions">
                                    <button class="edit-btn" title="Edit title">
                                        <img src="images/edit.png" alt="Edit" width="20">
                                    </button>
                                    <button class="delete-btn" title="Delete video">
                                        <img src="images/trash.png" alt="Delete" width="20">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    if (empty($videos)) {
                        echo '<p class="no-videos">No videos uploaded yet.</p>';
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>
    <script src="js/dashboard.js"></script>
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <h3>Delete Video</h3>
            <p>Are you sure you want to delete this video?</p>
            <div class="modal-buttons">
                <button class="cancel-delete">Cancel</button>
                <button class="confirm-delete">Delete</button>
            </div>
        </div>
    </div>
</body>
</html> 