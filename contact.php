<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home | Timeless Elegance</title>
        <link rel="icon" href="./assets/images/logo_bg.png">

        <link rel="stylesheet" href="./assets/CSS/contact.css">
        <link rel="stylesheet" href="./assets/CSS/header.css">
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top ">
                <div class="navbar-brand" href="#">
                        <a href="index.php"><img class="img-size" src="./assets/images/logo_bg.png" alt=""></a>
                </div>
                <button class="navbar-toggler toggleNav" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="fas fa-bars"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                                <li class="nav-item active">
                                        <a class="nav-link" href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                        <a class="nav-link" href="about.php">About</a>
                                </li>
                                <li class="nav-item">
                                        <a class="nav-link" href="client/booking.php">Booking</a>
                                </li>
                                <li class="nav-item">
                                        <a class="nav-link" href="#">Contact</a>
                                </li>
                        </ul>

                </div>

        </nav>
        <div class="container-wrapper">
                <div class="contact">
                        <div class="row-head">
                                <h1>contact us</h1>
                        </div>
                        <div class="row">
                                <h4 style="text-align:center">We'd love to hear from you!</h4>
                        </div>
                        <div class="row input-container">
                                <div class="col-xs-12">
                                        <div class="styled-input wide">
                                                <input type="text" required />
                                                <label>Name</label>
                                        </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                        <div class="styled-input">
                                                <input type="text" required />
                                                <label>Email</label>
                                        </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                        <div class="styled-input" style="float:right;">
                                                <input type="text" required />
                                                <label>Phone Number</label>
                                        </div>
                                </div>
                                <div class="col-xs-12">
                                        <div class="styled-input wide">
                                                <textarea required></textarea>
                                                <label>Message</label>
                                        </div>
                                </div>
                                <div class="col-xs-12">
                                        <div class="btn-lrg btn-custom">Send Message</div>
                                </div>
                        </div>
                </div>
        </div>


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
</body>

<!-- Bootstrap JS-->
<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- JS for Index -->
<script src="./assets/JS/index.js"></script>

<!-- JS for Headers -->
<script src="./assets/JS/header.js"></script>

</html>