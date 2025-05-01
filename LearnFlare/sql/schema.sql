-- LearnFlare Database Schema
-- Users table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    last_login DATETIME NULL,
    created_at DATETIME DEFAULT NOW()
);
-- Courses table
CREATE TABLE IF NOT EXISTS courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    instructor VARCHAR(100) NOT NULL,
    duration VARCHAR(50) NOT NULL,
    created_at DATETIME DEFAULT NOW()
);
-- Enrollments table (connects users to courses)
CREATE TABLE IF NOT EXISTS enrollments (
    enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    enrolled_at DATETIME DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    CONSTRAINT user_course UNIQUE (user_id, course_id)
);
-- Completed courses table (tracks courses completed by users)
CREATE TABLE IF NOT EXISTS completed_courses (
    completion_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    completed_at DATETIME DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    CONSTRAINT user_course_completion UNIQUE (user_id, course_id)
);
-- Contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    submitted_at DATETIME DEFAULT NOW()
);
-- Insert some sample courses
INSERT INTO courses (title, description, instructor, duration)
VALUES (
        'Introduction to Web Development',
        'Learn the basics of HTML, CSS, and JavaScript to build modern websites.',
        'John Smith',
        '6 weeks'
    ),
    (
        'PHP Programming',
        'Master PHP programming language for server-side development.',
        'Jane Doe',
        '8 weeks'
    ),
    (
        'Database Design with MySQL',
        'Learn how to design and optimize database schemas using MySQL.',
        'Mike Johnson',
        '4 weeks'
    ),
    (
        'JavaScript Fundamentals',
        'Deep dive into JavaScript programming language fundamentals.',
        'Sarah Williams',
        '5 weeks'
    ),
    (
        'Responsive Web Design',
        'Learn how to create websites that work on all devices using responsive design principles.',
        'David Brown',
        '3 weeks'
    ),
    (
        'Advanced CSS and Animation',
        'Push your styling skills further with advanced CSS techniques and animations.',
        'Ava Lee',
        '3 weeks'
    );