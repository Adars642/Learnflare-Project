# LearnFlare - Online Learning Platform

LearnFlare is a PHP-based online learning platform that allows users to browse courses, create accounts, and enroll in courses to learn new skills.

## Project Structure

The project follows a modular organization:

```
LearnFlare/
├── assets/                  # Static resources
│   ├── css/                 # CSS stylesheets
│   ├── js/                  # JavaScript files
│   └── images/              # Image files
│
├── auth/                    # Authentication related pages
│   ├── login.php            # Login page and processing
│   ├── signup.php           # Registration page and processing
│   └── logout.php           # Logout functionality
│
├── config/                  # Configuration files
│   └── db.php               # Database connection
│
├── courses/                 # Course related pages and functionality
│   ├── course.php           # Individual course display
│   ├── mycourses.php        # User's enrolled courses
│   ├── search.php           # Course search functionality
│   ├── fetch_courses.php    # API to get all courses
│   ├── get_course.php       # API to get a specific course
│   ├── get_enrolled_courses.php # API to get user's enrolled courses
│   └── enroll.php           # Course enrollment processing
│
├── includes/                # Reusable PHP components
│   └── contact_handler.php  # Contact form processing
│
├── public/                  # Public-facing pages
│   ├── about.php            # About us page
│   └── contact.php          # Contact page
│
├── utils/                   # Utility functions
│   └── check_session.php    # Session handling utility
│
├── sql/                     # SQL scripts
│   └── schema.sql           # Database schema
│
├── index.php                # Homepage
└── README.md                # This file
```

## Setup Instructions

1. **Prerequisites**:
   - PHP 7.4 or higher
   - MySQL 5.7 or higher
   - Apache web server

2. **Installation**:
   - Clone or download this repository to your web server's document root (e.g., `xampp/htdocs/LearnFlare`)
   - Create a MySQL database named `learnflare`
   - Import the database schema from `sql/schema.sql`
   - Update database credentials in `config/db.php` if needed

3. **Running the application**:
   - Start your Apache and MySQL servers
   - Navigate to `http://localhost/LearnFlare` in your web browser
   - The homepage should display a list of available courses

## Features

- **User Authentication**: Register, login, and manage user sessions
- **Course Browsing**: View all available courses
- **Course Search**: Search for courses by title, description, or instructor
- **Course Enrollment**: Enroll in courses you're interested in
- **User Dashboard**: View your enrolled courses
- **Contact Form**: Send messages to the site administrators

## Development

- The application uses a simple MVC-like structure without a formal framework
- PHP handles the backend logic and database interactions
- JavaScript is used for frontend interactions and AJAX requests
- CSS provides styling and responsive design

## License

This project is open-source and available for educational purposes.
