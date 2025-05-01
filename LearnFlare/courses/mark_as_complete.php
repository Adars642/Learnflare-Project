<?php
session_start();
require_once '../config/db.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'You must be logged in to mark a course as complete']);
    exit;
}

// Get user ID from session
$userId = $_SESSION['user_id'];

// Check if course ID is provided
if (!isset($_POST['course_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Course ID is required']);
    exit;
}

$courseId = $_POST['course_id'];

try {
    // Begin transaction
    $pdo->beginTransaction();
    
    // First, check if the user is enrolled in the course
    $stmt = $pdo->prepare("SELECT * FROM enrollments WHERE user_id = ? AND course_id = ?");
    $stmt->execute([$userId, $courseId]);
    $enrollment = $stmt->fetch();
    
    if (!$enrollment) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'You are not enrolled in this course']);
        $pdo->rollBack();
        exit;
    }
    
    // Add to completed courses table
    $stmt = $pdo->prepare("INSERT INTO completed_courses (user_id, course_id, completed_at) VALUES (?, ?, NOW())");
    $stmt->execute([$userId, $courseId]);
    
    // Remove from enrollments
    $stmt = $pdo->prepare("DELETE FROM enrollments WHERE user_id = ? AND course_id = ?");
    $stmt->execute([$userId, $courseId]);
    
    // Commit transaction
    $pdo->commit();
    
    // Return success response
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => 'Course marked as complete successfully']);
} catch (PDOException $e) {
    // Roll back the transaction if something went wrong
    $pdo->rollBack();
    
    // Return error as JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>