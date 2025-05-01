<!-- Main content ends here -->
    <footer style="background-color: #1B2231; color: #ffffff; padding: 50px 0 20px 0;">
        <div class="container">
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 30px;">
                <!-- Left Column -->
                <div style="flex: 1; min-width: 250px; margin-right: 20px; margin-bottom: 30px;">
                    <h3 style="font-size: 24px; margin-bottom: 15px; color: #ffffff;">LearnFlare</h3>
                    <p style="line-height: 1.6; color: #cccccc; margin-bottom: 20px;">
                        Experience premium online education with LearnFlare.
                        Explore diverse courses and gain valuable skills with our 
                        high-quality content and excellent instructors.
                    </p>
                </div>
                
                <!-- Middle Column -->
                <div style="flex: 1; min-width: 200px; margin-bottom: 30px;">
                    <h3 style="font-size: 20px; margin-bottom: 20px; color: #ffffff;">Quick Links</h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 10px;"><a href="<?php echo ROOT_URL; ?>index.php" style="color: #9b59b6; text-decoration: none; transition: color 0.3s;">Home</a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo ROOT_URL; ?>courses/search.php" style="color: #9b59b6; text-decoration: none; transition: color 0.3s;">Our Courses</a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo ROOT_URL; ?>auth/signup.php" style="color: #9b59b6; text-decoration: none; transition: color 0.3s;">Register</a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo ROOT_URL; ?>auth/login.php" style="color: #9b59b6; text-decoration: none; transition: color 0.3s;">Login</a></li>
                    </ul>
                </div>
                
                <!-- Right Column -->
                <div style="flex: 1; min-width: 250px;">
                    <h3 style="font-size: 20px; margin-bottom: 20px; color: #ffffff;">Contact Us</h3>
                    <p style="margin-bottom: 10px; display: flex; align-items: center;">
                        <i class="fas fa-map-marker-alt" style="width: 20px; margin-right: 10px; color: #9b59b6;"></i>
                        123 Learning Street, Education City
                    </p>
                    <p style="margin-bottom: 10px; display: flex; align-items: center;">
                        <i class="fas fa-phone" style="width: 20px; margin-right: 10px; color: #9b59b6;"></i>
                        (555) 123-4567
                    </p>
                    <p style="margin-bottom: 20px; display: flex; align-items: center;">
                        <i class="fas fa-envelope" style="width: 20px; margin-right: 10px; color: #9b59b6;"></i>
                        info@learnflare.com
                    </p>
                    <div style="display: flex; gap: 15px;">
                        <a href="#" style="color: #ffffff; font-size: 18px;"><i class="fab fa-facebook"></i></a>
                        <a href="#" style="color: #ffffff; font-size: 18px;"><i class="fab fa-twitter"></i></a>
                        <a href="#" style="color: #ffffff; font-size: 18px;"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <div style="border-top: 1px solid #2d3846; padding-top: 20px; text-align: center;">
                <p style="color: #8b97a8; font-size: 14px;">&copy; 2025 LearnFlare. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="<?php echo ROOT_URL; ?>assets/js/main.js"></script>
    <script>
        function toggleDropdown(event) {
            event.stopPropagation();
            var dropdown = document.getElementById("userDropdown");
            dropdown.classList.toggle("show");
            
            // Position the dropdown relative to the clicked element
            if (dropdown.classList.contains("show")) {
                var rect = event.target.getBoundingClientRect();
                dropdown.style.top = (rect.bottom + 5) + 'px';
                dropdown.style.left = (rect.right - dropdown.offsetWidth) + 'px';
            }
        }
        
        // Close the dropdown when clicking anywhere else
        window.onclick = function(event) {
            if (!event.target.matches('.user-profile') && 
                !event.target.matches('.user-icon') && 
                !event.target.matches('.user-profile span')) {
                var dropdown = document.getElementById("userDropdown");
                if (dropdown && dropdown.classList.contains("show")) {
                    dropdown.classList.remove("show");
                }
            }
        }

        // Add any additional page-specific scripts here that were passed from the page
        <?php if (isset($extraScripts)) echo $extraScripts; ?>
    </script>
</body>
</html>