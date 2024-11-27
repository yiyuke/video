<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'Not authenticated']));
}

try {
    $videoId = $_POST['video_id'];
    $userId = $_SESSION['user_id'];

    // Verify the video belongs to the user
    $stmt = $pdo->prepare("SELECT id FROM videos WHERE id = ? AND user_id = ?");
    $stmt->execute([$videoId, $userId]);
    
    if (!$stmt->fetch()) {
        throw new Exception('Video not found or unauthorized');
    }

    // Delete the video
    $stmt = $pdo->prepare("DELETE FROM videos WHERE id = ? AND user_id = ?");
    $stmt->execute([$videoId, $userId]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 