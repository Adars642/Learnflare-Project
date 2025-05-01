<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(['enrolled' => false, 'error' => 'User not logged in']);
    exit;
}

// Get user ID from session
$userId = $_SESSION['user_id'];

// Check if course ID is provided
if (!isset($_GET['course_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['enrolled' => false, 'error' => 'Course ID is required']);
    exit;
}

$courseId = $_GET['course_id'];

try {
    // Check if the user is enrolled in the course
    $stmt = $pdo->prepare("SELECT * FROM enrollments WHERE user_id = ? AND course_id = ?");
    $stmt->execute([$userId, $courseId]);
    $enrollment = $stmt->fetch();
    
    // Return enrollment status
    header('Content-Type: application/json');
    echo json_encode(['enrolled' => ($enrollment !== false)]);
} catch (PDOException $e) {
    // Return error as JSON
    header('Content-Type: application/json');
    echo json_encode(['enrolled' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>