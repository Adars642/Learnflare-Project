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
    echo json_encode(['error' => 'You must be logged in to remove a course']);
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
    // Delete the enrollment record
    $stmt = $pdo->prepare("DELETE FROM enrollments WHERE user_id = ? AND course_id = ?");
    $stmt->execute([$userId, $courseId]);
    
    // Check if any rows were affected
    if ($stmt->rowCount() === 0) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'You are not enrolled in this course or the course does not exist']);
        exit;
    }
    
    // Return success response
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => 'Course removed successfully']);
} catch (PDOException $e) {
    // Return error as JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>