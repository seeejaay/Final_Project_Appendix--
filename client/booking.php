<?php
session_start();
include '../assets/resources/dbConfig.php'; // Include database connection

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['id']; // Assuming you have stored the user's ID in the session
    $checkinDate = $_POST['checkin'];
    $checkoutDate = $_POST['checkout'];
    $numDays = $_POST['numDays'];
    $roomType = $_POST['room'];
    $paymentMethod = $_POST['payment']; // Simulated payment method
    $paypalEmail = isset($_POST['paypalEmail']) ? $_POST['paypalEmail'] : ''; // Simulated PayPal email

    // Validate check-in date at least 2 days in advance
    $today = date('Y-m-d');
    $minCheckinDate = date('Y-m-d', strtotime($today . ' + 2 days'));

    if ($checkinDate < $minCheckinDate) {
        echo "<script>";
        echo "alert('Reservations must be made at least 2 days in advance.');";
        echo "window.location.href = 'booking.php';";
        echo "</script>";
        exit;
    }

    // Validate that check-in date is before checkout date
    if ($checkinDate >= $checkoutDate) {
        echo "<script>";
        echo "alert('Check-out date must be after check-in date.');";
        echo "window.location.href = 'booking.php';";
        echo "</script>";
        exit;
    }

    // Get all available rooms of the selected type
    $stmt = $conn->prepare("SELECT * FROM room_tb WHERE roomtype = ? AND room_id NOT IN (SELECT room_id FROM room_tb WHERE checkInDate <= ? AND checkOutDate >= ?)");
    $stmt->bind_param('sss', $roomType, $checkoutDate, $checkinDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch all available rooms
        $availableRooms = $result->fetch_all(MYSQLI_ASSOC);

        // Randomly select a room from the available rooms
        $selectedRoom = $availableRooms[array_rand($availableRooms)];
        $roomId = $selectedRoom['room_id'];
        $pricePerNight = $selectedRoom['pricePerNight'];

        // Update the room with booking information
        $stmt = $conn->prepare("UPDATE room_tb SET booked = 1, dateBooked = CURDATE(), checkInDate = ?, checkOutDate = ?, numOfNights = ?, bookedBy = ? WHERE room_id = ?");
        $stmt->bind_param('ssiii', $checkinDate, $checkoutDate, $numDays, $userId, $roomId);

        if ($stmt->execute()) {
            // Store pricePerNight in sessionStorage
            echo "<script>";
            echo "sessionStorage.setItem('pricePerNight', '$pricePerNight');";
            echo "console.log('Price per night stored in sessionStorage.');";
            echo "alert('Booking successful!');";
            echo "window.location.href = 'booking.php';"; // Redirect or update page as needed
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert('Error: " . $stmt->error . "');";
            echo "window.location.href = 'booking.php';";
            echo "</script>";
        }
    } else {
        // Room is not available
        echo "<script>";
        echo "alert('The selected room type is not available for the chosen dates.');";
        echo "window.location.href = 'booking.php';";
        echo "</script>";
    }

    $stmt->close();
    $conn->close();
}
?>




<!DOCTYPE html>
<html>

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
                    <form action="booking.php" method="POST" onsubmit="return validateForm()">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="checkin">Check-in Date</label>
                                <input type="date" class="form-control" id="checkin" name="checkin" required>
                            </div>
                            <div class="form-group">
                                <label for="checkout">Check-out Date</label>
                                <input type="date" class="form-control" id="checkout" name="checkout" required>
                            </div>
                            <div class="form-group">
                                <label for="numDays">Number of Days</label>
                                <input type="text" class="form-control" id="numDays" name="numDays" readonly>
                            </div>
                            <div class="form-group">
                                <label for="checkInTime">Check In Time</label>
                                <input type="text" class="form-control" id="checkInTime" name="checkInTime" value="10:00 A.M." readonly>
                            </div>
                            <div class="form-group">
                                <label for="checkOutTime">Check Out Time</label>
                                <input type="text" class="form-control" id="checkOutTime" name="checkOutTime" value="10:00 A.M." readonly>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="room">Room Type</label>
                            <select class="form-control" id="room" name="room" required>
                                <option value="standard">Standard</option>
                                <option value="deluxe">Deluxe</option>
                                <option value="premium">Premium</option>
                                <option value="executive">Executive</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="payment">Mode of Payment</label>
                            <select class="form-control" id="payment" name="payment" required>
                                <option value="credit">Credit Card</option>
                                <option value="debit">Debit Card</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>

                        <div id="cardFields" style="display: none;">
                            <div class="form-group">
                                <label for="cardNumber">Card Number</label>
                                <input type="number" class="form-control" id="cardNumber" name="cardNumber" required minlength="16" maxlength="16">
                            </div>
                            <div class="form-group">
                                <label for="expiry">Expiry Date</label>
                                <input type="date" class="form-control" id="expiry" name="expiry" required>
                            </div>
                            <div class="form-group">
                                <label for="securityCode">Security Code</label>
                                <input type="number" class="form-control" id="securityCode" name="securityCode" required min="100" max="999">
                            </div>
                        </div>

                        <div id="paypalFields" style="display: none;">
                            <div class="form-group">
                                <label for="paypalEmail">PayPal Email</label>
                                <input type="email" class="form-control" id="paypalEmail" name="paypalEmail">
                            </div>
                        </div>

                        <button type="submit" class=" btn-custom">Submit</button>



                    </form>
                </div>
            </div>
        </section>
    </main>

</body>
<script src=" ../assets/JS/header.js"></script>

<script src="../assets/JS/booking.js"></script>

<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</html>