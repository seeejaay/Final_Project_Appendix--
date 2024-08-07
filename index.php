<?php
session_start();
include './assets/resources/login.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home | Timeless Elegance</title>
        <link rel="icon" href="./assets/images/logo_bg.png">
        <link rel="stylesheet" href="./assets/CSS/index.css">
        <link rel="stylesheet" href="./assets/CSS/header.css">
        <link rel="stylesheet" href="./assets/CSS/modal.css">
        <link rel="stylesheet" href="./assets/CSS/footer.css">
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>

        </style>
</head>

<body>
        <!-- Navbar FOR ALL-->
        <?php include './assets/resources/header.php'; ?>

        <main class="container-wrapper">
                <div class="top">
                        <div class="logo">
                                <img class="image-size" src="./assets/images/logo_bg.png" alt="Elegance Hotel">
                        </div>
                </div>
                <section class="about">
                        <div class="about-info">
                                <div class="image-left">
                                        <img class="img-left" src="./assets/images/background.webp" alt="Hotel Image">
                                </div>
                                <div class="about-text js-signin-modal-trigger">
                                        <h1>The Timeless Elegance Hotel</h1>
                                        <p>Welcome to Timeless Elegance Hotel. We offer luxury accommodations and exceptional service. Whether for business or pleasure, choose Timeless Elegance Hotel for your stay.</p>
                                        <button id="bookNowBtn" class="btn-custom" data-signin="login">Book Now</button>
                                </div>
                        </div>
                </section>
        </main>

        <footer class="footer">
                <div class="container">
                        <div class="row">
                                <div class="col-md-4">
                                        <img class="footer-logo" src="./assets/images/logo_bg.png" alt="Logo">
                                        <ul>
                                                <li style="list-style:none; text-decoration:none;"><a href="./admin/admin.php">ADMIN</a></li>
                                        </ul>
                                </div>
                                <div class="col-md-4">
                                        <h3>Contact Us</h3>
                                        <p>123 Main Street, City, Country</p>
                                        <p>Email: info@example.com</p>
                                        <p>Phone: +1 123 456 7890</p>
                                </div>
                                <div class="col-md-4">
                                        <h3>Follow Us</h3>
                                        <ul class="social-media">
                                                <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                        </ul>
                                </div>
                        </div>
                </div>
        </footer>


        <!-- Bootstrap JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <!-- JS for Index -->
        <script src="./assets/JS/index.js"></script>

        <!-- JS for Headers -->
        <script src="./assets/JS/header.js"></script>

        <!-- JS for Modal -->
        <script src="./assets/JS/modal.js"></script>
        <script src="js/placeholders.min.js"></script>




</body>

</html>

<script>
        $(document).ready(function() {
                $('#bookNowBtn').click(function() {
                        // Check if user is logged in
                        if (<?php echo isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ? 'true' : 'false'; ?>) {
                                window.location.href = './client/booking.php'; // Redirect to booking.php
                        } else {
                                $('.js-signin-modal-trigger [data-signin="login"]').click(); // Open login modal if not logged in
                        }
                });


                $('#bookingBtn').click(function() {
                        // Check if user is logged in
                        if (<?php echo isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ? 'true' : 'false'; ?>) {
                                window.location.href = './client/booking.php'; // Redirect to booking.php
                        } else {
                                $('.js-signin-modal-trigger [data-signin="login"]').click(); // Open login modal if not logged in
                        }
                });
        });
</script>