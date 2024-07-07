<?php
session_start();

// Check if the user is logged in
if ($_SESSION['loggedin'] && $_SESSION['loggedin'] === true) {
    // If the user is on the booking page, display the content
    $currentPage = basename($_SERVER['PHP_SELF']);
    if ($currentPage != 'booking.php') {

        header('Location: booking.php');
        exit;
    }
} else {
    header('Location: ../index.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking | Timless Elegance</title>

    <link rel="stylesheet" href="../assets/CSS/header.css">
    <link rel="stylesheet" href="../assets/CSS/booking.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Navbar FOR ALL-->
    <?php include '../assets/resources/header2.php'; ?>

    <main class="container-wrapper">
        <div class="top">
            <div class="title">
                <h1>Booking</h1>
            </div>
        </div>
        <section class="booking">
            <div class="booking-info">
                <div class="booking-form">
                    <form action="booking.php" method="POST">
                        <div class="form-group
                        ">
                            <label for="checkin">Check-in Date</label>
                            <input type="date" class="form-control" id="checkin" name="checkin" required>
                        </div>
                        <div class="form-group
                        ">
                            <label for="checkout">Check-out Date</label>
                            <input type="date" class="form-control" id="checkout" name="checkout" required>
                        </div>
                        <div class="form-group
                        ">
                            <label for="room">Room Type</label>
                            <select class="form-control" id="room" name="room" required>
                                <option value="standard">Standard</option>
                                <option value="deluxe">Deluxe</option>
                                <option value="premium">Premium</option>
                                <option value="executive">Executive</option>
                            </select>
                        </div>
                        <div class="form-group
                        ">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn-custom">Submit</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="./assets/JS/header.js"></script>

</html>