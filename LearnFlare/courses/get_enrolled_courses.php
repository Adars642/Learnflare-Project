<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'You must be logged in to view your courses']);
    exit;
}

// Get user ID from session
$userId = $_SESSION['user_id'];

try {
    // Fetch enrolled courses
    $stmt = $pdo->prepare("
        SELECT c.* 
        FROM courses c 
        JOIN enrollments e ON c.course_id = e.course_id 
        WHERE e.user_id = ?
        ORDER BY e.enrolled_at DESC
    ");
    $stmt->execute([$userId]);
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