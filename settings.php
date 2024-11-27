<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config/database.php';

// Get current user information
$stmt = $pdo->prepare("SELECT username, profile_image FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings - VideoLingo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Left Navigation -->
        <nav class="dashboard-nav">
            <div class="user-info">
                <img src="<?php echo $user['profile_image'] ?? 'images/default.png'; ?>" alt="Profile" class="profile-img">
                <span><?php echo $_SESSION['username']; ?></span>
            </div>
            <ul>
                <li><a href="dashboard.php">Overview</a></li>
                <li><a href="videos.php">Videos</a></li>
                <li class="active"><a href="settings.php">Settings</a></li>
                <li class="nav-divider"></li>
                <li><a href="index.php">Homepage</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </nav>

        <!-- Main Content Area -->
        <main class="dashboard-main">
            <h1>Settings</h1>
            <div class="settings-container">
                <form id="profileForm" class="settings-form" enctype="multipart/form-data">
                    <div class="profile-upload">
                        <img src="<?php echo $user['profile_image'] ?? 'images/default.png'; ?>" alt="Profile" id="profilePreview">
                        <input type="file" id="profileImage" name="profile_image" accept="image/*" hidden>
                        <button type="button" class="upload-btn" onclick="document.getElementById('profileImage').click()">
                            Change Photo
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>">
                    </div>
                    <button type="submit" class="save-btn">Save Changes</button>
                </form>
            </div>
        </main>
    </div>
    <script src="js/settings.js"></script>
</body>
</html> 