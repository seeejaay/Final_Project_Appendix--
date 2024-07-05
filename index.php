<?php
include_once 'login.php';
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
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
                .modal {
                        display: none;
                        position: fixed;
                        z-index: 1;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        overflow: auto;
                        background-color: rgba(0, 0, 0, 0.4);
                        padding-top: 60px;
                }

                .modal-content {
                        background: rgba(255, 255, 255, 0.2);
                        border-radius: 16px;
                        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
                        backdrop-filter: blur(18px);
                        -webkit-backdrop-filter: blur(18px);
                        border: 1px solid rgba(255, 255, 255, 0.3);
                        margin: 5% auto;
                        padding: 20px;
                        width: 80%;
                        max-width: 400px;
                }

                .top_container {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        padding: 10px;
                }

                .close {
                        color: #fff;
                        font-size: 28px;
                        font-weight: bold;
                }

                .close:hover,
                .close:focus {
                        color: black;
                        text-decoration: none;
                        cursor: pointer;
                }

                .form-group {
                        margin-bottom: 15px;
                }

                .form-group label {
                        display: block;
                        margin-bottom: 5px;
                }

                .form-group input {
                        width: 90%;
                        padding: 10px;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                }

                .error {
                        color: red;
                        margin-top: 10px;
                        text-align: center;
                }

                .signup-link {
                        color: blue;
                        text-decoration: none;
                }

                p {
                        text-align: center;
                }

                .signup-link:hover {
                        text-decoration: underline;
                }

                .btn-login{
                        border-radius: 12px ;
                        border: 2px solid var(--browndark);
                        padding: 5px 40px ;
                        margin-bottom: 10px ;
                        font-size: 1.1rem ;
                        color: #fff ;
                        background: var(--browndark) ;
                        &:hover{
                                transform: scale(1.1);
                        }
                }
        </style>        
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
                        <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                        <button id="myBtn" class="btn btn-link nav-link">Login</button>
                        </li>
                </ul>
                </div>
        </nav>

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
                        <div class="about-text">
                        <h1>The Timeless Elegance Hotel</h1>
                        <p>Welcome to Timeless Elegance Hotel. We offer luxury accommodations and exceptional service. Whether for business or pleasure, choose Appendix Colonial Hotel for your stay.</p>
                        <button id="bookNowBtn" class="btn-custom">Book Now</button>
                        </div>
                </div>
                </section>
        </main>

        <footer class="footer">
                <div class="container">
                <div class="row">
                        <div class="col-md-4">
                        <img class="footer-logo" src="./assets/images/logo_bg.png" alt="Logo">
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

        <!-- Modal -->
        <div id="myModal" class="modal">
                <div class="modal-content">
                <div class="top_container">
                        <h1>Login</h1>
                        <div class="close">&times;</div>
                </div>
                <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn-login">Login</button>
                        <?php if (!empty($login_err)): ?>
                        <div class="error"><?php echo $login_err; ?></div>
                        <?php endif; ?>
                </form>
                <p>Don't have an account? <a href="signup.php" class="signup-link">Signup here</a></p>
                </div>
        </div>

        <!-- Bootstrap JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <!-- JS for Index -->
        <script src="./assets/JS/index.js"></script>

        <!-- JS for Headers -->
        <script src="./assets/JS/header.js"></script>

        <script>
                var modal = document.getElementById("myModal");
                var loginBtn = document.getElementById("myBtn");
                var bookNowBtn = document.getElementById("bookNowBtn");
                var span = document.getElementsByClassName("close")[0];

                loginBtn.onclick = function() {
                modal.style.display = "block";
                }

                bookNowBtn.onclick = function() {
                modal.style.display = "block";
                }

                span.onclick = function() {
                modal.style.display = "none";
                }

                window.onclick = function(event) {
                if (event.target == modal) {
                        modal.style.display = "none";
                }
                }
        </script>
</body>

</html>
