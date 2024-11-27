<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'Not authenticated']));
}

try {
    $username = $_POST['username'];
    $userId = $_SESSION['user_id'];
    
    // Handle image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        // Check file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['profile_image']['type'], $allowedTypes)) {
            throw new Exception('Invalid file type. Only JPG, PNG and GIF are allowed.');
        }
        
        // Check file size (max 2MB)
        $maxSize = 2 * 1024 * 1024; // 2MB in bytes
        if ($_FILES['profile_image']['size'] > $maxSize) {
            throw new Exception('File is too large. Maximum size is 2MB.');
        }
        
        $uploadDir = 'uploads/profiles/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = uniqid() . '_' . $_FILES['profile_image']['name'];
        $filePath = $uploadDir . $fileName;
        
        // Delete old file if it exists
        if ($user['profile_image'] && file_exists($user['profile_image'])) {
            unlink($user['profile_image']);
        }
        
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $filePath)) {
            $stmt = $pdo->prepare("UPDATE users SET username = ?, profile_image = ? WHERE id = ?");
            $stmt->execute([$username, $filePath, $userId]);
        }
    } else {
        $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->execute([$username, $userId]);
    }
    
    $_SESSION['username'] = $username;
    echo json_encode(['success' => true, 'profile_image' => $filePath ?? null]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?> 