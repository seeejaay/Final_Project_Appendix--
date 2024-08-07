<nav class="navbar navbar-expand-lg navbar-dark fixed-top ">
    <div class="navbar-brand" href="#">
        <a href="../index.php"><img class="img-size" src="../assets/images/logo_bg.png" alt=""></a>

    </div>
    <button class="navbar-toggler toggleNav" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="fas fa-bars"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../about.php">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-signin-modal-trigger btn-nav" id="bookingBtn" href="../client/booking.php">Booking</a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-signin-modal-trigger btn-nav" id="viewBookingBtn" href="../client/viewBooking.php">View Booking</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../contact.php">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../assets/resources/logout.php" onclick="return confirmLogout()">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<script>
    function confirmLogout() {
        return confirm("Are you sure you want to logout?");
    }
</script>