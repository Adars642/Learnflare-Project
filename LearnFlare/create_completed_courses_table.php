<?php
// This script creates the completed_courses table

// Include database connection
require_once 'config/db.php';

// SQL to create the completed_courses table
$sql = "CREATE TABLE IF NOT EXISTS completed_courses (
    completion_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    completed_at DATETIME DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    CONSTRAINT user_course_completion UNIQUE (user_id, course_id)
)";

try {
    // Execute the SQL
    $pdo->exec($sql);
    echo "The completed_courses table has been created successfully!";
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}
?>