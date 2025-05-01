<?php
require_once '../config/db.php';

try {
    // Fetch all courses
    $stmt = $pdo->prepare("SELECT * FROM courses ORDER BY created_at DESC");
    $stmt->execute();
    $courses = $stmt->fetchAll();
    
    // Return courses as JSON
    header('Content-Type: application/json');
    echo json_encode($courses);
} catch (PDOException $e) {
    // Return error as JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>