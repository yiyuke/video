<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'Not authenticated']));
}

try {
    $videoId = $_POST['video_id'];
    $newTitle = $_POST['title'];
    $userId = $_SESSION['user_id'];

    // Verify the video belongs to the user and update
    $stmt = $pdo->prepare("UPDATE videos SET title = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$newTitle, $videoId, $userId]);

    if ($stmt->rowCount() === 0) {
        throw new Exception('Video not found or unauthorized');
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 