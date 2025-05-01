<?php
// This file is for checking session status without outputting anything.
// It should be included by other PHP files to check for logged-in status.

// Don't start a session if one already exists
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// This file doesn't output anything, just provides session-related variables for other files to use
?>