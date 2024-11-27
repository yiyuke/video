<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
// Enable error logging to file
ini_set('log_errors', 1);
error_reporting(E_ALL);
ini_set('error_log', 'php_errors.log');

session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    error_log("Authentication failed: user not logged in");
    die(json_encode(['success' => false, 'message' => 'Not authenticated']));
}

$logFile = 'php_errors.log';
if (!file_exists($logFile)) {
    touch($logFile);
    chmod($logFile, 0666);
}

try {
    if (!isset($_POST['video_url']) || !isset($_POST['title'])) {
        error_log("Missing required fields in video upload");
        throw new Exception('Missing required fields');
    }

    $videoUrl = trim($_POST['video_url']);
    $title = trim($_POST['title']);
    $userId = $_SESSION['user_id'];
    
    error_log("Processing video upload - URL: " . $videoUrl . ", Title: " . $title);
    
    if (empty($videoUrl) || empty($title)) {
        throw new Exception('URL and title cannot be empty');
    }
    
    $videoId = '';
    $platform = '';
    
    if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $videoUrl, $matches) ||
        preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
        $videoId = $matches[1];
        $platform = 'youtube';
    } elseif (preg_match('/vimeo\.com\/([0-9]+)/', $videoUrl, $matches)) {
        $videoId = $matches[1];
        $platform = 'vimeo';
    }
    
    if (empty($videoId)) {
        throw new Exception('Unsupported video URL format');
    }

    $stmt = $pdo->prepare("INSERT INTO videos (user_id, title, platform, video_id, url) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt->execute([$userId, $title, $platform, $videoId, $videoUrl])) {
        error_log("Database error: " . print_r($stmt->errorInfo(), true));
        throw new Exception('Failed to save video information');
    }
    
    error_log("Video successfully added - ID: " . $pdo->lastInsertId());
    echo json_encode(['success' => true]);
    
} catch (Exception $e) {
    error_log("Video upload error: " . $e->getMessage());
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit();
}
?> 