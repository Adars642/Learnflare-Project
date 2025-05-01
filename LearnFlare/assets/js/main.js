// LearnFlare - Main JavaScript File

document.addEventListener('DOMContentLoaded', function() {
    // Form validation for login
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (username === '' || password === '') {
                e.preventDefault();
                displayError('Please fill in all fields');
            }
        });
    }
    
    // Form validation for signup
    const signupForm = document.getElementById('signup-form');
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('confirm-password').value.trim();
            
            if (username === '' || email === '' || password === '' || confirmPassword === '') {
                e.preventDefault();
                displayError('Please fill in all fields');
                return;
            }
            
            if (password !== confirmPassword) {
                e.preventDefault();
                displayError('Passwords do not match');
                return;
            }
            
            if (!validateEmail(email)) {
                e.preventDefault();
                displayError('Please enter a valid email address');
                return;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                displayError('Password must be at least 6 characters long');
                return;
            }
        });
    }
    
    // Form validation for contact form
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value.trim();
            const message = document.getElementById('message').value.trim();
            
            if (name === '' || email === '' || subject === '' || message === '') {
                e.preventDefault();
                displayError('Please fill in all fields');
                return;
            }
            
            if (!validateEmail(email)) {
                e.preventDefault();
                displayError('Please enter a valid email address');
                return;
            }
        });
    }
    
    // Function to display error messages
    function displayError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger';
        errorDiv.textContent = message;
        
        const form = document.querySelector('form');
        const formTitle = document.querySelector('.form-title');
        
        form.insertBefore(errorDiv, formTitle.nextSibling);
        
        // Remove error message after 3 seconds
        setTimeout(function() {
            errorDiv.remove();
        }, 3000);
    }
    
    // Function to validate email format
    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
    
    // Handle search functionality
    const searchForm = document.getElementById('search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const searchInput = document.getElementById('search-input').value.trim();
            
            if (searchInput === '') {
                e.preventDefault();
                alert('Please enter a search term');
            }
        });
    }
});